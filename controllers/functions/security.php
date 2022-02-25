<?php

/**
 * Clase que controla la seguridad de ValTec.
 */
class security {
	
	protected function encryptData(int|string $string) : string {
		return $this->encryptRSA($string);
	}

	protected function decryptData(int|string $data) : string {
		return $this->decryptRSA($data);
	}

	protected function encryptRSA(int|string $string) : string {
		$iv = base64_decode('C9fBxl1EWtYTL1/M8jfstw==');
		$encrypted = openssl_encrypt($string, 'aes-256-cbc', 'db89bb5ceab87f9c0fcc2ab36c189c2c', 0, $iv);
		return base64_encode($encrypted . '::' . $iv);
	}

	protected function encryptHash(int|string $string) : string {
		return password_hash($string, PASSWORD_DEFAULT, ['cost' => 8]);
	}

	protected function decryptRSA(int|string $data) : string {
		list($data_encrypted, $iv) = explode('::', base64_decode($data), 2);
		return openssl_decrypt($data_encrypted, 'aes-256-cbc', 'db89bb5ceab87f9c0fcc2ab36c189c2c', 0, $iv);
	}

	protected function validHash(string $string, string $hash) : bool {
		return password_verify($string, $hash);
	}
	
}