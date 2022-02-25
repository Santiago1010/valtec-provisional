<?php

/**
 * Clase que encapsula los datos de los resultados de investigación.
 */
class resultsClass {

    private $id;
    private $nameProject;
    private $nameTech;
    private $year;
    private $typeCode;
    private $sgps;
    private $review;
    private $typeResult;
    private $gorupResult;
    private $especificResult;
    private $subArea;
    private $idArea;
    private $rights;
    private $start;
    private $regional;
    private $center;
    private $group;

    public function __construct($id = NULL, $nameProject = NULL, $nameTech = NULL, $year = NULL, $typeCode = NULL, $sgps = NULL, $review = NULL, $typeResult = NULL, $gorupResult = NULL, $especificResult = NULL, $subArea = NULL, $idArea = NULL, $rights = NULL, $start = NULL, $regional = NULL, $center = NULL, $group = NULL) {
        $this->id = $id;
        $this->nameProject = $nameProject;
        $this->nameTech = $nameTech;
        $this->year = $year;
        $this->typeCode = $typeCode;
        $this->sgps = $sgps;
        $this->review = $review;
        $this->typeResult = $typeResult;
        $this->gorupResult = $gorupResult;
        $this->especificResult = $especificResult;
        $this->subArea = $subArea;
        $this->idArea = $idArea;
        $this->rights = $rights;
        $this->start = $start;
        $this->regional = $regional;
        $this->center = $center;
        $this->group = $group;
    }

    public function getId() {
        return $this->id;
    }

    public function getNameProject() {
        return $this->nameProject;
    }

    public function getNameTech() {
        return $this->nameTech;
    }

    public function getYear() {
        return $this->year;
    }

    public function getTypeCode() {
        return $this->typeCode;
    }

    public function getSgps() {
        return $this->sgps;
    }

    public function getReview() {
        return $this->review;
    }

    public function getTypeResult() {
        return $this->typeResult;
    }

    public function getGorupResult() {
        return $this->gorupResult;
    }

    public function getEspecificResult() {
        return $this->especificResult;
    }

    public function getSubArea() {
        return $this->subArea;
    }

    public function getIdArea() {
        return $this->idArea;
    }

    public function getRights() {
        return $this->rights;
    }

    public function getStart() {
        return $this->start;
    }

    public function getRegional() {
        return $this->regional;
    }

    public function getCenter() {
        return $this->center;
    }

    public function getGroup() {
        return $this->group;
    }
    
}