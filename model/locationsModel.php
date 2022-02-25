<?php

include '../model/functions/connection.php';

/**
 * Clase que conecta con la base de datos de los usuarios.
 */
class locationsModel {

	private $connection;
	
	public function __construct() {
		$this->connection = connection::getInstance();
	}

	public function readRegionalsDB() {
		try {
			$ps = $this->connection->getPrepareStatement(['LocationsModel', 'readRegionals']);
			return $this->connection->getFetch($ps, true);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readCentersDB($id) {
		try {
			$ps = $this->connection->getPrepareStatement(['LocationsModel', 'readCenters']);
			$ps->bindValue(1, $id, PDO::PARAM_INT);
			return $this->connection->getFetch($ps, true);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readRolesDB() {
		try {
			$ps = $this->connection->getPrepareStatement(['LocationsModel', 'readRoles']);
			return $this->connection->getFetch($ps, true);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readKnowledgeNetworksDB() {
		try {
			$ps = $this->connection->getPrepareStatement(['LocationsModel', 'readKnowledeAreas']);
			return $this->connection->getFetch($ps, true);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readInvestigationGroupsDB($id) {
		try {
			$ps = $this->connection->getPrepareStatement(['LocationsModel', 'readInvestigationGroups']);
			$ps->bindValue(1, $id, PDO::PARAM_INT);
			return $this->connection->getFetch($ps, true);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

}