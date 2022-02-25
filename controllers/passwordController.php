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
class passwordController {
	
	private $model;

	public function __construct() {
		$this->model = new usersModel();
	}

	public function readUserData($document)	{
		$user = new usersClass(NULL, $document);
		return $this->model->readUserDataDb($user);
	}

	public function sendEmailConfirm($document, $name, $lastName, $emailConfirm, $token) {
		$user = new usersClass(NULL, $document, NULL, NULL, NULL, NULL, NULL, $token);
		$email = new emailController($name . ' ' . $lastName, $emailConfirm, 'LINK PARA CAMBIO DE CONTRASEÑA DE', NULL, $token);
		return $this->model->setTokenUserDB($user) ? $email->sendRecoverPasswordEmail() : false;
	}

	public function consult() {
		// code...
	}

}