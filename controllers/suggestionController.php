<?php

// Se traen las funciones.
require '../controllers/functions/emailController.php';

/**
 * Clase que registra y lee las sugerencias.
 */
class suggestionController {
	
	private $model;

	public function __construct() {
		//$this->model = new suggestionModel();
	}

	public function createSuggestion($message) {
		$email = new emailController('ValTec', 'contacto@valtec.systems', 'SUGERENCIA DE MEJORA PARA VALTEC', $message);
		return $email->sendSuggestionEmail();
	}

}