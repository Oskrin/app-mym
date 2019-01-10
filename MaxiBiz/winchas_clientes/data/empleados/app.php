<?php 
	if(!isset($_SESSION)){
    session_start();        
  }
  include_once('../../admin/datos_cedula.php');
	include_once('../../admin/class.php');
	include_once('../../admin/correolocal.php');
	$class = new constante();
	//error_reporting(0);

	$fecha = $class->fecha_hora();

	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin");

	// Guardar empleados
	if (isset($_POST['Guardar']) == "Guardar") {
		// contador empleados
		$id_empleados = 0;
		$resultado = $class->consulta("SELECT max(id) FROM empleados");
		while ($row = $class->fetch_array($resultado)) {
			$id_empleados = $row[0];
		}
		$id_empleados++;
		// fin

		if(isset($_FILES["file_1"])) {
			$temporal = $_FILES['file_1']['tmp_name'];
            $extension = explode(".",  $_FILES['file_1']['name']); 
            $extension = end($extension);                    			            
            $nombre = $id_empleados.".".$extension;
            $destino = "/fotos/".$nombre;			            
            $root = getcwd();	
            if(move_uploaded_file($temporal, $root.$destino)) {
            	$dirFoto = $nombre;
            } else {
            	$dirFoto = "defaul.jpg";	
            }      	
		}

		//Se define una cadena de caractares. Te recomiendo que uses esta.
	    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	    //Obtenemos la longitud de la cadena de caracteres
	    $longitudCadena = strlen($cadena);
	     
	    //Se define la variable que va a contener la contraseña
	    $pass = "";
	    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
	    $longitudPass = 5;
	     
	    //Creamos la contraseña
	    for($i = 1 ; $i <= $longitudPass ; $i++) {
	        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
	        $pos = rand(0,$longitudCadena-1);
	     
	        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
	        $pass .= substr($cadena,$pos,1);
	    }

	    $cargos = $_POST['select_cargo'];
	    $servicios = $_POST['select_servicio'];

	    for ($i=0; $i<count($cargos); $i++) {
	    	// contador relacion_cargos
			$id_relacion_cargos = 0;
			$resultado = $class->consulta("SELECT max(id) FROM relacion_cargos");
			while ($row = $class->fetch_array($resultado)) {
				$id_relacion_cargos = $row[0];
			}
			$id_relacion_cargos++;
			// fin

            //echo $combo[$i];

            $class->consulta("INSERT INTO relacion_cargos VALUES (	'$id_relacion_cargos',
            														'$id_empleados',
            														'$cargos[$i]',
            														'1', 
																	'$fecha')");
        }

	    for ($i=0; $i<count($servicios); $i++) {
	    	// contador relacion_servicios
			$id_relacion_servicios = 0;
			$resultado = $class->consulta("SELECT max(id) FROM relacion_servicios");
			while ($row = $class->fetch_array($resultado)) {
				$id_relacion_servicios = $row[0];
			}
			$id_relacion_servicios++;
			// fin

            $class->consulta("INSERT INTO relacion_servicios VALUES (	'$id_relacion_servicios',
	            														'$id_empleados',
	            														'$servicios[$i]',
	            														'1', 
																		'$fecha')");
        }

		$class->consulta("INSERT INTO empleados VALUES (	'$id_empleados',
															'$_POST[identificacion]',
															'$_POST[nombres_completos]',
															'$_POST[telefono1]',
															'$_POST[telefono2]',
															'$_POST[select_ciudad]',
															'$_POST[direccion]',
															'$_POST[correo]',
															'$dirFoto',
															'$_POST[observaciones]',
															'$pass',
															'1', 
															'$fecha')");

		$nombre = $_POST['nombres_completos'];
		$correo = $_POST['correo'];

		$contenido_html = '
        <!doctype html>
        <html xmlns="http://www.w3.org/1999/xhtml">
             <head>
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
              <meta name="viewport" content="initial-scale=1.0" />
              <meta name="format-detection" content="telephone=no" />
              <title></title>
              <style type="text/css">
                body {
                  width: 100%;
                  margin: 0;
                  padding: 0;
                  -webkit-font-smoothing: antialiased;
                }
                @media only screen and (max-width: 600px) {
                  table[class="table-row"] {
                    float: none !important;
                    width: 98% !important;
                    padding-left: 20px !important;
                    padding-right: 20px !important;
                  }
                  table[class="table-row-fixed"] {
                    float: none !important;
                    width: 98% !important;
                  }
                  table[class="table-col"], table[class="table-col-border"] {
                    float: none !important;
                    width: 100% !important;
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                    table-layout: fixed;
                  }
                  td[class="table-col-td"] {
                    width: 100% !important;
                  }
                  table[class="table-col-border"] + table[class="table-col-border"] {
                    padding-top: 12px;
                    margin-top: 12px;
                    border-top: 1px solid #E8E8E8;
                  }
                  table[class="table-col"] + table[class="table-col"] {
                    margin-top: 15px;
                  }
                  td[class="table-row-td"] {
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                  }
                  table[class="navbar-row"] , td[class="navbar-row-td"] {
                    width: 100% !important;
                  }
                  img {
                    max-width: 100% !important;
                    display: inline !important;
                  }
                  img[class="pull-right"] {
                    float: right;
                    margin-left: 11px;
                          max-width: 125px !important;
                    padding-bottom: 0 !important;
                  }
                  img[class="pull-left"] {
                    float: left;
                    margin-right: 11px;
                    max-width: 125px !important;
                    padding-bottom: 0 !important;
                  }
                  table[class="table-space"], table[class="header-row"] {
                    float: none !important;
                    width: 98% !important;
                  }
                  td[class="header-row-td"] {
                    width: 100% !important;
                  }
                }
                @media only screen and (max-width: 480px) {
                  table[class="table-row"] {
                    padding-left: 16px !important;
                    padding-right: 16px !important;
                  }
                }
                @media only screen and (max-width: 320px) {
                  table[class="table-row"] {
                    padding-left: 12px !important;
                    padding-right: 12px !important;
                  }
                }
                @media only screen and (max-width: 458px) {
                  td[class="table-td-wrap"] {
                    width: 100% !important;
                  }
                }
              </style>
             </head>
                <body style="font-family: Arial, sans-serif; font-size:13px; color: #307ecc; min-height: 200px;" bgcolor="#E4E6E9"  leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
                   <table width="100%" height="100%" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0">
                   <tr><td width="100%" align="center" valign="top" bgcolor="#E4E6E9" style="background-color:#E4E6E9; min-height: 200px;">
                  <table><tr><td class="table-td-wrap" align="center" width="458"><table class="table-space" height="18" style="height: 18px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="18" style="height: 18px; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table>
                  <table class="table-space" height="8" style="height: 8px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="8" style="height: 8px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                  <table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #307ecc; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
                    <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #307ecc; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
                      <table class="header-row" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="378" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #307ecc; margin: 0px; font-size: 18px; padding-bottom: 10px; padding-top: 15px; text-align: center;" valign="top" align="left">CREDENCIALES DE ACCESO</td></tr></tbody></table>
                      <div style="font-family: Arial, sans-serif; line-height: 20px; color: #307ecc; font-size: 13px; text-align: center;">
                        <h4 style="color: #307ecc;">Hola,'.$nombre.'</h4>
                        <b style="color: #777777;">Usuario: '.$correo.'
                        <br>
                        <b style="color: #777777;">Contraseña: '.$pass.'
                        <br>
                        <img style="" src="http://localhost/winchas_web/admin/logo.jpg" width="230" height="90" />
                      </div>
                    </td></tr></tbody></table>
                  </td></tr></tbody></table>
                      
                  <table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
                  <table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 450px; padding-left: 16px; padding-right: 16px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="center">&nbsp;<table bgcolor="#E8E8E8" height="0" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td bgcolor="#E8E8E8" height="1" width="100%" style="height: 1px; font-size:0;" valign="top" align="left">&nbsp;</td></tr></tbody></table></td></tr></tbody></table>
                  <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                  <table class="table-space" height="6" style="height: 6px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="6" style="height: 6px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                  <table class="table-row-fixed" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-fixed-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #307ecc; font-size: 13px; font-weight: normal; padding-left: 1px; padding-right: 1px;" valign="top" align="left">
                    <table class="table-col" align="left" width="448" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="448" style="font-family: Arial, sans-serif; line-height: 19px; color: #307ecc; font-size: 13px; font-weight: normal;" valign="top" align="left">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td width="100%" align="center" bgcolor="#f5f5f5" style="font-family: Arial, sans-serif; line-height: 24px; color: #bbbbbb; font-size: 13px; font-weight: normal; text-align: center; padding: 9px; border-width: 1px 0px 0px; border-style: solid; border-color: #e3e3e3; background-color: #f5f5f5;" valign="top">
                        <a href="#" style="color: #428bca; text-decoration: none; background-color: transparent;">WINCHAS EL VENEZOLANO &copy; 2018</a>
                      </td></tr></tbody></table>
                    </td></tr></tbody></table>
                  </td></tr></tbody></table>
                </body>
        	</html>';

			$para = $_POST['correo'];
			$titulo = utf8_decode('Credenciales de Acceso');
			$contenido_html = utf8_decode($contenido_html);
			// Cabecera que especifica que es un HMTL
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			 
			// Cabeceras adicionales
			$cabeceras .= 'From: WINCHAS EL VENEZOLANO <tarifas@example.com>' . "\r\n";
			$cabeceras .= 'Cc: archivotarifas@example.com' . "\r\n";
			$cabeceras .= 'Bcc: copiaoculta@example.com' . "\r\n";

			mail($para, $titulo, $contenido_html, $cabeceras);

		// $data = correo($_POST['nombres_completos'],$_POST['correo'],$pass);

		$data = 1;
		echo $data;
	}
	// fin

	// Modificar empleados
	if (isset($_POST['Modificar']) == "Modificar") {
		if(isset($_FILES["file_1"])) {
			$temporal = $_FILES['file_1']['tmp_name'];
            $extension = explode(".",  $_FILES['file_1']['name']); 
            $extension = end($extension);                    			            
            $nombre = $_POST["id"].".".$extension;
            $destino = "/fotos/".$nombre;			            
            $root = getcwd();	
            if(move_uploaded_file($temporal, $root.$destino)) {
            	$dirFoto = $destino;
            }     	
		}

		if($dirFoto == '') {
			$class->consulta("UPDATE empleados SET	identificacion = '$_POST[identificacion]',
													nombres_completos = '$_POST[nombres_completos]',
													telefono1 = '$_POST[telefono1]',
													telefono2 = '$_POST[telefono2]',
													id_ciudad = '$_POST[select_ciudad]',
													direccion = '$_POST[direccion]',
													correo = '$_POST[correo]',
													id_cargo = '$_POST[select_cargo]',
													id_servicio = '$_POST[select_servicio]',
													observaciones = '$_POST[observaciones]' WHERE id = '".$_POST['id']."'");	
		} else {
			$class->consulta("UPDATE empleados SET	identificacion = '$_POST[identificacion]',
													nombres_completos = '$_POST[nombres_completos]',
													telefono1 = '$_POST[telefono1]',
													telefono2 = '$_POST[telefono2]',
													id_ciudad = '$_POST[select_ciudad]',
													direccion = '$_POST[direccion]',
													correo = '$_POST[correo]',
													id_cargo = '$_POST[select_cargo]',
													id_servicio = '$_POST[select_servicio]',
													imagen = '$dirFoto',
													observaciones = '$_POST[observaciones]' WHERE id = '".$_POST['id']."'");	
		}	
			
		$data = 2;
		echo $data;
	}
	// fin

	// Eliminar empleados
	if (isset($_POST['Eliminar']) == "Eliminar") {
		$class->consulta("UPDATE empleados SET estado = '0' WHERE id = '".$_POST['id']."'");
		$data = 4;
		echo $data;	
	}
	// fin

	// comparar identificacion empleados
	if (isset($_POST['comparar_identificacion'])) {
		$resultado = $class->consulta("SELECT * FROM empleados WHERE identificacion = '$_POST[identificacion]' AND estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$cont++;
		}

		if ($cont == 0) {
		    $data = 0;
		} else {
		    $data = 1;
		}
		echo $data;
	}
	// fin

	//LLena combo cargo
	if (isset($_POST['llenar_cargo'])) {
		$resultado = $class->consulta("SELECT id, nombre_cargo FROM cargos WHERE estado = '1' order by id asc");
		//print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row['id'].'">'.$row['nombre_cargo'].'</option>';
		}
	}
	// fin

	//LLena combo servicio
	if (isset($_POST['llenar_servicio'])) {
		$resultado = $class->consulta("SELECT id, servicio FROM servicios WHERE estado = '1' order by id asc");
		//print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row['id'].'">'.$row['servicio'].'</option>';
		}
	}
	// fin

	//LLena combo provincias
	if (isset($_POST['llenar_provincia'])) {
		$resultado = $class->consulta("SELECT id, nombre_provincia FROM provincias WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row[0].'">'.$row[1].'</option>';
		}
	}
	// fin

	// LLenar combo ciudad
	if (isset($_POST['llenar_ciudad'])) {
		$resultado = $class->consulta("SELECT C.id, C.nombre_ciudad FROM provincias P, ciudad C WHERE C.id_provincia = P.id AND P.id =  '".$_POST['id']."' ORDER BY C.id ASC");
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row[0].'">'.$row[1].'</option>';	
		}
	}
	// fin

	// provincia activa
	if (isset($_POST['llenar_provincia_update'])) {
		$resultado = $class->consulta("SELECT P.id FROM provincias P, ciudad C WHERE C.id_provincia = P.id AND C.id =   '".$_POST['id']."'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array('id_provincia' => $row[0]);
			//$data = $row[0];
		}

		//echo $data;
		print_r(json_encode($data));
	}
	// fin

	// consultar cedula
	if (isset($_POST['consulta_cedula'])) {
		$ruc = $_POST['txt_ruc'];
		$servicio = new DatosCedula();///creamos nuevo objeto de antecedentes
		$datosCedula = $servicio->consultar_cedula($ruc); // accedemos a la funcion datosSRI

		print_r(json_encode(['datosPersona'=>$datosCedula]));		
	}
	// fin

	// informacion respuesta
	if (isset($_POST['cargar_notificaciones'])) {
		//$resultado = $class->consulta("SELECT count(*) FROM llamado M, clientes C WHERE M.id_cliente = C.id AND M.estado = '1'");
		$resultado = $class->consulta("SELECT count(*) FROM relacion_servicios R, llamado L  WHERE id_empleado = '".$_POST['id_empleado']."' AND L.id_servicio = R.id_servicio AND L.estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$suma = $row[0];
		}

		echo $suma;  
	}
	// fin

	// informacion llamados
	if (isset($_POST['cargar_llamados'])) {
		//$resultado = $class->consulta("SELECT M.id, C.nombres, C.apellidos FROM llamado M, clientes C WHERE M.id_cliente = C.id AND M.estado = '1'");
		$resultado = $class->consulta("SELECT L.id, C.nombres, C.apellidos FROM relacion_servicios R, llamado L, clientes C WHERE id_empleado = '".$_POST['id_empleado']."' AND L.id_servicio = R.id_servicio AND L.id_cliente = C.id AND L.estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$data[] = array('id' => $row[0], 'nombres' => $row[1], 'apellidos' => $row[2]);
		}

		echo $data = json_encode($data);
	}
	// fin

	// Asistir
	if (isset($_POST['Asistir']) == "Asistir") {
		$resultado = $class->consulta("SELECT count(*) FROM respuesta WHERE id_llamado = '".$_POST['id_llamado']."' AND estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$cont = $row[0];
		}

		if($cont == 0) {
			$resultado = $class->consulta("SELECT count(*) FROM respuesta WHERE id_empleado = '".$_POST['id_empleado']."' AND estado = '1'");
			while ($row = $class->fetch_array($resultado)) {
				$cont2 = $row[0];
			}

			if($cont2 == 0) {
				// contador respuesta
				$id_respuesta = 0;
				$resultado = $class->consulta("SELECT max(id) FROM respuesta");
				while ($row = $class->fetch_array($resultado)) {
					$id_respuesta = $row[0];
				}
				$id_respuesta++;
				// fin

				$class->consulta("INSERT INTO respuesta VALUES ('$id_respuesta','$_POST[id_empleado]','$_POST[id_llamado]','$_POST[long]','$_POST[lat]','','','','1','$fecha')");

				$resultado = $class->consulta("SELECT W.id FROM winchas W, empleados E WHERE W.id_responsable = '".$_POST['id_empleado']."'");
				while ($row = $class->fetch_array($resultado)) {
					$id = $row[0];
				}

				$class->consulta("UPDATE winchas SET estado = '0' WHERE id = '".$id."'");

				$data = 1;
			} else {
				$data = 2;	
			}
		} else {
			$data = 0;	
		}

		echo $data;
	}
	// fin

	if (isset($_POST['Pagar']) == "Pagar") {
		// consultar respuesta
		$resultado = $class->consulta("SELECT * FROM respuesta WHERE id_llamado = '".$_POST['id_llamado']."'");
		while ($row = $class->fetch_array($resultado)) {
			$id = $row[0];
		}

		if ($id != "") {
			$seguro = "NO";
			if(isset($_POST["seguro"]))
				$seguro = "SI";

			$class->consulta("UPDATE respuesta SET pago = '$_POST[monto]', seguro = '$seguro', estado = '0' WHERE id = '".$id."'");
			// fin

			// Modificar llamado
			$class->consulta("UPDATE llamado SET estado = '0' WHERE id = '".$_POST['id_llamado']."'");

			// modificar wincha
			$resultado = $class->consulta("SELECT W.id FROM winchas W, empleados E WHERE W.id_responsable = '".$_POST['id_empleado']."'");
			while ($row = $class->fetch_array($resultado)) {
				$id_wincha = $row[0];
			}

			$class->consulta("UPDATE winchas SET estado = '1' WHERE id = '".$id_wincha."'");
			// fin

			$data = 1;
		} else {
			$data = 0;	
		}

		echo $data;
	}

	if (isset($_POST['Mensaje']) == "Mensaje") {
		// consultar respuesta
		$resultado = $class->consulta("SELECT * FROM respuesta WHERE id_llamado = '".$_POST['id_llamado']."'");
		while ($row = $class->fetch_array($resultado)) {
			$id = $row[0];
		}

		if ($id != "") {
			// contador mensajeria_respuesta
			$id_mensajeria_respuesta = 0;
			$resultado = $class->consulta("SELECT max(id) FROM mensajeria_respuesta");
			while ($row = $class->fetch_array($resultado)) {
				$id_mensajeria_respuesta = $row[0];
			}
			$id_mensajeria_respuesta++;
			// fin

			// guardar mensajes
			$class->consulta("INSERT INTO mensajeria_respuesta VALUES ('$id_mensajeria_respuesta','$id','$_POST[texto]','1','$fecha')");
			// fin

			//modificar coordenadas
			$class->consulta("UPDATE respuesta SET latitud = '$_POST[long]', longitud = '$_POST[lat]' WHERE id = '".$id."'");
			$data = 1;
		} else {
			$data = 0;
		}

		echo $data;
	}
?>