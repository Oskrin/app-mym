<?php 
	session_start();
	if(!$_SESSION) {
		header('Location: login/');
	}
?> 
<!DOCTYPE html>
<html ng-app="scotchApp" lang="es">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>.:WINCHAS.:</title>
		<meta name="description" content="3 styles with inline editable feature" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="dist/css/font-awesome.min.css" />
		<link rel="stylesheet" href="dist/css/style.css" />

		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="dist/css/animate.min.css" />
		<link rel="stylesheet" href="dist/css/jquery.gritter.min.css" />
		<link rel="stylesheet" href="dist/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="dist/css/chosen.min.css" />
		<link rel="stylesheet" href="dist/css/select2.min.css" />
		<link rel="stylesheet" href="dist/css/bootstrap-multiselect.min.css" />
		<link rel="stylesheet" href="dist/css/ui.jqgrid.min.css" />
		<link rel="stylesheet" href="dist/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="dist/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="dist/css/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" href="dist/css/bootstrap-datetimepicker-standalone.css" />
		<link rel="stylesheet" href="dist/css/bootstrap-editable.min.css" />
		<link rel="stylesheet" href="dist/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="dist/css/sweetalert.css" />

		<link rel="stylesheet" href="dist/css/jquery-ui.custom.min.css" />
		<link href="dist/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
		
		<!-- text fonts -->
		<link rel="stylesheet" href="dist/css/fontdc.css" />
		<!-- ace styles -->
		<link rel="stylesheet" href="dist/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
		<script src="dist/js/ace-extra.min.js"></script>
		<script src="dist/js/mousetrap.min.js"></script>

		<!-- Angular js -->
		<script src="dist/angular-1.5.0/angular.js"></script>
		<script src="dist/angular-1.5.0/angular-route.js"></script>
		<script src="dist/angular-1.5.0/angular-animate.js"></script>
		<script src="dist/angular-1.5.0/ui-bootstrap-tpls-1.1.2.min.js"></script>
		<script src="dist/angular-1.5.0/angular-resource.js"></script>
		<script src="dist/js/ngStorage.min.js"></script>

		<!-- controlador procesos angular -->
  		<script src="data/app.js"></script>
  		<script src="data/inicio/app.js"></script>
  		<script src="data/empresa/app.js"></script>
  		<script src="data/cargos/app.js"></script>
  		<script src="data/servicios/app.js"></script>
  		<script src="data/clientes/app.js"></script>
  		<script src="data/empleados/app.js"></script>
  		<script src="data/winchas/app.js"></script>
  		<script src="data/disponibles/app.js"></script>
  		<script src="data/perfil/app.js"></script>
  		<script src="data/usuarios/app.js"></script>
  		<script src="data/privilegios/app.js"></script>
  		<script src="data/cuenta/app.js"></script>

  		<style type="text/css">
			#floating-panel {
			 	position: absolute;
			 	top: 10px;
			 	left: 15%;
				z-index: 5;
				padding: 5px;
			  	text-align: center;
			  	line-height: 30px;
			  	padding-left: 10px;
			}

			#instructions li {
			  	display:none;
			}

			#map_canvas {
			  	width: 100%;
			  	height: 350px;
			  	float: left;
			  	border: 4px solid #FF6600;
			}

			#directions_panel {
			  	width: 32%;
			  	height: 350px;
			  	float: right;
			  	overflow: auto;
			  	font-size: 1em;
			}
		</style>
	</head>

	<body ng-controller="mainController" class="no-skin">
		<div id="navbar" class="navbar navbar-default navbar-fixed-top">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>
			<div class="navbar-container" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							WINCHAS EL VENEZOLANO
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="">
							<a data-toggle="dropdown" class="dropdown-toggle" href="">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important">{{notificaciones_general}}</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									{{notificaciones}} Notificaciones
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar navbar-pink" ng-repeat="data in datos">
										<li>
											<a href="" ng-click="abrir_modal(data.id)">
												<div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs btn-primary fa fa-user"></i>
														{{data.nombres}} {{data.apellidos}}
													</span>
												</div>
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</li>

						<li class="light-blue">
							<a data-toggle="dropdown" href="" class="dropdown-toggle">
								<img class="nav-user-photo" src=<?php  print_r('data/usuarios/fotos/'. $_SESSION['user']['imagen']); ?> alt="" />
								<span class="user-info">
									<small>Bienvenido,</small>
									<?php print_r($_SESSION['user']['name']); ?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#/cuenta">
										<i class="ace-icon fa fa-user"></i>
										Cuenta
									</a>
								</li>

								<li>
									<a href="#/privilegios">
										<i class="ace-icon fa fa-unlock"></i>
										Privilegios
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="login/exit.php">
										<i class="ace-icon fa fa-power-off"></i>
										Salir
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				<ul class="nav nav-list">
					<li ng-class="{active: $route.current.activetab == 'inicio'}">
						<a href="#/">
							<i class="menu-icon fa fa-home"></i>
							<span class="menu-text"> Inicio </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li ng-class = "{'active open': 
												$route.current.activetab == 'empresa'
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-building"></i>
							Empresa
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'empresa'}">
								<a href="#/empresa">
									<i class="menu-icon fa fa-caret-right"></i>
									Registro Empresa
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li ng-class = "{'active open': 
												$route.current.activetab == 'cargos' ||
												$route.current.activetab == 'servicios' ||
												$route.current.activetab == 'clientes' || 
												$route.current.activetab == 'empleados' ||
												$route.current.activetab == 'winchas' 
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								Ingresos
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'cargos'}">
								<a href="#/cargos">
									<i class="menu-icon fa fa-caret-right"></i>
									Cargos
								</a>
								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'servicios'}">
								<a href="#/servicios">
									<i class="menu-icon fa fa-caret-right"></i>
									Servicios
								</a>
								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'clientes'}">
								<a href="#/clientes">
									<i class="menu-icon fa fa-caret-right"></i>
									Clientes
								</a>
								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'empleados'}">
								<a href="#/empleados">
									<i class="menu-icon fa fa-caret-right"></i>
									Empleados
								</a>
								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'winchas'}">
								<a href="#/winchas">
									<i class="menu-icon fa fa-caret-right"></i>
									Winchas
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li ng-class="{active: $route.current.activetab == 'disponibles'}">
						<a href="#/disponibles">
							<i class="menu-icon fa fa-car"></i>
							<span class="menu-text">
								Disponibles
							</span>
						</a>
						<b class="arrow"></b>
					</li>

					<li ng-class = "{'active open': 
												$route.current.activetab == 'perfil' ||
												$route.current.activetab == 'privilegios' ||
												$route.current.activetab == 'usuarios'
												
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-users"></i>
							Usuarios
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'perfil'}">
								<a href="#/perfil">
									<i class="menu-icon fa fa-caret-right"></i>
									Perfil
								</a>
								<b class="arrow"></b>
							</li>

							<!--<li ng-class="{active: $route.current.activetab == 'privilegios'}">
								<a href="#/privilegios">
									<i class="menu-icon fa fa-caret-right"></i>
									Privilegios
								</a>
								<b class="arrow"></b>
							</li>-->

							<li ng-class="{active: $route.current.activetab == 'usuarios'}">
								<a href="#/usuarios">
									<i class="menu-icon fa fa-caret-right"></i>
									Registro Usuario
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li>
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-archive"></i>
							<span class="menu-text">
								Reportes
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li>
								<a href="data/reportes/reporte_empleados.php" target="_blank">
									<i class="menu-icon fa fa-file-pdf-o red2"></i>
									Reporte Empleados
								</a>
							</li>

							
						</ul>
					</li>
				</ul>

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModalMapa">
				    <div class="modal-dialog modal-lg">
					    <div class="modal-content">
					        <div class="modal-header">
					          	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					          	<h4 class="modal-title">UBICACIÓN NOTIFICACION</h4>
					        </div>

					        <div class="modal-body">
					            <form class="form-horizontal" name="form_factura" id="form_factura" autocomplete="off">
					            	<div class="row">
					            		<div class="col-sm-12">
					            			<div class="col-sm-6">
						            			<div class="form-group">
													<label class="control-label col-sm-4 no-padding-right bolder">CLIENTE.:</label>
													<div class="col-sm-8">
														<div class="clearfix">
															<p style="margin-top: 5px">{{nombres}} {{apellidos}}</p>
														</div>
													</div>
												</div>
											</div>
					            		</div>

					            		<div class="col-sm-12">
					            			<div class="col-sm-6">
						            			<div class="form-group">
													<label class="control-label col-sm-4 no-padding-right bolder">SERVICIO.:</label>
													<div class="col-sm-8">
														<div class="clearfix">
															<p style="margin-top: 5px">{{servicio}}</p>
														</div>
													</div>
												</div>
											</div>
					            		</div>

					            		<div class="col-sm-12">
					            			<div class="col-sm-6">
						            			<div class="form-group">
													<label class="control-label col-sm-4 no-padding-right bolder">FECHA.:</label>
													<div class="col-sm-8">
														<div class="clearfix">
															<p style="margin-top: 5px">{{fecha}}</p>
														</div>
													</div>
												</div>
											</div>
					            		</div>

				            			<div class="col-sm-12">
						            		<h1>MAPA</h1>
						            		<div id="map_canvas"></div>
											<!--<div id="directions_panel"></div>-->
										</div>
					            	</div>	
					            </form> 
					        </div>

					        <div class="modal-footer">
					          	<button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle='tooltip' title='Cerrar Ventana'>Cerrar</button>
					        </div>
					    </div>
				    </div>
				</div>

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

			<div class="main-content ng-view" id="main-container"></div>

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							Applicación &copy; 2018
						</span>
					</div>
				</div>
			</div>

			<a href="" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div>

		<script type="text/javascript">
			window.jQuery || document.write("<script src='dist/js/jquery.min.js'>"+"<"+"/script>");
		</script>

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='dist/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		
		<script src="dist/js/jquery-ui.min.js"></script>
		<script src="dist/js/jquery.ui.touch-punch.min.js"></script>
		<script src="dist/js/jquery.easypiechart.min.js"></script>
		<script src="dist/js/jquery.sparkline.min.js"></script>
    	<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>

		<script src="dist/js/fileinput.js" type="text/javascript"></script>
		<script src="dist/js/bootstrap.min.js"></script>
		<script src="dist/js/jquery.form.js"></script>
		<script src="dist/js/chosen.jquery.min.js"></script>

		<script src="dist/js/jquery.validate.min.js"></script>
		<script src="dist/js/jquery.gritter.min.js"></script>
		<script src="dist/js/bootbox.min.js"></script>
		<script src="dist/js/fuelux/fuelux.wizard.min.js"></script>
		<script src="dist/js/additional-methods.min.js"></script>
		
		<script src="dist/js/jquery.hotkeys.min.js"></script>
		<script src="dist/js/bootstrap-wysiwyg.min.js"></script>
		<script src="dist/js/select2.min.js"></script>
		<script src="dist/js/bootstrap-multiselect.min.js"></script>
		<script src="dist/js/fuelux/fuelux.spinner.min.js"></script>
		<script src="dist/js/fuelux/fuelux.tree.min.js"></script>
		<script src="dist/js/x-editable/bootstrap-editable.min.js"></script>
		<script src="dist/js/x-editable/ace-editable.min.js"></script>
		<script src="dist/js/jquery.maskedinput.min.js"></script>
		<script src="dist/js/bootbox.min.js"></script>
		<script src="dist/js/date-time/bootstrap-datepicker.min.js"></script>
		<script src="dist/js/date-time/bootstrap-timepicker.min.js"></script>
		<script src="dist/js/date-time/moment.min.js"></script>
		<script src="dist/js/date-time/daterangepicker.min.js"></script>
		<script src="dist/js/date-time/bootstrap-datetimepicker.min.js"></script>
		
		<!-- script de las tablas -->
		<script src="dist/js/jqGrid/jquery.jqGrid.min.js"></script>
		<script src="dist/js/jqGrid/i18n/grid.locale-en.js"></script>
		<script src="dist/js/dataTables/jquery.dataTables.min.js"></script>
		<script src="dist/js/dataTables/jquery.dataTables.bootstrap.min.js"></script>
		<script src="dist/js/dataTables/dataTables.tableTools.min.js"></script>
		<script src="dist/js/dataTables/dataTables.colVis.min.js"></script>

		<!-- ace scripts -->
		<script src="dist/js/ace-elements.min.js"></script>
		<script src="dist/js/ace.min.js"></script>
		<script src="dist/js/lockr.min.js"></script>
		<script src="dist/js/sweetalert.min.js"></script>
		<script src="dist/js/jquery.blockUI.js"></script>
		<script src="dist/js/gmaps.js"></script>
		
    	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVZYL8b1_XSkZ6XIbbgEY9b0jsC1CiVeU&libraries=adsense&language=es"></script>
	</body>
</html>
