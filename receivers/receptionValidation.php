<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-type: application/json');

ini_set("default_charset", "UTF-8");

// Se traen las funciones.
require '../controllers/functions/validationClass.php';

// Se traen los controladores.
require '../controllers/validationController.php';

/**
 * Clase que recibirá los datos y las acciones de los usuarios.
 */
class receptionValidation extends validationClass {

	private $validationController;
	
	public function __construct() {
		$this->validationController = new validationController();
	}

	public function invokerController()	{
		switch ($_POST['typeFunction']) {

			case 'readValidationData':
				return json_encode($this->validationController->readValidationRi($_POST['idRi']), JSON_UNESCAPED_UNICODE);
				break;

			case 'setValidationData':
				return $this->validationController->setActionValidation($_POST['idRi'], $_POST['data']);
				break;
			
			default:
				return 'No se pudo realizar la acción.';
				break;

		}
	}

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_POST = json_decode(file_get_contents("php://input"), true);

	$r = new receptionValidation();
	print_r($r->invokerController());
}