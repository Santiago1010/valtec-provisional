<?php

// Se traen las cápsulas.
require '../controllers/capsules/validationCapsule.php';

// Se trae el modelo.
require '../model/validationModel.php';

/**
 * Clase que cotrola y gestiona los datos de los usuarios.
 */
class valorationController {
	
	private $model;

	public function __construct() {
		$this->model = new validationModel();
	}

	private function createValidation($data, $project) {
		$validation = new validationCapsule(NULL, $data[0] != "" ? $data[0] : NULL, $data[1] != "" ? $data[1] : NULL, $data[2] != "" ? $data[2] : NULL, $data[3] != "" ? $data[3] : NULL, $data[4] != "" ? $data[4] : NULL, $data[5] != "" ? $data[5] : NULL, $data[6] != "" ? $data[6] : NULL, $data[7] != "" ? $data[7] : NULL, $data[8] != "" ? $data[8] : NULL, $data[9] != "" ? $data[9] : NULL, $data[10] != "" ? $data[10] : NULL, $data[11] != "" ? $data[11] : NULL, $data[12] != "" ? $data[12] : NULL, $data[13] != "" ? $data[13] : NULL, $data[14] != "" ? $data[14] : NULL, $data[15] != "" ? $data[15] : NULL, $data[16] != "" ? $data[16] : NULL, $data[17] != "" ? $data[17] : NULL, $data[18] != "" ? $data[18] : NULL, $data[19] != "" ? $data[19] : NULL, $data[20] != "" ? $data[20] : NULL, $data[21] != "" ? $data[21] : NULL, $data[22] != "" ? $data[22] : NULL, $data[23] != "" ? $data[23] : NULL, $data[24] != "" ? $data[24] : NULL, $data[25] != "" ? $data[25] : NULL, $data[26] != "" ? $data[26] : NULL, $data[27] != "" ? $data[27] : NULL, $data[28] != "" ? $data[28] : NULL, $data[29] != "" ? $data[29] : NULL, $data[30] != "" ? $data[30] : NULL, $project);
		return $this->model->createValidationDB($validation);
	}

	public function readValidationRi($project) {
		$validation = new validationCapsule(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $project);
		return $this->model->readValidationRiDB($validation);
	}

	public function setActionValidation($project, $data) {
		$exist = $this->readValidationRi($project);
		return $exist != "" ? $this->updateValidation($data, $project) : $this->createValidation($data, $project);
	}

	private function updateValidation($data, $project) {
		$validation = new validationCapsule(NULL, $data[0] != "" ? $data[0] : NULL, $data[1] != "" ? $data[1] : NULL, $data[2] != "" ? $data[2] : NULL, $data[3] != "" ? $data[3] : NULL, $data[4] != "" ? $data[4] : NULL, $data[5] != "" ? $data[5] : NULL, $data[6] != "" ? $data[6] : NULL, $data[7] != "" ? $data[7] : NULL, $data[8] != "" ? $data[8] : NULL, $data[9] != "" ? $data[9] : NULL, $data[10] != "" ? $data[10] : NULL, $data[11] != "" ? $data[11] : NULL, $data[12] != "" ? $data[12] : NULL, $data[13] != "" ? $data[13] : NULL, $data[14] != "" ? $data[14] : NULL, $data[15] != "" ? $data[15] : NULL, $data[16] != "" ? $data[16] : NULL, $data[17] != "" ? $data[17] : NULL, $data[18] != "" ? $data[18] : NULL, $data[19] != "" ? $data[19] : NULL, $data[20] != "" ? $data[20] : NULL, $data[21] != "" ? $data[21] : NULL, $data[22] != "" ? $data[22] : NULL, $data[23] != "" ? $data[23] : NULL, $data[24] != "" ? $data[24] : NULL, $data[25] != "" ? $data[25] : NULL, $data[26] != "" ? $data[26] : NULL, $data[27] != "" ? $data[27] : NULL, $data[28] != "" ? $data[28] : NULL, $data[29] != "" ? $data[29] : NULL, $data[30] != "" ? $data[30] : NULL, $project);
		return $this->model->updateValidationDB($validation);
	}

}