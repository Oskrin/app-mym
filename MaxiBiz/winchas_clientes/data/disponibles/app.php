<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	include_once('../../admin/funciones_generales.php');
	$class = new constante();
	error_reporting(0);
	
	$fecha = $class->fecha_hora();

	// consultar winchas
	if(isset($_POST['cargar_tabla'])){
		$resultado = $class->consulta("SELECT W.imagen, W.modelo, E.nombres_completos, W.estado FROM winchas W, empleados E WHERE W.id_responsable = E.id");
		while ($row = $class->fetch_array($resultado)) {
			$lista[] = array(	'imagen' => $row[0],
								'modelo' => $row[1],
								'responsable' => $row[2],
								'estado' => $row[3]
								);
		}

		echo $lista = json_encode($lista);
	}
	// fin
?>