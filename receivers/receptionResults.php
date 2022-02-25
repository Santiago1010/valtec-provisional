<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-type: application/json');

ini_set("default_charset", "UTF-8");

// Se traen las funciones.
require '../controllers/functions/validationClass.php';

// Se traen los controladores.
require '../controllers/resultsController.php';

/**
 * Clase que recibirá los datos y las acciones de los usuarios.
 */
class receptionResults extends validationClass {

	private $resultController;
	
	public function __construct() {
		$this->resultController = new resultsController();
	}

	public function invokerController()	{
		switch ($_POST['typeFunction']) {

			case 'createResult':
				if ($this->isEmpty($_POST['result'])) {
					return $this->resultController->createResearchResult($_POST['result']['projectName'], $_POST['result']['resultName'], $_POST['result']['yearResult'], $_POST['result']['codeType'], $_POST['result']['idCode'], $_POST['result']['reviewResult'], $_POST['result']['typologyResult'], $_POST['result']['resultGroup'], $_POST['result']['resultArea'], $_POST['result']['subArea'], $_POST['result']['knowledgeNetwork'], 'Sí', $_POST['result']['registrationDate'], $_POST['result']['regionalResult'], $_POST['result']['centerResult'], $_POST['result']['investigationGroupResult'], $_POST['result']['documentInvestigator'], $_POST['result']['nameInvestigator'], $_POST['result']['roleInvestigator']);
				}
				break;

			case 'readResultOnly':
				return $this->resultController->readResultOnly($_POST['idRi']);
				break;

			case 'readResultList':
				return $this->resultController->readResearchResults($_POST['document']);
				break;

			case 'readResultCode':
				return $this->resultController->readResultCode($_POST['code']);
				break;

			case 'readInvestigatorsResult':
				return $this->resultController->readInvestigatorsResult($_POST['idResult']);
				break;

			case 'updateResult':
				return $this->resultController->updateResearchResult($_POST['result']['id'], $_POST['result']['projectName'], $_POST['result']['resultName'], $_POST['result']['yearResult'], $_POST['result']['codeType'], $_POST['result']['idCode'], $_POST['result']['reviewResult'], $_POST['result']['typologyResult'], $_POST['result']['resultGroup'], $_POST['result']['resultArea'], $_POST['result']['subArea'], $_POST['result']['knowledgeNetwork'], 'Sí', $_POST['result']['registrationDate'], $_POST['result']['regionalResult'], $_POST['result']['centerResult'], $_POST['result']['investigationGroupResult'], $_POST['result']['documentInvestigator'], $_POST['result']['nameInvestigator'], $_POST['result']['roleInvestigator']);
				break;

			case 'deleteInvestigatorsResult':
				return $this->resultController->deleteInvestigatorsResult($_POST['idRelation']);
				break;
			
			default:
				return 'No se pudo realizar la acción.';
				break;

		}
	}

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_POST = json_decode(file_get_contents("php://input"), true);
	
	$r = new receptionResults();
	print_r($r->invokerController());
}