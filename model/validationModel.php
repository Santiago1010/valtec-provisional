<?php

include '../model/functions/connection.php';

/**
 * Clase que conecta con la base de datos de los usuarios.
 */
class validationModel {

	private $connection;
	
	public function __construct() {
		$this->connection = connection::getInstance();
	}

	public function createValidationDB(validationCapsule $validation) {
		try {
			$ps = $this->connection->getPrepareStatement(['ValidationModel', 'createValidationDatas']);
			return $this->connection->getExecute($this->connection->getBindValue(true, $ps, $validation, ['__construct', 'getId']));
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readValidationRiDB(validationCapsule $validation) {
		try {
			$ps = $this->connection->getPrepareStatement(['ValidationModel', 'readValidationRIs']);
			return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $validation, ['getProject']), false);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function updateValidationDB(validationCapsule $validation) {
		try {
			$ps = $this->connection->getPrepareStatement(['ValidationModel', 'updateValidationDatas']);
			return $this->connection->getExecute($this->connection->getBindValue(true, $ps, $validation, ['__construct', 'getId']));
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

}