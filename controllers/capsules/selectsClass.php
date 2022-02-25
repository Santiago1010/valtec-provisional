<?php

/**
 * Clase que encapsula los datos de la tabla 'seleccionados'.
 */
class selectsClass {

	private $id;
	private $check;
	private $state;
	private $project;

	public function __construct($id = NULL, $check = NULL, $state = 'unchecked', $project = NULL) {
		$this->id = $id;
		$this->check = $check;
		$this->state = $state;
		$this->project = $project;
	}

    public function getId() {
    	return $this->id;
    }

    public function getCheck() {
    	return $this->check;
    }

    public function getState() {
    	return $this->state;
    }

    public function getProject() {
    	return $this->project;
    }

}