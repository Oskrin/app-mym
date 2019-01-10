<?php  
	if(!isset($_SESSION)){
	    session_start();        
	}
	include_once('../admin/class.php');
	$class = new constante();

	if(isset($_POST['consultar_login_user'])) {
		// sesion empresa
		$res = $class->consulta("SELECT * FROM empresa WHERE estado = '1'");
		while ($row = $class->fetch_array($res)) {
			$_SESSION['empresa'] = array(	'id'=>$row[0], 
											'ruc' => $row[1],
											'razon_social' => $row[2], 
											'nombre_comercial' => $row[3],
											'telefono1' => $row[4],
											'telefono2' => $row[5],
											'ciudad' => $row[6],
											'direccion' => $row[7],
											'correo' => $row[8],
											'slogan' => $row[9],
											'imagen' => $row[11]);
		}
		// fin

		$resultado = $class->consulta("SELECT *, (SELECT data FROM privilegios P WHERE  U.id_perfil = P.id_perfil) AS data_privilegio FROM usuarios U WHERE U.usuario = '".$_POST['txt_nombre']."' and clave = md5('".$_POST['txt_clave']."')");

		if($class->num_rows($resultado) == 1) {
			$row = $class->fetch_array($resultado);
			$_SESSION['user'] = array(	'id'=>$row[0], 
										'name' => $row[2], 
										'usuario' => $row[8], 
										'cargo' => $row[10], 
										'imagen' => $row[11], 
										'privilegio' => $row['data_privilegio']);

			print_r(json_encode(array('status' => 'ok', 'id' => $row[0], 'name' => $row[2], 'usuario' => $row[8], 'imagen' => $row[11], 'privilegio' => $row['data_privilegio'])));
		} else {
			print_r(json_encode(array('status' => 'error', 'problem' => 'user no valid')));
		}		
	}
?>


