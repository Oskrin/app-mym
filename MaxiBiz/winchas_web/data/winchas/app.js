app.controller('winchasController', function ($scope, $route, loaddatosSRI) {
	
	$scope.$route = $route;

	jQuery(function($) {

		// tooltip
		$('[data-toggle="tooltip"]').tooltip(); 
		// fin

		// estilos file
		$("#file_1").ace_file_input('reset_input');
		// fin

		// estilos select2
		$(".select2").css({
			width: '100%',
		    allow_single_deselect: true,
		    no_results_text: "No se encontraron resultados",
		}).select2().on("change", function(e) {
			$(this).closest('form').validate().element($(this));
	    });

		$("#select_responsable").select2({
		  	allowClear: true 
		});
		// fin

		// tabs
		$( "#tabWincha" ).click(function(event) {
			event.preventDefault();  
		});	

		$("#tabWincha").on('shown.bs.tab', function(e) {
			$('.chosen-select').each(function() {
				var $this = $(this);
				$this.next().css({'width': $this.parent().width()});
			})	
		});
		// fin		

		if(!ace.vars['touch']) {			
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize		
			$(window).off('resize.chosen').on('resize.chosen', function() {
				$('.chosen-select').each(function() {
					var $this = $(this);
					$this.next().css({'width': $this.parent().width()});
				})
			}).trigger('resize.chosen');
			//resize chosen on sidebar collapse/expand
			$(document).on('settings.ace.chosen', function(e, event_name, event_val) {					
				if(event_name != 'sidebar_collapsed') return;
				$('.chosen-select').each(function() {
					var $this = $(this);
					$this.next().css({'width': $this.parent().width()});
				});
			});

			$('#file_1').ace_file_input({
				no_file:'Selecione un archivo ...',
				btn_choose:'Selecionar',
				btn_change:'Cambiar',
				droppable:false,
				onchange:null,
				thumbnail:false
			});
		}

		// Visualizar imagen
		$(function() {
		    Test = {
		        UpdatePreview: function(obj) {
		            if(!window.FileReader){
		            // don't know how to proceed to assign src to image tag
		            } else {
		                var reader = new FileReader();
		                var target = null;
		                reader.onload = function(e) {
		                    target =  e.target || e.srcElement;
		                    $("#logo").prop("src", target.result);
		                };
		                reader.readAsDataURL(obj.files[0]);
		            }
		        }
		    };
		});
		// fin
	
		//validacion formulario tecnicos
		$('#form_winchas').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: false,
			ignore: "",
			rules: {
				modelo: {
					required: true				
				},
				detalle: {
					required: true				
				},
				placa: {
					required: true				
				},
				servicio: {
					required: true				
				},
				select_responsable: {
					required: true				
				},
			},
			messages: {
				modelo: {
					required: "Por favor, Indique un Modelo",
				},
				detalle: {
					required: "Por favor, Indique un Detalle",
				},
				placa: { 	
					required: "Por favor, Indique una Placa",			
				},
				servicio: {
					required: "Por favor, Indique Servicio",
				},
				select_responsable: {
					required: "Por favor, Seleccione un Responsable",
				},
			},
			//para prender y apagar los errores
			highlight: function(e) {
				$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
			},
			success: function(e) {
				$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
				$(e).remove();
			},
			submitHandler: function(form) {}
		});
		// Fin 

		// recargar formulario
		function redireccionar() {
			setTimeout(function() {
			    location.reload(true);
			}, 1000);
		}
		// fin

		// llenar combo provincia
		function llenar_select_reponsable() {
			$.ajax({
				url: 'data/winchas/app.php',
				type: 'post',
				data: {llenar_responsable:'llenar_responsable'},
				success: function(data) {
					$('#select_responsable').html(data);
				}
			});
		}
		// fin

		// inicio
		llenar_select_reponsable();
		$('#btn_1').attr('disabled', true);
		$('#btn_4').attr('disabled', true);
    	$("#logo").attr("src", "data/winchas/fotos/defaul.jpg");
    	// fin

		// guardar formulario
		$('#btn_0').click(function() {
			var respuesta = $('#form_winchas').valid();
			
			if (respuesta == true) {
				$('#btn_0').attr('disabled', true); 
				var formData = new FormData(document.getElementById("form_winchas"));
				formData.append('Guardar', "Guardar");

				$.ajax({
			        url: "data/winchas/app.php",
			        data: formData,
			        type: "POST",
			        contentType: false,
			        processData: false,
	  				cache: false,
			        success: function(data) {
			        	if(data == '1') {
			        		$.gritter.add({
								title: 	'<span>Mensaje de Información </span>',
								text: 	'<span class=""></span>'
										+' <span> Registro Agregado Correctamente</span>',
								image: 	'dist/images/file_ok-1.png', 
								sticky: false,											
							});
							redireccionar();
				    	}              
			        },
			        error: function(xhr, status, errorThrown) {
				        alert("Hubo un problema!");
				        console.log("Error: " + errorThrown);
				        console.log("Status: " + status);
				        console.dir(xhr);
			        }
			    });
			}		 
		});
		// fin

		// modificar formulario
		$('#btn_1').click(function() {
			var respuesta = $('#form_winchas').valid();

			if (respuesta == true) {
				$('#btn_1').attr('disabled', true);
				var formData = new FormData(document.getElementById("form_winchas"));
				formData.append('Modificar', "Modificar");

				$.ajax({
			        url: "data/winchas/app.php",
			        data: formData,
			        type: "POST",
			        contentType: false,
			        processData: false,
	  				cache: false,
			        success: function(data) {
			        	if(data == '2') {
			        		$.gritter.add({
								title: 	'<span>Mensaje de Información </span>',
								text: 	'<span class=""></span>'
										+' <span> Registro Modificado Correctamente</span>',
								image: 	'dist/images/file_ok-1.png', 
								sticky: false,											
							});
							redireccionar();
				    	}              
			        },
			        error: function(xhr, status, errorThrown) {
				        alert("Hubo un problema!");
				        console.log("Error: " + errorThrown);
				        console.log("Status: " + status);
				        console.dir(xhr);
			        }
			    });
			}
		});
		// fin

		// abrir modal
		$('#btn_2').click(function() {
			$('#myModal').modal('show');
		});
		// fin

		// refrescar formulario
		$('#btn_3').click(function() {
			location.reload(true);
		});
		// fin

		// eliminar formulario
		$('#btn_4').click(function() {
			var respuesta = $('#form_winchas').valid();

			if (respuesta == true) {
				$('#btn_4').attr('disabled', true);
				var formData = new FormData(document.getElementById("form_winchas"));
				formData.append('Eliminar', "Eliminar");

				$.ajax({
			        url: "data/winchas/app.php",
			        data: formData,
			        type: "POST",
			        contentType: false,
			        processData: false,
	  				cache: false,
			        success: function(data) {
			        	console.log(data)
			        	if(data == "4") {
			        		$.gritter.add({
								title: 	'<span>Mensaje de Información </span>',
								text: 	'<span class=""></span>'
										+' <span> Registro Eliminado Correctamente</span>',
								image: 	'dist/images/file_ok-1.png', 
								sticky: false,											
							});
							redireccionar();
				    	}              
			        },
			        error: function(xhr, status, errorThrown) {
				        alert("Hubo un problema!");
				        console.log("Error: " + errorThrown);
				        console.log("Status: " + status);
				        console.dir(xhr);
			        }
			    });
			}
		});
		// fin

		/*jqgrid*/    
		jQuery(function($) {
		    var grid_selector = "#table";
		    var pager_selector = "#pager";
		    
		    //cambiar el tamaño para ajustarse al tamaño de la página
		    $(window).on('resize.jqGrid', function() {        
		        $(grid_selector).jqGrid('setGridWidth', $("#myModal .modal-dialog").width()-30);
		    });
		    //cambiar el tamaño de la barra lateral collapse/expand
		    var parent_column = $(grid_selector).closest('[class*="col-"]');
		    $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
		        if(event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed') {
		            //para dar tiempo a los cambios de DOM y luego volver a dibujar!!!
		            setTimeout(function() {
		                $(grid_selector).jqGrid('setGridWidth', parent_column.width());
		            }, 0);
		        }
		    });

		    // buscador tecnicos
		    jQuery(grid_selector).jqGrid({	        
		        datatype: "xml",
		        url: 'data/winchas/xml_winchas.php',        
		        colNames: ['ID','MODELO','SERVICIO','PLACA','RESPONSABLE','IMAGEN','','ESTADO'],
		        colModel:[      
		            {name:'id',index:'id', frozen:true, align:'left', search:false, hidden: true},
		            {name:'modelo',index:'modelo',frozen : true, hidden: false, align:'left',search:true,width:''},
		            {name:'servicio',index:'servicio',frozen : true, hidden: false, align:'left',search:true,width:350},
		            {name:'placa',index:'placa',frozen : true, hidden: false, align:'left',search:false,width:''},
		            {name:'responsable',index:'responsable',frozen : true, hidden: true, align:'left',search:false,width:''},
		            {name:'imagen',index:'imagen',frozen : true, hidden: true, align:'left',search:false,width:''},
		            {name:'estado',index:'estado',frozen : true, hidden: true, align:'left',search:false,width:''},
		            {name:'accion',index:'accion',frozen : true, hidden: false, align:'center',search:false,width:'150'},
		        ],          
		        rowNum: 10,
		        height: 350,
		        rowList: [10,20,30],
		        pager: pager_selector,        
		        sortname: 'id',
		        sortorder: 'asc',
		        shrinkToFit: false,
		        altRows: true,
		        multiselect: false,
		        multiboxonly: true,
		        viewrecords: true,
		        loadComplete: function() {
		            var table = this;
		            setTimeout(function() {
		                styleCheckbox(table);
		                updateActionIcons(table);
		                updatePagerIcons(table);
		                enableTooltips(table);
		            }, 0);
		        },
		        ondblClickRow: function(rowid) {     	            	            
		            var gsr = jQuery(grid_selector).jqGrid('getGridParam','selrow');                                              
	            	var ret = jQuery(grid_selector).jqGrid('getRowData',gsr);

	            	$('#id').val(ret.id);
	            	$('#modelo').val(ret.modelo);
	            	$('#detalle').val(ret.servicio);
	            	$('#placa').val(ret.placa);
	            	$("#select_responsable").select2('val', ret.responsable).trigger("change");
	            	$("#logo").attr("src", "data/winchas/fotos/"+ ret.imagen);       
	
		            $('#myModal').modal('hide'); 
		            $('#btn_0').attr('disabled', true); 
		            $('#btn_1').attr('disabled', false);
		            $('#btn_4').attr('disabled', false); 	            
		        },
		        editurl: "data/winchas/app.php",
		        caption: "LISTA WINCHAS"
		    });
	
		    $(window).triggerHandler('resize.jqGrid'); // cambiar el tamaño para hacer la rejilla conseguir el tamaño correcto

		    function aceSwitch(cellvalue, options, cell) {
		        setTimeout(function() {
		            $(cell).find('input[type=checkbox]')
		            .addClass('ace ace-switch ace-switch-5')
		            .after('<span class="lbl"></span>');
		        }, 0);
		    }	    	   

		    jQuery(grid_selector).jqGrid('navGrid', pager_selector, {   
		        edit: false,
		        editicon: 'ace-icon fa fa-pencil blue',
		        add: false,
		        addicon: 'ace-icon fa fa-plus-circle purple',
		        del: false,
		        delicon: 'ace-icon fa fa-trash-o red',
		        search: true,
		        searchicon: 'ace-icon fa fa-search orange',
		        refresh: true,
		        refreshicon: 'ace-icon fa fa-refresh green',
		        view: true,
		        viewicon: 'ace-icon fa fa-search-plus grey'
		    },
		    {	        
		        recreateForm: true,
		        beforeShowForm: function(e) {
		            var form = $(e[0]);
		            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
		            style_edit_form(form);
		        }
		    },
		    {
		        closeAfterAdd: true,
		        recreateForm: true,
		        viewPagerButtons: false,
		        beforeShowForm: function(e) {
		            var form = $(e[0]);
		            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
		            .wrapInner('<div class="widget-header" />')
		            style_edit_form(form);
		        }
		    },
		    {
		        recreateForm: true,
		        beforeShowForm: function(e) {
		            var form = $(e[0]);
		            if(form.data('styled')) return false;      
		            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
		            style_delete_form(form); 
		            form.data('styled', true);
		        },
		        onClick: function(e) {}
		    },
		    {
		        recreateForm: true,
		        afterShowSearch: function(e) {
		            var form = $(e[0]);
		            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
		            style_search_form(form);
		        },
		        afterRedraw: function() {
		            style_search_filters($(this));
		        },

		        //multipleSearch: true
		        overlay: false,
		        sopt: ['eq', 'cn'],
	            defaultSearch: 'eq',            	       
		    },
		    {
		        //view record form
		        recreateForm: true,
		        beforeShowForm: function(e) {
		            var form = $(e[0]);
		            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
		        }
		    })

		    function style_edit_form(form) {
		        form.find('input[name=sdate]').datepicker({format:'yyyy-mm-dd' , autoclose:true})
		        form.find('input[name=stock]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');

		        var buttons = form.next().find('.EditButton .fm-button');
		        buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
		        buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
		        buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>')
		        
		        buttons = form.next().find('.navButton a');
		        buttons.find('.ui-icon').hide();
		        buttons.eq(0).append('<i class="ace-icon fa fa-chevron-left"></i>');
		        buttons.eq(1).append('<i class="ace-icon fa fa-chevron-right"></i>');       
		    }

		    function style_delete_form(form) {
		        var buttons = form.next().find('.EditButton .fm-button');
		        buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
		        buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
		        buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
		    }
		    
		    function style_search_filters(form) {
		        form.find('.delete-rule').val('X');
		        form.find('.add-rule').addClass('btn btn-xs btn-primary');
		        form.find('.add-group').addClass('btn btn-xs btn-success');
		        form.find('.delete-group').addClass('btn btn-xs btn-danger');
		    }

		    function style_search_form(form) {
		        var dialog = form.closest('.ui-jqdialog');
		        var buttons = dialog.find('.EditTable')
		        buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
		        buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
		        buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
		    }
		    
		    function beforeDeleteCallback(e) {
		        var form = $(e[0]);
		        if(form.data('styled')) return false; 
		        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
		        style_delete_form(form);
		        form.data('styled', true);
		    }
		    
		    function beforeEditCallback(e) {
		        var form = $(e[0]);
		        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
		        style_edit_form(form);
		    }

		    function styleCheckbox(table) {}
		    
		    function updateActionIcons(table) {}
		    
		    function updatePagerIcons(table) {
		        var replacement = {
		            'ui-icon-seek-first' : 'ace-icon fa fa-angle-double-left bigger-140',
		            'ui-icon-seek-prev' : 'ace-icon fa fa-angle-left bigger-140',
		            'ui-icon-seek-next' : 'ace-icon fa fa-angle-right bigger-140',
		            'ui-icon-seek-end' : 'ace-icon fa fa-angle-double-right bigger-140'
		        };
		        $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function() {
		            var icon = $(this);
		            var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
		            if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
		        })
		    }

		    function enableTooltips(table) {
		        $('.navtable .ui-pg-button').tooltip({container:'body'});
		        $(table).find('.ui-pg-div').tooltip({container:'body'});
		    }

		    $(document).one('ajaxloadstart.page', function(e) {
		        $(grid_selector).jqGrid('GridUnload');
		        $('.ui-jqdialog').remove();
		    });
		});
		// fin
	});
});