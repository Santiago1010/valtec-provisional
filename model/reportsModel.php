<?php

include '../model/functions/connection.php';

/**
 * Clase que conecta con la base de datos de los usuarios.
 */
class reportsModel {

	private $connection;
	
	public function __construct() {
		$this->connection = connection::getInstance();
	}

	public function readInvestigatorsResultDB(resultsClass $result) {
		$ps = $this->connection->getPrepareStatement(['ResultsModel', 'readInvestigatorsResults']);
		return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $result, ['getId']), true);
	}

	public function readValidationDataDB(resultsClass $result) {
		$ps = $this->connection->getPrepareStatement(['ValidationModel', 'readValidationRIs']);
		return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $result, ['getId']), false);
	}

	public function readResultOnlyDB(resultsClass $result) {
		try {
			$ps = $this->connection->getPrepareStatement(['ResultsModel', 'readOnlyResult']);
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

}