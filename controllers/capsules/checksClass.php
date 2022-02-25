<?php

/**
 * Clase que encapsula los seleccionados.
 */
class checksClass {

	private $id;
	private $check;
	private $state;
	private $project;

	public function __construct($id, $check, $state, $project) {
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