<?php

require_once 'security.php';

/**
 * Esta clase hará todas las validaciones necesarias para el proyecto, incluyendo la encriptación de contraseñas y el token.
 */
class extraController extends security {

	public function validateNumbers($number) {
		return is_numeric($number);
	}

	public function isEmpty($data, array $ignore = NULL) {
		$val = true;

		if ($ignore != NULL) {
			for ($i = 0; $i < count($ignore); $i++) { 
	    		$index = array_diff($ignore, $data);
	    		unset($data[$index[$i]]);
	    	}

    		$data = array_values($data);
		}

		$xd = '';

		foreach ($data as $key => $value) {
			if (!isset($data[$key]) || empty($data[$key])) {
				$val = false;
				break;
			}
		}

		return $val;
	}

	public function validateEmail($email) {
		return preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $email) ? true : false;
	}

	public function validateString($string) {
		return is_string($string);
	}

	public function encryptPassword($string) {
		$password = md5($string);
		$pass = md5($password);
		return crypt($pass, $password);
	}

	public function encryptToken($string) {
		$first = md5($string);
		$password = crypt($string, $first);

		$token = password_hash($password, PASSWORD_BCRYPT);

		$corregido = str_replace('/', '', $token);
		$corregido = str_replace('&', '', $corregido);
		$corregido = str_replace('$', '', $corregido);

		return md5($corregido);
	}

	public function validateLength($string, $min = 1, $max = 1000)	{
		return strlen($string) >= $min && strlen($string) <= $max ? true : false;
	}

	protected function jsonString(array $array) : string {
		return json_encode($array, JSON_UNESCAPED_UNICODE);
	}

}