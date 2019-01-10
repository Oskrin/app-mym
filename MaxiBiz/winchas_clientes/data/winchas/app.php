<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
    include_once('../../admin/datos_cedula.php');
	include_once('../../admin/class.php');
	$class = new constante();
	error_reporting(0);
	
	$fecha = $class->fecha_hora();

	// Guardar winchas
	if (isset($_POST['Guardar']) == "Guardar") {
		// contador winchas
		$id_winchas = 0;
		$resultado = $class->consulta("SELECT max(id) FROM winchas");
		while ($row = $class->fetch_array($resultado)) {
			$id_winchas = $row[0];
		}
		$id_winchas++;
		// fin

		if(isset($_FILES["file_1"])) {
			$temporal = $_FILES['file_1']['tmp_name'];
            $extension = explode(".",  $_FILES['file_1']['name']); 
            $extension = end($extension);                    			            
            $nombre = $id_winchas.".".$extension;
            $destino = "/fotos/".$nombre;			            
            $root = getcwd();	
            if(move_uploaded_file($temporal, $root.$destino)) {
            	$dirFoto = $nombre;
            } else {
            	$dirFoto = "defaul.jpg";	
            }      	
		}

		$class->consulta("INSERT INTO winchas VALUES (	'$id_winchas',
														'$_POST[modelo]',
														'$_POST[detalle]',
														'$_POST[placa]',
														'$_POST[select_responsable]',
														'$dirFoto',
														'1', 
														'$fecha')");
		
		$data = 1;
		echo $data;
	}
	// fin

	// Modificar winchas
	if (isset($_POST['Modificar']) == "Modificar") {
		if(isset($_FILES["file_1"])) {
			$temporal = $_FILES['file_1']['tmp_name'];
            $extension = explode(".",  $_FILES['file_1']['name']); 
            $extension = end($extension);                    			            
            $nombre = $_POST["id"].".".$extension;
            $destino = "/fotos/".$nombre;			            
            $root = getcwd();	
            if(move_uploaded_file($temporal, $root.$destino)) {
            	$dirFoto = $nombre;
            } else {
            	$dirFoto = "";
            }     	
		}

		if($dirFoto == '') {
			$class->consulta("UPDATE winchas SET	modelo = '$_POST[modelo]',
													servicio = '$_POST[detalle]',
													placa = '$_POST[placa]',
													id_responsable = '$_POST[select_responsable]'
													WHERE id = '".$_POST['id']."'");	
		} else {
			$class->consulta("UPDATE winchas SET	modelo = '$_POST[modelo]',
													servicio = '$_POST[detalle]',
													placa = '$_POST[placa]',
													id_responsable = '$_POST[select_responsable]',
													imagen = '$dirFoto'
													WHERE id = '".$_POST['id']."'");	
		}	
			
		$data = 2;
		echo $data;
	}
	// fin

	// Eliminar winchas
	if (isset($_POST['Eliminar']) == "Eliminar") {
		$class->consulta("UPDATE winchas SET estado = '0' WHERE id = '".$_POST['id']."'");
		$data = "4";
		echo $data;	
	}
	// fin

	//LLena combo responsable
	if (isset($_POST['llenar_responsable'])) {
		$resultado = $class->consulta("SELECT E.id, E.nombres_completos FROM empleados E WHERE E.estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row[0].'">'.$row[1].'</option>';
		}
	}
	// fin
?>