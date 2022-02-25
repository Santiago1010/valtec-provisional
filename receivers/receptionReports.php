<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-type: application/json');

ini_set("default_charset", "UTF-8");
ini_set('memory_limit', '128M');

// Se traen las funciones.
require '../controllers/functions/validationClass.php';

// Se traen los controladores.
require '../controllers/reportsController.php';

/**
 * Clase que recibirá los datos y las acciones de los usuarios.
 */
class receptionReports extends validationClass {

	private $reportsController;
	
	public function __construct() {
		$_POST['typeFunction'] == 'createGeneralReport' ? $this->reportsController = new reportsController('../resources/documents/templates/generalTemplate.xlsx') : $this->reportsController = new reportsController('../resources/documents/templates/specificTemplate.xlsx');
	}

	public function invokerController()	{
		switch ($_POST['typeFunction']) {

			case 'createGeneralReport':
				return $this->reportsController->setGeneralReport($_POST['resultList']);
				break;

			case 'createSpecificReport':
				return $this->reportsController->setSpecificReport($_POST['idRi']);
				break;
			
			default:
				return $_POST;
				break;

		}
	}

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_POST = json_decode(file_get_contents("php://input"), true);
	
	$r = new receptionReports();
	print_r($r->invokerController());
}