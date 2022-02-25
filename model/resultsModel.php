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

	public function createResearchResultDB(resultsClass $result) {
		$ps = $this->connection->getPrepareStatement(['ResultsModel', 'createResearchResults']);
		return $this->connection->getExecute($this->connection->getBindValue(true, $ps, $result, ['__construct']));
	}

	public function createTemporaryUserDB(temporaryUserClass $temporary) {
		$ps = $this->connection->getPrepareStatement(['UsersModel', 'createTemporaryUsers']);
		return $this->connection->getExecute($this->connection->getBindValue(true, $ps, $temporary, ['__construct', 'getId']));
	}

	public function ceateRelationInvestigatorProjectsDB(usersProjectsClasss $relation) {
		$ps = $this->connection->getPrepareStatement(['ResultsModel', 'createRelationInvestigatorsProjects']);
		return $this->connection->getExecute($this->connection->getBindValue(true, $ps, $relation, ['__construct', 'getId']));
	}

	public function setSelectsDB(selectsClass $select) {
		$ps = $this->connection->getPrepareStatement(['SelectsModel', 'setSelect']);
		return $this->connection->getExecute($this->connection->getBindValue(true, $ps, $select, ['__construct', 'getId', 'getState']));
	}

	public function readUserExistDB(usersClass $user) {
		$ps = $this->connection->getPrepareStatement(['UsersModel', 'readUsersExist']);
		return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $user, ['getDocument']), false);
	}

	public function readUserRolDB(usersClass $user) {
		$ps = $this->connection->getPrepareStatement(['UsersModel', 'readUserData']);
		return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $user, ['getDocument']), false);
	}

	public function readMaxIdDB() {
		$ps = $this->connection->getPrepareStatement(['ResultsModel', 'readMaxId']);
		return $this->connection->getFetch($ps, false);
	}

	public function readResultCodeDB(resultsClass $result) {
		try {
			$ps = $this->connection->getPrepareStatement(['ResultsModel', 'readResultCode']);
			return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $result, ['getSgps']), false);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readResultOnlyDB(resultsClass $result) {
		try {
			$ps = $this->connection->getPrepareStatement(['ResultsModel', 'readOnlyResult']);
			return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $result, ['getId']), false);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readResearchResultsDB() {
		try {
			$ps = $this->connection->getPrepareStatement(['ResultsModel', 'readReseachResults']);
			return $this->connection->getFetch($ps, true);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readInvestigatorsResultDB(usersProjectsClasss $relation) {
		try {
			$ps = $this->connection->getPrepareStatement(['ResultsModel', 'readInvestigatorsResults']);
			return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $relation, ['getProject']), true);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function updateResearchResultDB(resultsClass $result) {
		$ps = $this->connection->getPrepareStatement(['ResultsModel', 'updateResearchResults']);
		return $this->connection->getExecute($this->connection->getBindValue(true, $ps, $result, ['__construct']));
	}

	public function deleteInvestigatorsResultDB(usersProjectsClasss $relation) {
		try {
			$ps = $this->connection->getPrepareStatement(['ResultsModel', 'deleteInvestigatorsResults']);
			return $this->connection->getExecute($this->connection->getBindValue(false, $ps, $relation, ['getId']));
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readOwnDB(usersProjectsClasss $result) {
		try {
			$ps = $this->connection->getPrepareStatement(['ResultsModel', 'readOwn']);
			return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $result, ['getDocument']), true);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

	public function readOthersDB(usersProjectsClasss $result) {
		try {
			$ps = $this->connection->getPrepareStatement(['ResultsModel', 'readOthers']);
			return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $result, ['getDocument', 'getDocument']), true);
		} catch (PDOException $e) {
			return 'Error PDO: ' . $e;
		}
	}

}