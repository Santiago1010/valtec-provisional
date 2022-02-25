<?php

// Se traen las cápsulas.
require '../controllers/capsules/resultsClass.php';
require '../controllers/capsules/checksClass.php';

// Se trae el modelo.
require '../model/trlModel.php';

/**
 * Clase que cotrola y gestiona los datos de los resultados de investigación.
 */
class trlController {
	
	private $model;

	public function __construct() {
		$this->model = new trlModel();
	}

	public function readRIData($id) {
		$result = new resultsClass($id);
		return json_encode($this->model->readRIDataDB($result), JSON_UNESCAPED_UNICODE);
	}

	public function readChecks($id) {
		$result = new resultsClass($id);
		return json_encode($this->model->readChecksDB($result), JSON_UNESCAPED_UNICODE);
	}

	public function updateTrl($id, $trl) {
		return $this->model->updateTrlDB($id, $trl);
	}

	public function updateChecks($id, $checks) {
	    $checkboxes = ['checkbox1-1', 'checkbox1-2', 'checkbox1-3', 'checkbox1-4', 'checkbox1-5', 'checkbox1-6', 'checkbox1-7', 'checkbox2-1', 'checkbox2-2', 'checkbox2-3', 'checkbox2-4', 'checkbox2-5', 'checkbox2-6', 'checkbox2-7', 'checkbox2-8', 'checkbox3-1', 'checkbox3-2', 'checkbox3-3', 'checkbox3-4', 'checkbox3-5', 'checkbox3-6', 'checkbox3-7', 'checkbox3-8', 'checkbox4-1', 'checkbox4-2', 'checkbox4-3', 'checkbox4-4', 'checkbox4-5', 'checkbox4-6', 'checkbox4-7', 'checkbox4-8', 'checkbox5-1', 'checkbox5-2', 'checkbox5-3', 'checkbox5-4', 'checkbox5-5', 'checkbox5-6', 'checkbox5-7', 'checkbox5-8', 'checkbox6-1', 'checkbox6-2', 'checkbox6-3', 'checkbox6-4', 'checkbox6-5', 'checkbox6-6', 'checkbox6-7', 'checkbox6-8', 'checkbox6-9', 'checkbox6_10', 'checkbox7-1', 'checkbox7-2', 'checkbox7-3', 'checkbox7-4', 'checkbox7-5', 'checkbox7-6', 'checkbox7-7', 'checkbox8-1', 'checkbox8-2', 'checkbox8-3', 'checkbox8-4', 'checkbox8-5', 'checkbox8-6', 'checkbox8-7', 'checkbox9-1', 'checkbox9-2', 'checkbox9-3', 'checkbox9-4', 'checkbox9-5', 'checkbox9-6', 'checkbox9-7'];
		$valid = true;
		foreach ($checks as $key => $select) {
			$check = new checksClass(NULL, $checkboxes[$key], $select == 'checked' ? 'checked' : 'unchecked', $id);
			$valid = $this->model->updateChecksDB($check);
		}
		return $checks;
	}

}