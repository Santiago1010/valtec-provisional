<?php

/**
 * Clase que encapsulará la relación de los investigadores con los proyectos.
 */
class temporaryUserClass {
	
	private $id;
	private $document;
	private $name;

	public function __construct($id = NULL, $document = NULL, $name = NULL) {
		$this->id = $id;
		$this->document = $document;
		$this->name = $name;
	}

    public function getId() {
        return $this->id;
    }

    public function getDocument() {
        return $this->document;
    }

    public function getName() {
        return $this->name;
    }

}