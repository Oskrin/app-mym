<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();
	error_reporting(0);
	$fecha = $class->fecha_hora();

	// modificar privilegios
	if (isset($_POST['updateprivilegios'])) {
		$vector = json_encode($_POST['data']);
		$data = 0;

		$resp = $class->consulta("UPDATE privilegios SET data = '$vector' WHERE id_perfil = '$_POST[user]'");
		if ($resp) {
			$data = 1;
		} 

		echo $data;
	}
	// fin

	//LLena combo cargos
	if (isset($_POST['llenar_cargos'])) {
		$id = $class->idz();
		$resultado = $class->consulta("SELECT * FROM perfil WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row['id'].'">'.$row['nombre_perfil'].'</option>';
		}
	}
	// fin

	// estado privilegios
	function buscarstatus($array, $valor) {
		$retorno = array_search($valor, $array);
		if ($retorno) {
			return true;
		} else {
			return false;
		}	
	}
	// fin

	// Inicios methodo recursos data
	if (isset($_POST['retornar'])) {
		$sum;
		$result = $class->consulta("SELECT * FROM privilegios WHERE id_perfil = '".$_POST['id']."'");
		while ($row = $class->fetch_array($result)) {
			$sum = json_decode($row['data']);
		}

		$acumulador = 
		array(
			'Menu' => 
				array(
				'text' => 'Menu',
				'type' => 'folder',
				'additionalParameters' => 
					array(
						'id' => 1,
						'children' => 
						array(
							'Cuenta'=> 
							array(
								'text' => 'Cuenta', 
								'type' => 'item',
								'id' => 'cuenta',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'cuenta')
								)
							),
							'Privilegios'=> 
							array(
								'text' => 'Privilegios', 
								'type' => 'item',
								'id' => 'privilegios',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'privilegios')
								)
							),
							'RegistroEmpresa'=> 
							array(
								'text' => 'Registro Empresa', 
								'type' => 'item',
								'id' => 'empresa',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'empresa')
								)
							),
							'Cargos'=> 
							array(
								'text' => 'Cargos', 
								'type' => 'item',
								'id' => 'cargos',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'cargos')
								)
							),
							'Servicios'=> 
							array(
								'text' => 'Servicios', 
								'type' => 'item',
								'id' => 'servicios',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'servicios')
								)
							),
							'Clientes'=> 
							array(
								'text' => 'Clientes', 
								'type' => 'item',
								'id' => 'clientes',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'clientes')
								)
							),
							'Empleados'=> 
							array(
								'text' => 'Empleados', 
								'type' => 'item',
								'id' => 'empleados',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'empleados')
								)
							),
							'Winchas'=> 
							array(
								'text' => 'Winchas', 
								'type' => 'item',
								'id' => 'winchas',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'winchas')
								)
							),
							'Disponibles'=> 
							array(
								'text' => 'Disponibles', 
								'type' => 'item',
								'id' => 'disponibles',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'disponibles')
								)
							),
							'Perfil'=> 
							array(
								'text' => 'Perfil', 
								'type' => 'item',
								'id' => 'perfil',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'perfil')
								)
							),
							'RegistroUsuarios'=> 
							array(
								'text' => 'Registro Usuarios', 
								'type' => 'item',
								'id' => 'usuarios',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'usuarios')
								)
							)
						)
					)
				)
			);

		//$resultado = $class->consulta("SELECT * FROM cargos WHERE estado = '1' order by id asc");
		//while ($row = $class->fetch_array($resultado)) {
		//}

		$acu2;
		for ($i = 0; $i < count($acu); $i++) { 
			$acu2[$i] = array(
							'text' => $acu[$i], 
							'type' => 'folder',
							'additionalParameters' => 
												array(
													'id' => '1',
													'children'=> 
													array('opcion2' => 
														array(
															'text' => 'opcion2', 
															'type' => 'item',
															'id'=>'moji',
															'additionalParameters' => 
															array(
																'item-selected' => true
															)
														)
													)
												)
											);
		}

		print(json_encode($acumulador));
	}
	// fin
?>

