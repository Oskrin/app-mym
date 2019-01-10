<?php 
	include_once('../../admin/class.php');
	include_once('../../admin/correocontactos.php');
	$class = new constante();
	session_start(); 
	error_reporting(0);

	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin");

	// informacion ingresos usuarios
	if (isset($_POST['cargar_notificaciones'])) {
		$resultado = $class->consulta("SELECT count(*) FROM llamado WHERE estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$suma = $row[0];
		}

		echo $suma;  
	}
	// fin

	// informacion llamados
	if (isset($_POST['cargar_llamados'])) {
		$resultado = $class->consulta("SELECT M.id, C.nombres, C.apellidos FROM llamado M, clientes C WHERE M.id_cliente = C.id AND M.estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$data[] = array('id' => $row[0], 'nombres' => $row[1], 'apellidos' => $row[2]);
		}

		echo $data = json_encode($data);
	}
	// fin

	// informacion llamados id
	if (isset($_POST['cargar_llamados_id'])) {
		$resultado = $class->consulta("SELECT M.id, C.nombres, C.apellidos, S.servicio, M.latitud, M.longitud, M.fecha_creacion, C.telefono, M.descripcion FROM llamado M, clientes C, servicios S WHERE M.id_cliente = C.id AND M.id_servicio = S.id AND M.id = '".$_POST['id']."'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array('id' => $row[0], 'nombres' => $row[1], 'apellidos' => $row[2], 'servicio' => $row[3], 'latitud' => $row[4], 'longitud' => $row[5], 'fecha' => $row[6], 'telefono' => $row[7], 'descripcion' => $row[8]);
		}

		echo $data = json_encode($data);
	}
	// fin

	// informacion llamados id
	if (isset($_POST['cargar_respuestas_id'])) {
		$resultado = $class->consulta("SELECT R.id, E.nombres_completos, S.servicio, R.latitud, R.longitud, R.fecha_creacion, E.telefono2 FROM respuesta R, empleados E, llamado L, servicios S, clientes C WHERE R.id_empleado = E.id AND R.id_llamado = L.id AND L.id_cliente = C.id AND L.id_servicio = S.id AND L.estado = '1' AND R.id = '".$_POST['id']."'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array('id' => $row[0], 'empleado' => $row[1], 'servicio' => $row[2], 'latitud' => $row[3], 'longitud' => $row[4], 'fecha' => $row[5], 'telefono' => $row[6]);
		}

		echo $data = json_encode($data);
	}
	// fin

	// informacion ingresos usuarios
	if (isset($_POST['cargar_informacion'])) {
		$resultado = $class->consulta("SELECT usuario, fecha_creacion FROM usuarios WHERE id = '".$_SESSION['user']['id']."'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array('usuario' => $row[0], 'fecha_creacion' => substr($row[1], 0, -6));
		}

		echo $data = json_encode($data);
	}
	// fin

	// mensajes llamados
	if (isset($_POST['cargar_mensajes_id'])) {
		$resultado = $class->consulta("SELECT E.imagen, E.nombres_completos, M.mensaje FROM mensajeria_respuesta M, respuesta R, empleados E WHERE R.id_empleado = E.id AND M.id_respuesta = R.id AND M.id_respuesta = '".$_POST['id']."'");
		while ($row = $class->fetch_array($resultado)) {
			$data[] = array('imagen' => $row[0], 'nombres' => $row[1], 'mensajes' => $row[2]);
		}

		echo $data = json_encode($data);
	}
	// fin

	if (isset($_POST['Enviar'])) {
		$email = 'oskr.trov@gmail.com';

		$data = correo($email,$_POST['correo'],$_POST['mensaje']);

		echo $data;
	}
?>