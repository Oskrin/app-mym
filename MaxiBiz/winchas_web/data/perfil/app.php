<?php 
	if(!isset($_SESSION)) {
        session_start();        
    }
    
	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();
	
	// contador perfil
	$id_perfil = 0;
	$resultado = $class->consulta("SELECT max(id) FROM perfil");
	while ($row = $class->fetch_array($resultado)) {
		$id_perfil = $row[0];
	}
	$id_perfil++;
	// fin

	if ($_POST['oper'] == "add") {
		$resultado = $class->consulta("SELECT count(*) FROM perfil WHERE nombre_perfil = '$_POST[nombre_perfil]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = $row[0];
		}

		if ($data != 0) {
			$data = "3";
		} else {
			$class->consulta("INSERT INTO perfil VALUES ('$id_perfil','$_POST[nombre_perfil]','$_POST[observaciones]','1','$fecha')");

			// contador privilegios
			$id_privilegios = 0;
			$resultado = $class->consulta("SELECT max(id) FROM privilegios");
			while ($row = $class->fetch_array($resultado)) {
				$id_privilegios = $row[0];
			}
			$id_privilegios++;
			// fin

			$arreglo = array(	'require',
								'empresa',
								'cargos',
								'servicios',
								'clientes',
								'empleados',
								'winchas',
								'disponibles',
								'perfil',
								'usuarios',
								'privilegios',
								'cuenta');

			$array = json_encode($arreglo);

			$class->consulta("INSERT INTO privilegios VALUES (	'$id_privilegios',
																'$id_perfil',
																'$array',
																'1', 
																'$fecha')");

			$data = "1";
		}
	} else {
	    if ($_POST['oper'] == "edit") {
	    	$resultado = $class->consulta("SELECT count(*) FROM perfil WHERE nombre_perfil = '$_POST[nombre_perfil]' AND id NOT IN ('".$_POST['id']."')");
			while ($row = $class->fetch_array($resultado)) {
				$data = $row[0];
			}

			if ($data != 0) {
			 	$data = "3";
			} else {
				$class->consulta("UPDATE perfil SET nombre_perfil = '$_POST[nombre_perfil]',observaciones = '$_POST[observaciones]',estado = '$_POST[estado]',fecha_creacion = '$fecha' WHERE id = '".$_POST['id']."'");
	    		$data = "2";
			}
	    } else {
	    	if ($_POST['oper'] == "del") {
	    		$class->consulta("UPDATE perfil SET estado = '0' WHERE id = '".$_POST['id']."'");
	    		$data = "4";	
	    	}
	    }
	}

	echo $data;
?>