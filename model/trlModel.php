<?php

include '../model/functions/connection.php';

/**
 * Clase que conecta con la base de datos de los usuarios.
 */
class trlModel {

	private $connection;
	
	public function __construct() {
		$this->connection = connection::getInstance();
	}

	public function readRIDataDB(resultsClass $result) {
		try {
			$ps = $this->connection->getPrepareStatement(['TrlModels', 'readRIsData']);
			return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $result, ['getId']), false);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readChecksDB(resultsClass $result) {
		try {
			$ps = $this->connection->getPrepareStatement(['TrlModels', 'readChecksRIs']);
			return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $result, ['getId']), true);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function updateTrlDB($id, $trl) {
		try {
			$ps = $this->connection->getPrepareStatement(['TrlModels', 'updateTrlResults']);
			$ps->bindValue(1, $id, PDO::PARAM_INT);
			$ps->bindValue(2, $trl, PDO::PARAM_STR);
			return $this->connection->getExecute($ps);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function updateChecksDB(checksClass $check) {
		try {
			$ps = $this->connection->getPrepareStatement(['TrlModels', 'updateChecksResults']);
			return $this->connection->getExecute($this->connection->getBindValue(true, $ps, $check, ['__construct', 'getId']));
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

}