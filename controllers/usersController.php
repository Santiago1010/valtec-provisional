<?php

// Se traen las cápsulas.
require '../controllers/capsules/usersClass.php';

// Se traen las funciones.
require '../controllers/functions/emailController.php';

// Se trae el modelo.
require '../model/usersModel.php';

/**
 * Clase que cotrola y gestiona los datos de los usuarios.
 */
class usersController extends extraController {
	
	private $model;

	public function __construct() {
		$this->model = new usersModel();
	}

	public function createUser(int $document, string $name, string $lastName, int $phone, string $password, string $token, string $rol, int $regional, int $center) : bool | array {
		return $this->model->createUserDB(new usersClass('C.C.', $document, $name, $lastName, $phone, NULL, $password, $token, 'Sin confirmar', $rol, $regional, $center)) ? $this->sendEmailConfirm($name, $lastName, $emailConfirm, $token) : ["status" => "error", "message" => "No se pudo crear el usuario. Posiblemente ya se encuentre registrado."];
	}

	public function confirmUser($token) {
		$readEmail = new usersClass(NULL, NULL, NULL, NULL, NULL, NULL, NULL, $token);
		$email = $this->model->readTemporalEmailDB($readEmail);
		if (!empty($email)) {
			$user = new usersClass(NULL, NULL, NULL, NULL, NULL, $email['personal_sin'], NULL, $token);
			return $this->model->confirmUserDB($user);
		}else {
			return false;
		}		
	}

	public function sendEmailConfirm($name, $lastName, $emailConfirm, $token) {
		$email = new emailController($name . ' ' . $lastName, $emailConfirm, 'CORREO DE CONFIRMACIÓN', NULL, $token);
		return $email->sendConfirmEmail();
	}

	public function loginUser(int $document, string $password) : array {
		return $this->validHash($password, $this->decryptRSA($this->model->readUsersPasswordDB(new usersClass(NULL, (int)$document))['password'])) ? $this->model->readUserLoginDB(new usersClass(NULL, $document)) : ["status" => "error", "message" => "No se han podido confirmar los datos"];
	}

	public function readPersonPassword($token) {
		$user = new usersClass(NULL, NULL, NULL, NULL, NULL, NULL, NULL, $token);
		return json_encode($this->model->readPersonPasswordDB($user), JSON_UNESCAPED_UNICODE);
	}

	public function updatePasswordUser($document, $password) {
		$user = new usersClass('C.C.', $document, NULL, NULL, NULL, NULL, $password);
		return $this->model->updatePasswordUserDB($user);
	}

	public function updateUser($documentType, $document, $name, $lastName, $phone, $email) {
		$user = new usersClass($documentType, $document, $name, $lastName, $phone, $email);
		return $this->model->updateUserDB($user);
	}

}