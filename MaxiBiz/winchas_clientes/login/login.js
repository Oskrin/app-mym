jQuery(function($) {
 	$(document).on('click', '.toolbar a[data-target]', function(e) {
		e.preventDefault();
		var target = $(this).data('target');
		$('.widget-box.visible').removeClass('visible'); // hide others
		$(target).addClass('visible'); //show target
 	});
});

//you don't need this, just used for changing background
jQuery(function($) {
 	$('#btn-login-dark').on('click', function(e) {
		$('body').attr('class', 'login-layout');
		$('#id-text2').attr('class', 'white');
		$('#id-company-text').attr('class', 'blue');
	
		e.preventDefault();
 	});

 	$('#btn-login-light').on('click', function(e) {
		$('body').attr('class', 'login-layout light-login');
		$('#id-text2').attr('class', 'grey');
		$('#id-company-text').attr('class', 'blue');
		
		e.preventDefault();
 	});

 	$('#btn-login-blur').on('click', function(e) {
		$('body').attr('class', 'login-layout blur-login');
		$('#id-text2').attr('class', 'white');
		$('#id-company-text').attr('class', 'light-blue');
	
		e.preventDefault();
	});
});

function redireccionar() {
	setTimeout("location.href='../'", 2000);	
}

$(function() {

	//$('#telefono').mask('(999) 999-9999');

	// funcion validar solo numeros
	function ValidNum() {
	    if (event.keyCode < 48 || event.keyCode > 57) {
	        event.returnValue = false;
	    }
	    return true;
	}
	// fin

	$("#telefono").keypress(ValidNum);
	$("#telefono").attr("maxlength", "10");

	$("#registrar").on('click', function(event) {
		event.preventDefault();
		var correo = $("#correo").val();
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

		if ($("#nombres").val() == "") {
			$("#nombres").focus();
			$.gritter.add({
		        title: 'Error... Ingrese sus Nombres',
		        class_name: 'gritter-error gritter-center',
		        time: 1000,
		    });
		} else {
			if ($("#apellidos").val() == "") {
				$("#apellidos").focus();
				$.gritter.add({
			        title: 'Error... Ingrese sus Apellidos',
			        class_name: 'gritter-error gritter-center',
			        time: 1000,
			    });
			} else {
				if ($("#direccion").val() == "") {
					$("#direccion").focus();
					$.gritter.add({
				        title: 'Error... Ingrese su Dirección',
				        class_name: 'gritter-error gritter-center',
				        time: 1000,
				    });
				} else {
					if ($("#telefono").val() == "") {
						$("#telefono").focus();
						$.gritter.add({
					        title: 'Error... Ingrese su Teléfono',
					        class_name: 'gritter-error gritter-center',
					        time: 1000,
					    });
					} else {
						if ($("#correo").val() == "") {
							$("#correo").focus();
							$.gritter.add({
						        title: 'Error... Ingrese su Correo',
						        class_name: 'gritter-error gritter-center',
						        time: 1000,
						    });
						} else {
							if(!filter.exec(correo)){
								$("#correo").focus();
								$.gritter.add({
							        title: 'Error... Ingrese un Correo Válido',
							        class_name: 'gritter-error gritter-center',
							        time: 1000,
							    });
							} else {
								if ($("#clave").val() == "") {
									$("#clave").focus();
									$.gritter.add({
								        title: 'Error... Ingrese un Password',
								        class_name: 'gritter-error gritter-center',
								        time: 1000,
								    });
								} else {
									var formData = new FormData(document.getElementById("form_clientes"));
									formData.append('Guardar', "Guardar");

									$.ajax({
								        url: "../data/clientes/app.php",
								        data: formData,
								        type: "POST",
								        contentType: false,
								        processData: false,
						  				cache: false,
						  				beforeSend: function() {
								        	$.blockUI({ 
								        		css: { backgroundColor: 'background: rgba(255,255,255,0.2);', color: '#fff', border:'2px'},
								        		message: '<h3>Enviando información, Por favor espere un momento...'
						                                        +'<span class="loader animated fadeIn handle ui-sortable-handle">'
						                                        +'<span class="spinner">'
						                                            +'<i class="fa fa-spinner fa-spin"></i>'
						                                        +'</span>'
						                                        +'</span>'
						                                  +'</h3>'
								        	});
								        },
								        success: function(data) {
								        	$.unblockUI();
								        	//console.log(data)
								        	//if(data == '1') {
								        		swal({
												    title: "Buen trabajo! estimado/a ",
												    text: "Su registro fue exitoso, por favor verifique su correo electrónico para activar su cuenta!",
												    type: "success"
												},function () {
													location.reload(true);
													//window.location.href = "registro.php";
												});
								        		/*$.gritter.add({
													title: 	'<span>Mensaje de Información </span>',
													text: 	'<span class=""></span>'
															+' <span> Registro Agregado Correctamente</span>',
													image: 	'dist/images/file_ok-1.png', 
													sticky: false,											
												});*/ 
									    	//}              
								        },
								        error: function (xhr, status, errorThrown) {
									        //alert("Hubo un problema!");
									        //console.log("Error: " + errorThrown);
									        //console.log("Status: " + status);
									        //console.dir(xhr);
								        }
								    });
								}
							}
						}
					}
				}
			}
		}
	});
	
	$('#form_proceso').validate({
		errorElement: 'div',
		errorClass: 'help-block',
		focusInvalid: false,
		ignore: "",
		rules: {
			txt_nombre: {
				required: true				
			},
			txt_clave: {
				required: true				
			}			
		},
		messages: {
			txt_nombre: {
				required: "Por favor, Digíte nombre de usuario"
			},
			txt_clave: {
				required: "Por favor, Digíte password / clave"
			}			
		},
		highlight: function (e) {
			$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
		},
		success: function (e) {
			$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
			$(e).remove();
		},
		errorPlacement: function (error, element) {
			if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
				var controls = element.closest('div[class*="col-"]');
				if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
				else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
			}
			else if(element.is('.select2')) {
				error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
			}
			else if(element.is('.chosen-select')) {
				error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
			}
			else error.insertAfter(element.parent());
		},

		submitHandler: function (form) {
			var form = $("#form_proceso");
			$.ajax({
				url:'../data/clientes/app.php',
				type:'POST',
				dataType:'json',
				data:{Login:'Login',username:$('#txt_nombre').val(),password:$('#txt_clave').val(),tipo_ingreso: 'Cliente'},
				success:function(data) {
					console.log(data)
					if (data['status'] == 'okcliente') {
						localStorage.setItem("id_persona", data['id']);
						localStorage.setItem("nombres", data['name']);
						localStorage.setItem("apellidos", data['apellido']);

						$.blockUI({ css: { 
				            border: 'none', 
				            padding: '10px',
				            backgroundColor: '#000', 
				            '-webkit-border-radius': '10px', 
				            '-moz-border-radius': '10px', 
				            opacity: 0.5, 
				            color: '#fff' 
				        	},
				            message: '<h4><img style="width:100px;border-radius: 50%;" />     BIENVENIDO: <span>'+data['name']+'</h4>',
				    	});

				    	//Lockr.set('users', data['privilegio']);
						redireccionar();
					};
					if (data['status'] == 'error') {
						$.blockUI({ css: { 
				            border: 'none', 
				            padding: '10px',
				            backgroundColor: '#000', 
				            '-webkit-border-radius': '10px', 
				            '-moz-border-radius': '10px', 
				            opacity: 0.5, 
				            color: '#fff' 
				        	},
				            message: '<h4><img style="width:100px;border-radius: 50%;" src="../data/usuarios/fotos/user_error.png" />     DATOS INCORRECTOS</h4>',
				    	});	
				    	setTimeout(function() {$.unblockUI();}, 2000);
						//Limpiar formulario
						$('#form_proceso').each (function() {
						  	this.reset();
						});
					};
				}
			});
		},
		invalidHandler: function (form) {
			console.log('proceso invalido'+form)
		}
	});
});