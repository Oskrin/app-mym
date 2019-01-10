<?php 
	if(!isset($_SESSION)) {
        session_start();        
    }

    header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin");
    
	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();
	error_reporting(0);
	
	// contador servicios
	$id_servicio = 0;
	$resultado = $class->consulta("SELECT max(id) FROM servicios");
	while ($row = $class->fetch_array($resultado)) {
		$id_servicio = $row[0];
	}
	$id_servicio++;
	// fin

	if ($_POST['oper'] == "add") {
		$resultado = $class->consulta("SELECT count(*) FROM servicios WHERE servicio = '$_POST[servicio]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = $row[0];
		}

		if ($data != 0) {
			$data = "3";
		} else {
			$class->consulta("INSERT INTO servicios VALUES ('$id_servicio','$_POST[servicio]','$_POST[observaciones]','1','$fecha')");

			$data = "1";
		}
	} else {
	    if ($_POST['oper'] == "edit") {
	    	$resultado = $class->consulta("SELECT count(*) FROM servicios WHERE servicio = '$_POST[servicio]' AND id NOT IN ('".$_POST['id']."')");
			while ($row = $class->fetch_array($resultado)) {
				$data = $row[0];
			}

			if ($data != 0) {
			 	$data = "3";
			} else {
				$class->consulta("UPDATE servicios SET servicio = '$_POST[servicio]',observaciones = '$_POST[observaciones]',estado = '$_POST[estado]',fecha_creacion = '$fecha' WHERE id = '".$_POST['id']."'");
	    		$data = "2";
			}
	    } else {
	    	if ($_POST['oper'] == "del") {
	    		$class->consulta("UPDATE servicios SET estado = '0' WHERE id = '".$_POST['id']."'");
	    		$data = "4";	
	    	}
	    }
	}

	echo $data;

	if (isset($_POST['Servicios']) == "Servicios") {
		$resultado = $class->consulta("SELECT id, servicio FROM servicios WHERE estado = '1' ORDER BY id ASC");
		while ($row = $class->fetch_array($resultado)) {
			$data[] = array('id' => $row[0], 'servicio' => $row[1]);
		}

		echo $data = json_encode($data);
	}

	if (isset($_POST['Llamar']) == "Llamar") {
		// contador llamado
		$id_llamado = 0;
		$resultado = $class->consulta("SELECT max(id) FROM llamado");
		while ($row = $class->fetch_array($resultado)) {
			$id_llamado = $row[0];
		}
		$id_llamado++;
		// fin

		$class->consulta("INSERT INTO llamado VALUES ('$id_llamado','$_POST[id_cliente]','$_POST[id_servicio]','$_POST[long]','$_POST[lat]','$_POST[descripcion]','1','$fecha')");

		$data = "1";
		echo $data;
	}
?>