<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-type: application/json');

ini_set("default_charset", "UTF-8");

// Se traen las funciones.
require '../controllers/functions/validationClass.php';

// Se traen los controladores.
require '../controllers/passwordController.php';

/**
 * Clase que recibirá los datos y las acciones de los usuarios.
 */
class receptionPassword extends validationClass {

	private $passwordController;
	
	public function __construct() {
		$this->passwordController = new passwordController();
	}

	public function invokerController()	{
		switch ($_POST['typeFunction']) {

			case 'sendEmailRecoverPassword':
				if ($this->isEmpty($_POST)) {
					return !empty($user = $this->passwordController->readUserData($_POST['documentUserRecoverPassword'])) && $user != false ? $this->passwordController->sendEmailConfirm($user['documento_usuario'], $user['nombres_usuarios'], $user['apellidos_usuarios'], $user['correo_usuario'], $this->encryptToken($user['documento_usuario'])) : 'No se ha encontrado un correo al cual enviar el link para recuperar la contraseña.';
				}else {
					return 'Faltan datos.';
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

	$r = new receptionPassword();
	print_r($r->invokerController());
}