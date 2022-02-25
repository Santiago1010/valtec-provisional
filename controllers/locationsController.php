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
		return json_encode($this->model->readRegionalsDB(), JSON_UNESCAPED_UNICODE);
	}

	public function readCenters($idRegional) {
		return json_encode($this->model->readCentersDB($idRegional), JSON_UNESCAPED_UNICODE);
	}

	public function readRoles() {
		return json_encode($this->model->readRolesDB(), JSON_UNESCAPED_UNICODE);
	}

	public function readKnowledgeNetworks() {
		return json_encode($this->model->readKnowledgeNetworksDB(), JSON_UNESCAPED_UNICODE);
	}

	public function readInvestigationGroups($idCenter) {
		return json_encode($this->model->readInvestigationGroupsDB($idCenter), JSON_UNESCAPED_UNICODE);
	}

}