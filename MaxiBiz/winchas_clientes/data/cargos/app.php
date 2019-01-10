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
	
	// contador cargos
	$id_cargo = 0;
	$resultado = $class->consulta("SELECT max(id) FROM cargos");
	while ($row = $class->fetch_array($resultado)) {
		$id_cargo = $row[0];
	}
	$id_cargo++;
	// fin

	if ($_POST['oper'] == "add") {
		$resultado = $class->consulta("SELECT count(*) FROM cargos WHERE nombre_cargo = '$_POST[nombre_cargo]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = $row[0];
		}

		if ($data != 0) {
			$data = "3";
		} else {
			$class->consulta("INSERT INTO cargos VALUES ('$id_cargo','$_POST[nombre_cargo]','$_POST[observaciones]','1','$fecha')");

			$data = "1";
		}
	} else {
	    if ($_POST['oper'] == "edit") {
	    	$resultado = $class->consulta("SELECT count(*) FROM cargos WHERE nombre_cargo = '$_POST[nombre_cargo]' AND id NOT IN ('".$_POST['id']."')");
			while ($row = $class->fetch_array($resultado)) {
				$data = $row[0];
			}

			if ($data != 0) {
			 	$data = "3";
			} else {
				$class->consulta("UPDATE cargos SET nombre_cargo = '$_POST[nombre_cargo]',observaciones = '$_POST[observaciones]',estado = '$_POST[estado]',fecha_creacion = '$fecha' WHERE id = '".$_POST['id']."'");
	    		$data = "2";
			}
	    } else {
	    	if ($_POST['oper'] == "del") {
	    		$class->consulta("UPDATE cargos SET estado = '0' WHERE id = '".$_POST['id']."'");
	    		$data = "4";	
	    	}
	    }
	}

	echo $data;
?>