<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-type: application/json');

ini_set("default_charset", "UTF-8");

// Se traen las funciones.
require '../controllers/functions/validationClass.php';

// Se traen los controladores.
require '../model/statsModel.php';

/**
 * Clase que recibirá los datos y las acciones de los usuarios.
 */
class receptionStats extends validationClass {

	private $statsModel;
	
	public function __construct() {
		$this->statsModel = new statsModel();
	}

	public function invokerController()	{
		switch ($_POST['typeFunction']) {

			case 'readRegisterResults':
				return json_encode($this->statsModel->readRegisterResultsDB(), JSON_UNESCAPED_UNICODE);
				break;

			case 'readResultsBigger':
				return json_encode($this->statsModel->readResultsBiggerDB(), JSON_UNESCAPED_UNICODE);
				break;

			case 'readTotalUsers':
				return json_encode($this->statsModel->readTotalUsersDB(), JSON_UNESCAPED_UNICODE);
				break;
			
			default:
				return 'No se pudo realizar la acción.';
				break;

		}
	}

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_POST = json_decode(file_get_contents("php://input"), true);
	
	$r = new receptionStats();
	print_r($r->invokerController());
}