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
		return $this->model->createUserDB(new usersClass('C.C.', $document, $name, $lastName, $phone, NULL, $password, $token, 'Sin confirmar', $this->setRol($rol), $regional, $center)) ? $this->sendEmailConfirm($name, $lastName, $emailConfirm, $token) : ["status" => "error", "message" => "No se pudo crear el usuario. Posiblemente ya se encuentre registrado."];
	}

	private function setRol(string $inRol) : string {
		$newRol = '$2y$08$neGVC1wxPWBN0EsDtSDUsuwtnhStfGm5fwnjJGoAwnasTZOaZm4.6';
		$roles = array(array('id' => '$2y$08$5PnCgHMU2RZ4OdwxSphdQOYIzw3d0Tr9GjFoBS4VBx0.2kWzK7Oqa', 'rol' => 'Coordinador(a) SENNOVA'), array('id' => '$2y$08$5PnCgHMU2RZ4OdwxSphdQOYIzw3d0Tr9GjFoBS4VBx0.2kWzK7Oqa', 'rol' => 'Dinamizador(a) TecnoParque'), array('id' => '$2y$08$5PnCgHMU2RZ4OdwxSphdQOYIzw3d0Tr9GjFoBS4VBx0.2kWzK7Oqa', 'rol' => 'Dinamizador(a) gestión de conocimiento'), array('id' => '$2y$08$5PnCgHMU2RZ4OdwxSphdQOYIzw3d0Tr9GjFoBS4VBx0.2kWzK7Oqa', 'rol' => 'Facilitador(a)'), array('id' => '$2y$08$ff8vI0yjXFDyvW.Px1H5uulp0K9MkQzlhYhWDXkV5vfUhapToo0B2', 'rol' => 'Dinamizador(a) SENNOVA'), array('id' => '$2y$08$ff8vI0yjXFDyvW.Px1H5uulp0K9MkQzlhYhWDXkV5vfUhapToo0B2', 'rol' => 'Líder grupo de investigación'), array('id' => '$2y$08$ff8vI0yjXFDyvW.Px1H5uulp0K9MkQzlhYhWDXkV5vfUhapToo0B2', 'rol' => 'Dinamizador(a) TecnoParque'), array('id' => '$2y$08$neGVC1wxPWBN0EsDtSDUsuwtnhStfGm5fwnjJGoAwnasTZOaZm4.6', 'rol' => 'Investigador(a)'));
		foreach ($roles as $key => $rol) {
			$inRol === $rol['rol'] ? $newRol = $rol['id'] : '$2y$08$neGVC1wxPWBN0EsDtSDUsuwtnhStfGm5fwnjJGoAwnasTZOaZm4.6';
		}
		return $newRol;
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