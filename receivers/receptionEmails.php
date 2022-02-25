<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-type: application/json');

ini_set("default_charset", "UTF-8");

// Se requieren las funciones.
require '../controllers/functions/validationClass.php';
require '../controllers/functions/emailController.php';

/**
 * Clase que recibe y reenvía los datos.
 */
class receptionEmails extends validationClass {

	public function invokeControllers() {
		switch ($_POST['typeFunction']) {
			//Enviar correo de contacto.
			case 'sendEmailContact':
				if ($this->isEmpty($_POST)) {
					if ($this->validateEmail($_POST['emailContact'])) {
						$email = new emailController($_POST['nameContact'], $_POST['emailContact'], 'CORREO ACERCA DE LA PLATAFORMA VALTEC, POR', $_POST['messageContact']);
						return $email->sendContactEmail();
					}else {
						return 'Los datos no coinciden.';
					}
				}else {
					return 'Se requieren todos los datos.';
				}
				break;
				
			case 'sendSuggestionContact':
				if ($this->isEmpty($_POST)) {
					$email = new emailController('ValTec', 'contacto@valtec.systems', 'SUGERENCIA DE MEJORA PARA VALTEC', $_POST['message']);
					return $email->sendSuggestionEmail();
				}else {
					return 'Se requieren todos los datos.';
				}
				break;

			default:
				return 'No se ha podido realizar la acción.';
				break;
		}
	}

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_POST = json_decode(file_get_contents("php://input"), true);
	
	$r = new receptionEmails();
	echo($r->invokeControllers());
}