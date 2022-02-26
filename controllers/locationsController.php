<?php

require '../model/locationsModel.php';

/**
 * Clase que controla los datos de las regionales y centros de fórmación.
 */
class locationsController {

	private $model;
	
	public function __construct() {
		$this->model = new locationsModel();
	}

	public function readRegionals() {
		return $this->model->readRegionalsDB();
	}

	public function readCenters($idRegional) {
		return $this->model->readCentersDB($idRegional);
	}

	public function readInvestigationGroups($idCenter) {
		return json_encode($this->model->readInvestigationGroupsDB($idCenter), JSON_UNESCAPED_UNICODE);
	}

}