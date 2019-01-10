<?php 
	if(!isset($_SESSION)) {
        session_start();        
    }

  header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin");
    
	include_once('../../admin/class.php');
	include_once('../../admin/correolocalactivacion.php');
	$class = new constante();
	$fecha = $class->fecha_hora();
	error_reporting(0);

	// Guardar clientes
	if (isset($_POST['Guardar']) == "Guardar") {
		// contador clientes
		$id_cliente = 0;
		$resultado = $class->consulta("SELECT max(id) FROM clientes");
		while ($row = $class->fetch_array($resultado)) {
			$id_cliente = $row[0];
		}
		$id_cliente++;
		// fin

		$class->consulta("INSERT INTO clientes VALUES  (	'$id_cliente',
															'$_POST[nombres]',
															'$_POST[apellidos]',
															'$_POST[direccion]',
															'$_POST[telefono]',
															'$_POST[correo]',
															'$_POST[clave]',
															'$_POST[terminos]',
															'0', 
															'$fecha')");	
		
		$id = $id_cliente;

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
                <body style="font-family: Arial, sans-serif; font-size:13px; color: #444444; min-height: 200px;" bgcolor="#E4E6E9"  leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
                   <table width="100%" height="100%" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0">
                   <tr><td width="100%" align="center" valign="top" bgcolor="#E4E6E9" style="background-color:#E4E6E9; min-height: 200px;">
                  <table><tr><td class="table-td-wrap" align="center" width="458"><table class="table-space" height="18" style="height: 18px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="18" style="height: 18px; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table>
                  <table class="table-space" height="8" style="height: 8px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="8" style="height: 8px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                  <table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
                    <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
                      <table class="header-row" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="378" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #307ecc; margin: 0px; font-size: 18px; padding-bottom: 10px; padding-top: 15px; text-align: center;" valign="top" align="left">Gracias por registrarse con nosotros!</td></tr></tbody></table>
                      <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px; text-align: center;">
                        <b >Su cuenta WINCHAS EL VENEZOLANO ha sido configurada y este correo contiene toda la información que necesitará para comenzar a utilizar su cuenta.
                        <br>
                        Por favor confirme su registro para continuar.
                      </div>
                    </td></tr></tbody></table>
                  </td></tr></tbody></table>
                      
                  <table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
                  <table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 450px; padding-left: 16px; padding-right: 16px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="center">&nbsp;<table bgcolor="#E8E8E8" height="0" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td bgcolor="#E8E8E8" height="1" width="100%" style="height: 1px; font-size:0;" valign="top" align="left">&nbsp;</td></tr></tbody></table></td></tr></tbody></table>
                  <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                  <table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
                    <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
                      <div style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; text-align: center;">
                        <a href="http://localhost/winchas_web/activar.html?id='.$id.'" style="color: #ffffff; text-decoration: none; margin: 0px; text-align: center; vertical-align: baseline; border: 4px solid #CA1D27; padding: 4px 9px; font-size: 15px; line-height: 21px; background-color: #CA1D27;">&nbsp; Confirmar &nbsp;</a>
                      </div>
                      <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
                    </td></tr></tbody></table>
                  </td></tr></tbody></table>

                  <table class="table-space" height="6" style="height: 6px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="6" style="height: 6px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                  <table class="table-row-fixed" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-fixed-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 1px; padding-right: 1px;" valign="top" align="left">
                    <table class="table-col" align="left" width="448" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="448" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
                      <table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td width="100%" align="center" bgcolor="#f5f5f5" style="font-family: Arial, sans-serif; line-height: 24px; color: #bbbbbb; font-size: 13px; font-weight: normal; text-align: center; padding: 9px; border-width: 1px 0px 0px; border-style: solid; border-color: #e3e3e3; background-color: #f5f5f5;" valign="top">
                        <a href="" style="color: #428bca; text-decoration: none; background-color: transparent;">WINCHAS EL VENEZOLANO &copy; 2018</a>
                        <br>
                        <a href="" style="color: #84CA47; text-decoration: none; background-color: transparent;">twitter</a>
                        .
                        <a href="" style="color: #5b7a91; text-decoration: none; background-color: transparent;">facebook</a>
                        .
                        <a href="" style="color: #dd5a43; text-decoration: none; background-color: transparent;">google+</a>
                      </td></tr></tbody></table>
                    </td></tr></tbody></table>
                  </td></tr></tbody></table>
                  <table class="table-space" height="1" style="height: 1px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="1" style="height: 1px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
                  <table class="table-space" height="36" style="height: 36px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="36" style="height: 36px; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table></td></tr></table>
                  </td></tr>
                   </table>
                </body>
        </html>';

			$para = $_POST['correo'];
			$titulo = utf8_decode('Activación de cuenta');
			$contenido_html = utf8_decode($contenido_html);
			// Cabecera que especifica que es un HMTL
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			 
			// Cabeceras adicionales
			$cabeceras .= 'From: WINCHAS EL VENEZOLANO <tarifas@example.com>' . "\r\n";
			$cabeceras .= 'Cc: archivotarifas@example.com' . "\r\n";
			$cabeceras .= 'Bcc: copiaoculta@example.com' . "\r\n";

			mail($para, $titulo, $contenido_html, $cabeceras);

		//$data = correo($id_cliente,$_POST['correo'],$_POST['nombres']);

		//$data = 1;
		echo $data;
	}
	// fin

	// Modificar clientes
	if (isset($_POST['Modificar']) == "Modificar") {
		if(isset($_FILES["file_1"])) {
			$temporal = $_FILES['file_1']['tmp_name'];
            $extension = explode(".",  $_FILES['file_1']['name']); 
            $extension = end($extension);                    			            
            $nombre = $_POST["id_cliente"].".".$extension;
            $destino = "./fotos/".$nombre;			            
            $root = getcwd();	
            if(move_uploaded_file($temporal, $root.$destino)) {
            	$dirFoto = $destino;
            }     	
		}

		if($dirFoto == '') {
			$class->consulta("UPDATE clientes SET	id_tipo_documento = '$_POST[select_documento]',
													identificacion = '$_POST[identificacion]',
													razon_social = '$_POST[razon_social]',
													nombre_comercial = '$_POST[nombre_comercial]',
													telefono1 = '$_POST[telefono1]',
													telefono2 = '$_POST[telefono2]',
													ciudad = '$_POST[ciudad]',
													direccion = '$_POST[direccion]',
													correo = '$_POST[correo]',
													cupo = '$_POST[cupo_credito]',
													observaciones = '$_POST[observaciones]',
													fecha_creacion = '$fecha' WHERE id = '".$_POST['id_cliente']."'");	
		} else {
			$class->consulta("UPDATE clientes SET	id_tipo_documento = '$_POST[select_documento]',
													identificacion = '$_POST[identificacion]',
													razon_social = '$_POST[razon_social]',
													nombre_comercial = '$_POST[nombre_comercial]',
													telefono1 = '$_POST[telefono1]',
													telefono2 = '$_POST[telefono2]',
													ciudad = '$_POST[ciudad]',
													direccion = '$_POST[direccion]',
													correo = '$_POST[correo]',
													cupo = '$_POST[cupo_credito]',
													imagen = '$dirFoto',
													observaciones = '$_POST[observaciones]',
													fecha_creacion = '$fecha' WHERE id = '".$_POST['id_cliente']."'");	
		}

		$data = 2;
		echo $data;
	}
	// fin

	// Eliminar clientes
	if (isset($_POST['oper']) == "del") {
		$class->consulta("UPDATE clientes SET estado = '0' WHERE id = '".$_POST['id']."'");
		$data = "4";	
	}
	// fin

	if (isset($_POST['proceso_activacion'])) {
		$resultado = $class->consulta("UPDATE clientes SET estado = '1' WHERE id = '".$_POST['id']."'");
		$data = "1";
		echo $data;
	}

	if (isset($_POST['Login']) == "Login") {
		if ($_POST['tipo_ingreso'] == 'Cliente') {
			$resultado = $class->consulta("SELECT * FROM clientes WHERE email= '".$_POST['username']."' AND clave = '".$_POST['password']."' AND estado = '1'");

			if($class->num_rows($resultado) == 1) {
				$row = $class->fetch_array($resultado);
				
				print_r(json_encode(array('status' => 'okcliente', 'id' => $row[0], 'name' => $row[1], 'apellido' => $row[2])));
			} else {
				print_r(json_encode(array('status' => 'error', 'problem' => 'user no valid')));
			}	
		} else {
			if ($_POST['tipo_ingreso'] == 'Empleado') {
				$resultado = $class->consulta("SELECT * FROM empleados WHERE correo= '".$_POST['username']."' AND clave = '".$_POST['password']."' AND estado = '1'");

				if($class->num_rows($resultado) == 1) {
					$row = $class->fetch_array($resultado);
					
					print_r(json_encode(array('status' => 'okempleado', 'id' => $row[0], 'nombres_completos' => $row[2])));
				} else {
					print_r(json_encode(array('status' => 'error', 'problem' => 'user no valid')));
				}
			}
		}		
	}

	// informacion respuesta
	if (isset($_POST['cargar_notificaciones'])) {
		$resultado = $class->consulta("SELECT count(*) FROM respuesta R, llamado L WHERE R.id_llamado = L.id AND L.id_cliente = '".$_POST['id_cliente']."' AND L.estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$suma = $row[0];
		}

		echo $suma;  
	}
	// fin

	if (isset($_POST['cargar_respuestas']) == "cargar_respuestas") {
		$resultado = $class->consulta("SELECT R.id, E.nombres_completos FROM respuesta R, empleados E, llamado L WHERE R.id_empleado = E.id AND R.id_llamado = L.id AND L.id_cliente = '".$_POST['id_cliente']."' AND L.estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$data[] = array('id' => $row[0], 'empleado' => $row[1]);
		}

		echo $data = json_encode($data);
	}	
?>