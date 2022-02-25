<?php

/**
 * Clase que encapsulará la relación de los investigadores con los proyectos.
 */
class usersProjectsClasss {
	
	private $id;
	private $document;
	private $project;
	private $temporal;
	private $role;

	public function __construct($id = NULL, $document = NULL, $project = NULL, $temporal = NULL, $role = NULL) {
		$this->id = $id;
		$this->document = $document;
		$this->project = $project;
		$this->temporal = $temporal;
		$this->role = $role;
	}

    public function getId() {
        return $this->id;
    }

    public function getDocument() {
        return $this->document;
    }

    public function getProject() {
        return $this->project;
    }

    public function getTemporal() {
        return $this->temporal;
    }

    public function getRole() {
        return $this->role;
    }
    
}