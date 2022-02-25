<?php

class connection {

	private $host = "localhost";
	private $db_name = "new_valtec";
	private $user = "root";
	private $pass = "";
	private $options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
	];

	private static $conexion = false;
	private $conn;
	
	private function __construct() {
		try {
			$this->conn = new PDO("mysql:host=" . ($this->host) . ";dbname=" . ($this->db_name) . ";" . "charset=utf8", $this->user, $this->pass, $this->options);
		} catch (PDOException $e) {
			$this->conn = false;
		}
	}

	public static function getInstance() {
		if(!self::$conexion) {
			self::$conexion = new connection();
		}
		return self::$conexion;
	}

	public function getPrepareStatement($sql) {
		return $this->conn->prepare($this->getQuery($sql));
	}

	public function getBindValue(bool $inverted, $ps, Object $object, array $function) {
    	$methods = get_class_methods($object);
		$count = 1;
    	
    	if (!$inverted) { // Para traer los que s equieren.
    		foreach ($function as $key => $value) {
    			$ps->bindValue($count++, $object->$value(), $this->setType($object->$value()));
    		}
    	}else { // Para ignorar los otros.
    		$index = null;

    		for ($i = 0; $i < count($function); $i++) { 
    			$index = array_search($function[$i], $methods);
    			unset($methods[$index]);
    		}

    		$methods = array_values($methods);

    		foreach ($methods as $key => $value) {
    			$ps->bindValue($count++, $object->$value());
    			//echo $count++ . " - " . $value . " ";
    		}
    	}

    	return $ps;
    }

	private function setType($var) {
		$type = gettype($var);
		switch ($type) {
			case 'integer':
				case 'boolean':
					return PDO::PARAM_INT;
					break;

			case 'string':
				return PDO::PARAM_STR;
				break;
			
			default:
				return PDO::PARAM_STR;
				break;
		}
	}

	public function getFetch($PreparedStatement, $option) {
		return $PreparedStatement->execute() ? (!$option ? $PreparedStatement->fetch() : $PreparedStatement->fetchAll()) : $PreparedStatement->errorInfo();
	}

	public function getExecute($PreparedStatement) {
		return $PreparedStatement->execute() ? true : $PreparedStatement->errorInfo();
	}

	private function getQuery($function) {
		$sql = [
			"UsersModel" => [
				"readLoginData" => "SELECT COUNT(users.document_user) AS `total`,  users.documentType_user AS `documentType`, users.document_user AS `document`, CAST(AES_DECRYPT(users.name_user, UNHEX('07FB945926849D2B1641E708C85E4390')) AS CHAR (255) CHARSET UTF8MB4) AS `name`, CAST(AES_DECRYPT(users.lastName_user, UNHEX('07FB945926849D2B1641E708C85E4390')) AS CHAR (255) CHARSET UTF8MB4) AS `lastName`, CAST(AES_DECRYPT(users.email_user, UNHEX('07FB945926849D2B1641E708C85E4390')) AS CHAR (255) CHARSET UTF8MB4) AS `email`, CAST(AES_DECRYPT(users.phone_user, UNHEX('07FB945926849D2B1641E708C85E4390')) AS CHAR (255) CHARSET UTF8MB4) AS `phone`, CAST(AES_DECRYPT(roles.name_rol, UNHEX('9153ACAB89D65A4B81AD2ABF151B099D')) AS CHAR (255) CHARSET UTF8MB4) AS `rol`, users.emailConfirm_user AS `emailConfirm`, users.id_regional AS `id_regional`, users.id_center AS `id_center` FROM (users INNER JOIN roles ON (roles.id_rol = users.id_rol)) WHERE users.emailConfirm_user = 'Confirmado' AND users.document_user = ?",
				"ReadUsers" => "SELECT `users`.`document_user` AS `document_user`, `users`.`nombres_users` AS `nombres_users`, `users`.`apellidos_users` AS `apellidos_users`, `users`.`celular_users` AS `celular_users`, `users`.`correo_usuario` AS `correo_usuario`, `users`.`id_rol` AS `id_rol` FROM `users`",
				"createUser" => "CALL createUser(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
				"getTemporalEmails" => "SELECT users.personal_sin AS personal_sin, users.token_usuario AS token_usuario FROM users WHERE users.personal_sin IS NOT NULL AND users.token_usuario = ?",
				"confimrUsers" => "CALL confirmUser(?, ?)",
				"readUserData" => "SELECT document_user, correo_usuario, nombres_users, apellidos_users, id_rol FROM users WHERE users.document_user = ? AND `users`.`correo_usuario` IS NOT NULL",
				"setTokenUsers" => "CALL setTokenUser(?, ?)",
				"readDataUserPassword" => "SELECT CAST(AES_DECRYPT(users.password_user, UNHEX('07FB945926849D2B1641E708C85E4390')) AS CHAR (255) CHARSET UTF8MB4) AS `password` FROM users WHERE users.document_user = ?",
				"updatePasswords" => "CALL setNewPassword(?, ?)",
				"readUsersExist" => "SELECT COUNT(users.document_user) AS total FROM users WHERE users.document_user = ?",
				"createTemporaryUsers" => "CALL createTemporaryUser(?, ?)",
				"updateDataUsers" => "CALL updateDataUser(?, ?, ?, ?, ?, ?)"
			],
			"LocationsModel" => [
				"readRegionals" => "SELECT  `regionales`.`id_regional` AS `id_regional`, `regionales`.`nombre_regional` AS `nombre_regional` FROM `regionales`",
				"readCenters" => "SELECT `centros`.`id_centro` AS `id_centro`, `centros`.`nombre_centro` AS `nombre_centro`, `centros`.`id_regional` AS `id_regional` FROM `centros` WHERE centros.id_regional = ?",
				"readRoles" => "SELECT `roles`.`id_rol` AS `id_rol`, `roles`.`nombre_rol` AS `nombre_rol` FROM `roles` WHERE roles.id_rol != 2 AND roles.id_rol != 0",
				"readKnowledeAreas" => "SELECT `redes_conocimiento`.`id_red` AS `id_red`, `redes_conocimiento`.`nombre_red` AS `nombre_red` FROM `redes_conocimiento`",
				"readInvestigationGroups" => "SELECT `grupos`.`id_grupo` AS `id_grupo`, `grupos`.`nombre_grupo` AS `nombre_grupo`, `grupos`.`id_centro` AS `id_centro` FROM (`grupos` JOIN `centros` ON (`grupos`.`id_centro` = `centros`.`id_centro`)) WHERE grupos.id_centro = ?"
			],
			"StatsModel" => [
				"readRegisterResults" => "SELECT COUNT(proyectos.id_proyecto) AS total FROM `proyectos`",
				"readResultsBigger" => "SELECT COUNT(proyectos.id_proyecto) AS total FROM `proyectos` WHERE proyectos.trl_proyecto = 'TRL 7' OR proyectos.trl_proyecto = 'TRL 8' OR proyectos.trl_proyecto = 'TRL 9'",
				"readTotalUsers" => "SELECT COUNT(document_user) AS total FROM users"
			],
			"ResultsModel" => [
				"createResearchResults" => "CALL createResearchResult(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
				"createRelationInvestigatorsProjects" => "CALL createRelationInvestigatorsProject(?, ?, ?, ?)",
				"readResultCode" => "SELECT COUNT(proyectos.sgps_proyecto) AS total FROM proyectos WHERE proyectos.sgps_proyecto = ?",
				"readMaxId" => "SELECT id_proyecto AS max FROM proyectos WHERE id_proyecto = (SELECT MAX(id_proyecto) FROM proyectos)",
				"readOnlyResult" => "SELECT * FROM proyectos LEFT JOIN regionales ON regionales.id_regional = proyectos.id_regional WHERE proyectos.id_proyecto = ? ORDER BY proyectos.id_proyecto DESC",
				"readInvestigatorsResults" => "SELECT `proyectos_users`.`id_relacion` AS `id_relacion`, `proyectos_users`.`document_user` AS `document_user`, `users`.`nombres_users` AS `nombres_users`, `users`.`apellidos_users` AS `apellidos_users`, `proyectos_users`.`id_temporal` AS `id_temporal`, `users_temporales`.`nombre_temporal` AS `nombre_temporal`, `proyectos_users`.`tipo_investigador` AS `tipo_investigador`, `proyectos_users`.`id_proyecto` AS `id_proyecto` FROM ((`proyectos_users` LEFT JOIN `users` ON (`proyectos_users`.`document_user` = `users`.`document_user`)) LEFT JOIN `users_temporales` ON (`proyectos_users`.`id_temporal` = `users_temporales`.`id_temporal`)) WHERE proyectos_users.id_proyecto = ?",
				"readReseachResults" => "SELECT * FROM (((((((`proyectos_users` JOIN `proyectos` ON (`proyectos_users`.`id_proyecto` = `proyectos`.`id_proyecto`)) JOIN `regionales` ON (`proyectos`.`id_regional` = `regionales`.`id_regional`)) JOIN `centros` ON (`proyectos`.`id_centro` = `centros`.`id_centro`)) JOIN `redes_conocimiento` ON (`proyectos`.`id_area` = `redes_conocimiento`.`id_red`)) JOIN `grupos` ON (`proyectos`.`id_grupo` = `grupos`.`id_grupo`)) LEFT JOIN `users` ON (`proyectos_users`.`document_user` = `users`.`document_user`)) LEFT JOIN `users_temporales` ON (`proyectos_users`.`id_temporal` = `users_temporales`.`id_temporal`))",
				"updateResearchResults" => "CALL updateResearchResult(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
				"deleteInvestigatorsResults" => "CALL deletedeleteInvestigatorResult(?)",
				"readOwn" => "SELECT * FROM proyectos_users INNER JOIN proyectos ON proyectos_users.id_proyecto = proyectos.id_proyecto INNER JOIN regionales ON proyectos.id_regional = regionales.id_regional INNER JOIN centros ON proyectos.id_centro = centros.id_centro WHERE document_user = ?",
				"readOthers" => "SELECT * FROM `proyectos_users` LEFT JOIN `proyectos` ON (`proyectos_users`.`id_proyecto` = `proyectos`.`id_proyecto`) LEFT JOIN `regionales` ON (`proyectos`.`id_regional` = `regionales`.`id_regional`) LEFT JOIN `centros` ON (`proyectos`.`id_centro` = `centros`.`id_centro`) LEFT JOIN `redes_conocimiento` ON (`proyectos`.`id_area` = `redes_conocimiento`.`id_red`) LEFT JOIN `grupos` ON (`proyectos`.`id_grupo` = `grupos`.`id_grupo`) LEFT JOIN `users` ON (`proyectos_users`.`document_user` = `users`.`document_user`) LEFT JOIN `users_temporales` ON (`proyectos_users`.`id_temporal` = `users_temporales`.`id_temporal`) WHERE proyectos_users.document_user <> ? OR proyectos_users.id_temporal <> ? GROUP BY proyectos.id_proyecto"
			],
			"SelectsModel" => [
				"setSelect" => "CALL setSelect(?, ?)"
			],
			"TrlModels" => [
				"readRIsData" => "SELECT proyectos.nombre_tecnologia, proyectos.ano_proyecto, proyectos.tipoCodigo_proyecto, proyectos.sgps_proyecto, proyectos.trl_proyecto FROM (((((((`proyectos_users` JOIN `proyectos` ON (`proyectos_users`.`id_proyecto` = `proyectos`.`id_proyecto`)) JOIN `regionales` ON (`proyectos`.`id_regional` = `regionales`.`id_regional`)) JOIN `centros` ON (`proyectos`.`id_centro` = `centros`.`id_centro`)) JOIN `redes_conocimiento` ON (`proyectos`.`id_area` = `redes_conocimiento`.`id_red`)) JOIN `grupos` ON (`proyectos`.`id_grupo` = `grupos`.`id_grupo`)) LEFT JOIN `users` ON (`proyectos_users`.`document_user` = `users`.`document_user`)) LEFT JOIN `users_temporales` ON (`proyectos_users`.`id_temporal` = `users_temporales`.`id_temporal`)) WHERE proyectos.id_proyecto = ?",
				"readChecksRIs" => "SELECT seleccionados.check_especifico, seleccionados.pregunta_seleccion, seleccionados.id_proyecto FROM seleccionados WHERE seleccionados.id_proyecto = ? GROUP BY seleccionados.check_especifico ORDER BY seleccionados.check_especifico ASC",
				"updateTrlResults" => "CALL updateTrlResult(?, ?)",
				"updateChecksResults" => "CALL updateChecksResult(?, ?, ?)"
			],
			"ValidationModel" => [
				"createValidationDatas" => "CALL createValidationData(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
				"readValidationRIs" => "SELECT `validacion`.`id_validacion` AS `id_validacion`, `validacion`.`pregunta0` AS `pregunta0`, `validacion`.`pregunta1` AS `pregunta1`, `validacion`.`pregunta2` AS `pregunta2`, `validacion`.`pregunta3` AS `pregunta3`, `validacion`.`pregunta4` AS `pregunta4`, `validacion`.`pregunta5` AS `pregunta5`, `validacion`.`pregunta6` AS `pregunta6`, `validacion`.`pregunta7` AS `pregunta7`, `validacion`.`pregunta8` AS `pregunta8`, `validacion`.`pregunta9` AS `pregunta9`, `validacion`.`pregunta10` AS `pregunta10`, `validacion`.`pregunta11` AS `pregunta11`, `validacion`.`pregunta12` AS `pregunta12`, `validacion`.`pregunta13` AS `pregunta13`, `validacion`.`pregunta14` AS `pregunta14`, `validacion`.`pregunta15` AS `pregunta15`, `validacion`.`pregunta16` AS `pregunta16`, `validacion`.`pregunta17` AS `pregunta17`, `validacion`.`pregunta18` AS `pregunta18`, `validacion`.`pregunta19` AS `pregunta19`, `validacion`.`pregunta20` AS `pregunta20`, `validacion`.`pregunta21` AS `pregunta21`, `validacion`.`pregunta22` AS `pregunta22`, `validacion`.`pregunta23` AS `pregunta23`, `validacion`.`pregunta24` AS `pregunta24`, `validacion`.`pregunta25` AS `pregunta25`, `validacion`.`pregunta26` AS `pregunta26`, `validacion`.`pregunta27` AS `pregunta27`, `validacion`.`pregunta28` AS `pregunta28`, `validacion`.`pregunta29` AS `pregunta29`, `validacion`.`pregunta30` AS `pregunta30`, `validacion`.`id_proyecto` AS `id_proyecto`, proyectos.nombre_tecnologia FROM `validacion` INNER JOIN proyectos ON validacion.id_proyecto = proyectos.id_proyecto WHERE validacion.id_proyecto = ?",
				"updateValidationDatas" => "CALL updateValidationData(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
			]

		];
		return $sql[$function[0]][$function[1]];
	}

}