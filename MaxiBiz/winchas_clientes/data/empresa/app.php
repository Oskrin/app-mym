<?php 
	if(!isset($_SESSION)) {
        session_start();        
    }

	include_once('../../admin/datos_sri.php');
	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();
	error_reporting(0);

	if (isset($_POST["Guardar"]) == "Guardar") {
		$dirToken = "";
		$dirLogo = "";
		// contador empresa
		$id_empresa = 0;
		$resultado = $class->consulta("SELECT max(id) FROM empresa");
		while ($row = $class->fetch_array($resultado)) {
			$id_empresa = $row[0];
		}
		$id_empresa++;

		if(isset($_FILES["file"])) {
			$temporal = $_FILES['file']['tmp_name'];
            $extension = explode(".",  $_FILES['file']['name']); 
            $extension = end($extension);                    			            
            $nombre = $id_empresa.".".$extension;
            $destino = "./logo/".$nombre;			            
            $root = getcwd();	
            if(move_uploaded_file($temporal, $root.$destino)) {
            	$dirLogo = $destino;
            } else {
            	$dirLogo = "./logo/defaul.png";	
            }      	
		}
		// fin

		$class->consulta("INSERT INTO empresa VALUES (	'$id_empresa',
														'$_POST[ruc]',
														'$_POST[razon_social]',
														'$_POST[nombre_comercial]',
														'$_POST[telefono1]',
														'$_POST[telefono2]',
														'$_POST[ciudad]',
														'$_POST[direccion]',
														'$_POST[correo]',
														'$_POST[sitio_web]',
														'$_POST[slogan]',
														'$dirLogo',
														'',
														'1', 
														'$fecha')");	
		$data = 1;
		echo $data;
	}

	if (isset($_POST['Modificar']) == "Modificar") {

		if(isset($_FILES["file"])) {
			$temporal = $_FILES['file']['tmp_name'];
            $extension = explode(".",  $_FILES['file']['name']); 
            $extension = end($extension);                    			            
            $nombre = $_POST["id"].".".$extension;
            $destino = "./logo/".$nombre;			            
            $root = getcwd();	
            if(move_uploaded_file($temporal, $root.$destino)) {
            	$dirLogo = $destino;
            }     	
		}

		if($dirLogo == '') {
			$class->consulta("UPDATE empresa SET	ruc = '$_POST[ruc]',
													razon_social = '$_POST[razon_social]',
													nombre_comercial = '$_POST[nombre_comercial]',
													telefono1 = '$_POST[telefono1]',
													telefono2 = '$_POST[telefono2]',
													ciudad = '$_POST[ciudad]',
													direccion = '$_POST[direccion]',
													correo = '$_POST[correo]',
													sitio_web = '$_POST[sitio_web]',
													slogan = '$_POST[slogan]'
													WHERE id = '".$_POST['id']."'");

		} else {
			$class->consulta("UPDATE empresa SET	ruc = '$_POST[ruc]',
													razon_social = '$_POST[razon_social]',
													nombre_comercial = '$_POST[nombre_comercial]',
													telefono1 = '$_POST[telefono1]',
													telefono2 = '$_POST[telefono2]',
													ciudad = '$_POST[ciudad]',
													direccion = '$_POST[direccion]',
													correo = '$_POST[correo]',
													sitio_web = '$_POST[sitio_web]',
													slogan = '$_POST[slogan]',
													imagen = '$dirLogo'
													WHERE id = '".$_POST['id']."'");
		}	

		$data = 2;
		echo $data;
	}

	// consultar ruc
	if (isset($_POST['consulta_ruc'])) {
		$ruc = $_POST['txt_ruc'];
		$servicio = new ServicioSRI();///creamos nuevo objeto de servicios SRI
		$datosEmpresa = $servicio->consultar_ruc($ruc); ////accedemos a la funcion datosSRI
		$establecimientos = $servicio->establecimientoSRI($ruc);

		print_r(json_encode(['datosEmpresa'=>$datosEmpresa,'establecimientos'=>$establecimientos]));		
	}
	// fin

	// llenar datos empresa
	if (isset($_POST['consulta_empresa'])) {
		$resultado = $class->consulta("SELECT * FROM empresa WHERE estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array(  'id' => $row[0],
							'ruc' => $row[1],
							'razon_social' => $row[2],
							'nombre_comercial' => $row[3],
							'telefono1' => $row[4],
							'telefono2' => $row[5],
							'ciudad' => $row[6],
							'direccion' => $row[7],
							'correo' => $row[8],
							'sitio_web' => $row[9],
							'slogan' => $row[10],
							'logo' => $row[11]);
		}
		print_r(json_encode($data));
	}
	//fin
?>