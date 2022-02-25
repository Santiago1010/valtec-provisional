<?php

// Se traen las cápsulas.
require '../controllers/capsules/resultsClass.php';
require '../controllers/capsules/usersProjectsClasss.php';
require '../controllers/capsules/temporaryUserClass.php';
require '../controllers/capsules/selectsClass.php';
require '../controllers/capsules/usersClass.php';

// Se trae el modelo.
require '../model/resultsModel.php';

/**
 * Clase que cotrola y gestiona los datos de los resultados de investigación.
 */
class resultsController {
	
	private $model;

	public function __construct() {
		$this->model = new usersModel();
	}

	public function createResearchResult($nameProject = NULL, $nameTech = NULL, $year = NULL, $typeCode = NULL, $sgps = NULL, $review = NULL, $typeResult = NULL, $gorupResult = NULL, $especificResult = NULL, $subArea = NULL, $idArea = NULL, $rights = NULL, $start = NULL, $regional = NULL, $center = NULL, $group = NULL, $document, $name, $role) {
		$id = $this->readMaxId();
		$results = new resultsClass($id, $nameProject, $nameTech, $year, $typeCode, $sgps, $review, $typeResult, $gorupResult, $especificResult, $subArea, $idArea, $rights, $start, $regional, $center, $group);
		if ($this->model->createResearchResultDB($results)) {
			if ($this->setCheckboxes($id)) {
				return $this->setInvestigatorProjects($id, $document, $name, $role);
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	private function setCheckboxes($id) {
		$checkboxes = ['checkbox1-1', 'checkbox1-2', 'checkbox1-3', 'checkbox1-4', 'checkbox1-5', 'checkbox1-6', 'checkbox1-7', 'checkbox2-1', 'checkbox2-2', 'checkbox2-3', 'checkbox2-4', 'checkbox2-5', 'checkbox2-6', 'checkbox2-7', 'checkbox2-8', 'checkbox3-1', 'checkbox3-2', 'checkbox3-3', 'checkbox3-4', 'checkbox3-5', 'checkbox3-6', 'checkbox3-7', 'checkbox3-8', 'checkbox4-1', 'checkbox4-2', 'checkbox4-3', 'checkbox4-4', 'checkbox4-5', 'checkbox4-6', 'checkbox4-7', 'checkbox4-8', 'checkbox5-1', 'checkbox5-2', 'checkbox5-3', 'checkbox5-4', 'checkbox5-5', 'checkbox5-6', 'checkbox5-7', 'checkbox5-8', 'checkbox6-1', 'checkbox6-2', 'checkbox6-3', 'checkbox6-4', 'checkbox6-5', 'checkbox6-6', 'checkbox6-7', 'checkbox6-8', 'checkbox6-9', 'checkbox6_10', 'checkbox7-1', 'checkbox7-2', 'checkbox7-3', 'checkbox7-4', 'checkbox7-5', 'checkbox7-6', 'checkbox7-7', 'checkbox8-1', 'checkbox8-2', 'checkbox8-3', 'checkbox8-4', 'checkbox8-5', 'checkbox8-6', 'checkbox8-7', 'checkbox9-1', 'checkbox9-2', 'checkbox9-3', 'checkbox9-4', 'checkbox9-5', 'checkbox9-6', 'checkbox9-7'];

		for ($i = 0; $i < count($checkboxes); $i++) { 
			$checks = new selectsClass(NULL, $checkboxes[$i], 'unchecked', $id);
			$check = $this->model->setSelectsDB($checks);
		}
		return $check;
	}

	private function setInvestigatorProjects($id, $document, $name, $role) {
		$register = true;
		$check = false;
		foreach ($document as $key => $val) {
			$user = new usersClass(NULL, $val);
			if ($this->model->readUserExistDB($user)['total'] == 1) {
				$relation = new usersProjectsClasss(NULL, $val, $id, NULL, $role[$key]);
			}else {
				$temporary = new temporaryUserClass(NULL, $val, $name[$key]);
				$this->model->createTemporaryUserDB($temporary);
				$temporary ? $relation = new usersProjectsClasss(NULL, NULL, $id, $val, $role[$key]) : false;
			}
			$check = $this->model->ceateRelationInvestigatorProjectsDB($relation);
		}
		return $check;
	}

	private function readMaxId()	{
		$id = $this->model->readMaxIdDB();
		return $id['max'] + 1;
	}

	public function readResultCode($code) {
		$results = new resultsClass(NULL, NULL, NULL, NULL, NULL, $code);
		return $this->model->readResultCodeDB($results)['total'] >= 1 ? false : true;
	}

	public function readResultOnly($id) {
		$results = new resultsClass($id);
		return json_encode($this->model->readResultOnlyDB($results), JSON_UNESCAPED_UNICODE);
	}

	public function readInvestigatorsResult($idProject) {
		$relation = new usersProjectsClasss(NULL, NULL, $idProject);
		return json_encode($this->model->readInvestigatorsResultDB($relation), JSON_UNESCAPED_UNICODE);
	}

	public function readResearchResults($document) {
	    $user = new usersClass(NULL, $document);
	    if ($this->model->readUserRolDB($user)['id_rol'] == 10 || $this->model->readUserRolDB($user)['id_rol'] == 11 || $this->model->readUserRolDB($user)['id_rol'] == 12) {
	        return json_encode($this->readOwn($document), JSON_UNESCAPED_UNICODE);
	    }else {
		    return json_encode(array_merge($this->readOwn($document), $this->readOthers($document)), JSON_UNESCAPED_UNICODE);
	    }
	}

	public function updateResearchResult($id = NULL, $nameProject = NULL, $nameTech = NULL, $year = NULL, $typeCode = NULL, $sgps = NULL, $review = NULL, $typeResult = NULL, $gorupResult = NULL, $especificResult = NULL, $subArea = NULL, $idArea = NULL, $rights = NULL, $start = NULL, $regional = NULL, $center = NULL, $group = NULL, $document, $name, $role) {
		$results = new resultsClass($id, $nameProject, $nameTech, $year, $typeCode, $sgps, $review, $typeResult, $gorupResult, $especificResult, $subArea, $idArea, $rights, $start, $regional, $center, $group);
		return $this->model->updateResearchResultDB($results);
	}

	public function deleteInvestigatorsResult($id) {
		$relation = new usersProjectsClasss($id);
		return json_encode($this->model->deleteInvestigatorsResultDB($relation), JSON_UNESCAPED_UNICODE);
	}

	private function readOwn($document) {
		$result = new usersProjectsClasss(NULL, $document);
		return $this->model->readOwnDB($result);
	}

	private function readOthers($document) {
		$result = new usersProjectsClasss(NULL, $document);
		return $this->model->readOthersDB($result);
	}

}