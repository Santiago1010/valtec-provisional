<?php

include '../model/functions/connection.php';

/**
 * Clase que conecta con la base de datos de los usuarios.
 */
class statsModel {

	private $connection;
	
	public function __construct() {
		$this->connection = connection::getInstance();
	}

	public function readRegisterResultsDB() {
		try {
			$ps = $this->connection->getPrepareStatement(['StatsModel', 'readRegisterResults']);
			return $this->connection->getFetch($ps, false);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readResultsBiggerDB() {
		try {
			$ps = $this->connection->getPrepareStatement(['StatsModel', 'readResultsBigger']);
			return $this->connection->getFetch($ps, false);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readTotalUsersDB() {
		try {
			$ps = $this->connection->getPrepareStatement(['StatsModel', 'readTotalUsers']);
			return $this->connection->getFetch($ps, false);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

}