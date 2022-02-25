<?php

include '../model/functions/connection.php';

/**
 * Clase que conecta con la base de datos de los usuarios.
 */
class usersModel {

	private $connection;
	
	public function __construct() {
		$this->connection = connection::getInstance();
	}

	public function createUserDB(usersClass $user) {
		try {
			$ps = $this->connection->getPrepareStatement(['UsersModel', 'createUser']);
			return $this->connection->getExecute($this->connection->getBindValue(true, $ps, $user, ['__construct', 'getEmail', 'getCity']));
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readTemporalEmailDB(usersClass $user) {
		try {
			$ps = $this->connection->getPrepareStatement(['UsersModel', 'getTemporalEmails']);
			return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $user, ['getToken']), false);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function confirmUserDB(usersClass $user) {
		try {
			$ps = $this->connection->getPrepareStatement(['UsersModel', 'confimrUsers']);
			return $this->connection->getExecute($this->connection->getBindValue(false, $ps, $user, ['getEmail', 'getToken']));
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readUsersPasswordDB(usersClass $user) : array {
		try {
			return $this->connection->getFetch($this->connection->getBindValue(false, $this->connection->getPrepareStatement(['UsersModel', 'readDataUserPassword']), $user, ['getDocument']), false);
		} catch (PDOException $e) {
			return ['Error PDO: ' . $e];
		}
	}

	public function readUserLoginDB(usersClass $user) : array {
		try {
			return $this->connection->getFetch($this->connection->getBindValue(false, $this->connection->getPrepareStatement(['UsersModel', 'readLoginData']), $user, ['getDocument']), false);
		} catch (PDOException $e) {
			return ['Error PDO: ' . $e];
		}
	}

	public function readUserDataDB(usersClass $user) {
		$ps = $this->connection->getPrepareStatement(['UsersModel', 'readUserData']);
		return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $user, ['getDocument']), false);
	}

	public function readPersonPasswordDB(usersClass $user) {
		$ps = $this->connection->getPrepareStatement(['UsersModel', 'readDataUserPassword']);
		return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $user, ['getToken']), false);
	}

	public function setTokenUserDB(usersClass $user) {
		$ps = $this->connection->getPrepareStatement(['UsersModel', 'setTokenUsers']);
		return $this->connection->getExecute($this->connection->getBindValue(false, $ps, $user, ['getToken', 'getDocument']));
	}

	public function updatePasswordUserDB(usersClass $user) {
		try {
			$ps = $this->connection->getPrepareStatement(['UsersModel', 'updatePasswords']);
			return $this->connection->getExecute($this->connection->getBindValue(false, $ps, $user, ['getPassword', 'getDocument']));
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function updateUserDB(usersClass $user) {
		try {
			$ps = $this->connection->getPrepareStatement(['UsersModel', 'updateDataUsers']);
			return $this->connection->getExecute($this->connection->getBindValue(false, $ps, $user, ['getDocumentType', 'getDocument', 'getName', 'getLastName', 'getPhone', 'getEmail']));
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

}