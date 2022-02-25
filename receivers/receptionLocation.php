<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-type: application/json');

ini_set("default_charset", "UTF-8");

// Se traen las funciones.
require '../controllers/functions/validationClass.php';

// Se traen los controladores.
require '../controllers/locationsController.php';

/**
 * Clase que recibirá los datos y las acciones de los usuarios.
 */
class receptionLocation extends validationClass {

	private $locationsController;
	
	public function __construct() {
		$this->locationsController = new locationsController();
	}

	public function invokerController()	{
		switch ($_POST['typeFunction']) {

			case 'readRegionals':
				return $this->locationsController->readRegionals();
				break;

			case 'readCenters':
				if ($this->isEmpty($_POST)) {
					return $this->locationsController->readCenters($_POST['idRegional']);
				}else {
					return 'Faltan datos.';
				}
				break;

			case 'readRoles':
				return $this->locationsController->readRoles();
				break;

			case 'readKnowledgeNetworks':
				return $this->locationsController->readKnowledgeNetworks();
				break;

			case 'readInvestigationGroups':
				return $this->locationsController->readInvestigationGroups($_POST['idCenter']);
				break;
			
			default:
				return 'No se pudo realizar la acción.';
				break;

		}
	}

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_POST = json_decode(file_get_contents("php://input"), true);
	
	$r = new receptionLocation();
	print_r($r->invokerController());
}