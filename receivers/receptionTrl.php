<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-type: application/json');

ini_set("default_charset", "UTF-8");

// Se traen las funciones.
require '../controllers/functions/validationClass.php';

// Se traen los controladores.
require '../controllers/trlController.php';

/**
 * Clase que recibirá los datos y las acciones de los usuarios.
 */
class receptionTrl extends validationClass {

	private $trlController;
	
	public function __construct() {
		$this->trlController = new trlController();
	}

	public function invokerController()	{
		switch ($_POST['typeFunction']) {

			case 'readRIData':
				if ($this->isEmpty($_POST)) {
					return $this->trlController->readRIData($_POST['idRi']);
				}
				break;

			case 'readChecks':
				if ($this->isEmpty($_POST)) {
					return $this->trlController->readChecks($_POST['idRi']);
				}
				break;

			case 'updateTrl':
				if ($this->isEmpty($_POST)) {
					return $this->trlController->updateTrl($_POST['idRi'], $_POST['newTrl']);
				}
				break;

			case 'updateChecks':
				if ($this->isEmpty($_POST)) {
					return $this->trlController->updateChecks($_POST['idRi'], $_POST['checks']);
				}
				break;
			
			default:
				return 'No se pudo realizar la acción.';
				break;

		}
	}

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_POST = json_decode(file_get_contents("php://input"), true);
	
	$r = new receptionTrl();
	print_r($r->invokerController());
}