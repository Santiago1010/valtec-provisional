<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-type: application/json');

ini_set("default_charset", "UTF-8");

// Se traen las funciones.
require '../controllers/functions/extraController.php';

// Se traen los controladores.
require '../controllers/usersController.php';

/**
 * Clase que recibirá los datos y las acciones de los usuarios.
 */
class receptionUsers extends extraController {

	private $usersController;
	
	public function __construct() {
		$this->usersController = new usersController();
	}

	public function invokerController()	{
		switch ($_POST['typeFunction']) {

			case 'createUser':
				if ($this->isEmpty($_POST['dataUser']) && $this->validateLength($_POST['dataUser']['passwordUser'], 8) && $this->validateEmail($_POST['dataUser']['emailUser']) && $this->validateNumbers($_POST['dataUser']['documentUser']) && $this->validateNumbers($_POST['dataUser']['phoneUser']) && $this->validateString($_POST['dataUser']['nameUser']) && $this->validateString($_POST['dataUser']['lastNameUser'])) {
					if ($_POST['dataUser']['passwordUser'] === $_POST['dataUser']['confirmPassword']) {
						return $this->usersController->createUser($_POST['dataUser']['documentUser'], $_POST['dataUser']['nameUser'], $_POST['dataUser']['lastNameUser'], $_POST['dataUser']['phoneUser'], $this->encryptRSA($this->encryptHash($this->encryptPassword($_POST['dataUser']['passwordUser']))), $this->encryptToken($_POST['dataUser']['documentUser']), $_POST['dataUser']['emailUser'], $_POST['dataUser']['roleUser'], $_POST['dataUser']['regionalUser'], $_POST['dataUser']['centerUser']);
					}else {
						return ['status' => 'error', 'message' => 'Las contraseñas no coinciden.'];
					}
				}else {
					return 'Faltan datos.';
				}
				break;

			case 'confirmUser':
				if ($this->isEmpty($_POST)) {
					return $this->usersController->confirmUser($_POST['tokenUser']);
				}else {
					return 'Faltan datos.';
				}
				break;

			case 'readUser':
				# code...
				break;

			case 'readUserLogin':
				if ($this->isEmpty($_POST) && $this->validateLength($_POST['passwordLogin'], 8)) {
					return $this->jsonString($this->usersController->loginUser($_POST['documentLogin'], $this->encryptPassword($_POST['passwordLogin'])));
				}else {
					return $this->jsonString(["message" => 'Los datos no coinciden.']);
				}
				break;

			case 'readPersonPassword':
				if ($this->isEmpty($_POST)) {
					return $this->usersController->readPersonPassword($_POST['tokenUser']);
				}else {
					return 'Los datos no coinciden.';
				}
				break;

			case 'updateUser':
				if ($this->isEmpty($_POST['userData']) && $this->validateString($_POST['userData']['nameUser']) && $this->validateString($_POST['userData']['lastNameUser']) && $this->validateNumbers($_POST['userData']['phoneUser']) && $this->validateLength($_POST['userData']['phoneUser'], 5, 10) && $this->validateNumbers($_POST['userData']['documentUser']) && $this->validateLength($_POST['userData']['documentUser'], 7, 10) && $this->validateEmail($_POST['userData']['emailUser'])) {
					return $this->usersController->updateUser($_POST['userData']['documentTypeUser'], $_POST['userData']['documentUser'], $_POST['userData']['nameUser'], $_POST['userData']['lastNameUser'], $_POST['userData']['phoneUser'], $_POST['userData']['emailUser']);
				}else {
					return 'Los datos no coinciden.';
				}
				break;

			case 'updateUserPassword':
				if ($this->isEmpty($_POST) && $this->validateNumbers($_POST['documentUser']) && $this->validateLength($_POST['documentUser'], 5, 10) && $_POST['newPassword'] == $_POST['confirmNewPassword']) {
					return $this->usersController->updatePasswordUser($_POST['documentUser'], $this->encryptPassword($_POST['newPassword']));
				}else {
					return 'Los datos no coinciden.';
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

	$r = new receptionUsers();
	print_r($r->invokerController());
}