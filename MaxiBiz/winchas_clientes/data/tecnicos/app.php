<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
    include_once('../../admin/datos_cedula.php');
	include_once('../../admin/class.php');
	$class = new constante();
	error_reporting(0);
	
	$fecha = $class->fecha_hora();

	// Guardar tecnicos
	if (isset($_POST['Guardar']) == "Guardar") {
		// contador tecnicos
		$id_tecnicos = 0;
		$resultado = $class->consulta("SELECT max(id) FROM tecnicos");
		while ($row = $class->fetch_array($resultado)) {
			$id_tecnicos = $row[0];
		}
		$id_tecnicos++;
		// fin

		if(isset($_FILES["file_1"])) {
			$temporal = $_FILES['file_1']['tmp_name'];
            $extension = explode(".",  $_FILES['file_1']['name']); 
            $extension = end($extension);                    			            
            $nombre = $id_tecnicos.".".$extension;
            $destino = "./fotos/".$nombre;			            
            $root = getcwd();	
            if(move_uploaded_file($temporal, $root.$destino)) {
            	$dirFoto = $destino;
            } else {
            	$dirFoto = "./fotos/defaul.jpg";	
            }      	
		}

		$class->consulta("INSERT INTO tecnicos VALUES (	'$id_tecnicos',
															'$_POST[identificacion]',
															'$_POST[nombres_completos]',
															'$_POST[telefono1]',
															'$_POST[telefono2]',
															'$_POST[select_ciudad]',
															'$_POST[direccion]',
															'$_POST[correo]',
															'$dirFoto',
															'$_POST[observaciones]',
															'1', 
															'$fecha')");
		
		$data = 1;
		echo $data;
	}
	// fin

	// Modificar tecnicos
	if (isset($_POST['Modificar']) == "Modificar") {
		if(isset($_FILES["file_1"])) {
			$temporal = $_FILES['file_1']['tmp_name'];
            $extension = explode(".",  $_FILES['file_1']['name']); 
            $extension = end($extension);                    			            
            $nombre = $_POST["id_usuario"].".".$extension;
            $destino = "./fotos/".$nombre;			            
            $root = getcwd();	
            if(move_uploaded_file($temporal, $root.$destino)) {
            	$dirFoto = $destino;
            }     	
		}

		if($dirFoto == '') {
			$class->consulta("UPDATE tecnicos SET	identificacion = '$_POST[identificacion]',
													nombres_completos = '$_POST[nombres_completos]',
													telefono1 = '$_POST[telefono1]',
													telefono2 = '$_POST[telefono2]',
													id_ciudad = '$_POST[select_ciudad]',
													direccion = '$_POST[direccion]',
													correo = '$_POST[correo]',
													observaciones = '$_POST[observaciones]' WHERE id = '".$_POST['id']."'");	
		} else {
			$class->consulta("UPDATE tecnicos SET	identificacion = '$_POST[identificacion]',
													nombres_completos = '$_POST[nombres_completos]',
													telefono1 = '$_POST[telefono1]',
													telefono2 = '$_POST[telefono2]',
													id_ciudad = '$_POST[select_ciudad]',
													direccion = '$_POST[direccion]',
													correo = '$_POST[correo]',
													imagen = '$dirFoto',
													observaciones = '$_POST[observaciones]' WHERE id = '".$_POST['id']."'");	
		}	
			
		$data = 2;
		echo $data;
	}
	// fin

	// Eliminar tecnicos
	if (isset($_POST['oper']) == "del") {
		$class->consulta("UPDATE tecnicos SET estado = '0' WHERE id = '".$_POST['id']."'");
		$data = "4";	
	}
	// fin

	// comparar identificacion tecnicos
	if (isset($_POST['comparar_identificacion'])) {
		$resultado = $class->consulta("SELECT * FROM tecnicos U WHERE U.identificacion = '$_POST[identificacion]' AND estado = '1'");
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
			//$data = array('id_provincia' => $row[0]);
			$data = $row[0];
		}

		echo $data;
		//print_r(json_encode($data));
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
?>