<?php

/**
 * Clase que encapsula los datos de los usuarios.
 */
class usersClass {
	
	private $documentType;
	private $document;
	private $name;
	private $lastName;
	private $phone;
	private $email;
	private $password;
	private $token;
	private $emailConfirm;
	private $rol;
	private $regional;
	private $center;
	private $city;

	public function __construct($documentType = 'C.C.', $document = NULL, $name = NULL, $lastName = NULL, $phone = NULL, $email = NULL, $password = NULL, $token = NULL, $emailConfirm = NULL, $rol = NULL, $regional = NULL, $center = NULL, $city = NULL) {
		$this->documentType = $documentType;
		$this->document = $document;
		$this->name = $name;
		$this->lastName = $lastName;
		$this->phone = $phone;
		$this->email = $email;
		$this->password = $password;
		$this->token = $token;
		$this->emailConfirm = $emailConfirm;
		$this->rol = $rol;
		$this->regional = $regional;
		$this->center = $center;
		$this->city = $city;
	}

    public function getDocumentType() {
        return $this->documentType;
    }
    
    public function getDocument() {
        return $this->document;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getLastName() {
        return $this->lastName;
    }
    
    public function getPhone() {
        return $this->phone;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getToken() {
        return $this->token;
    }
    
    public function getEmailConfirm() {
        return $this->emailConfirm;
    }
    
    public function getRol() {
        return $this->rol;
    }
    
    public function getRegional() {
        return $this->regional;
    }
    
    public function getCenter() {
        return $this->center;
    }
    
    public function getCity() {
        return $this->city;
    }

}