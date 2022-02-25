<?php
date_default_timezone_set('America/Bogota');
ini_set('memory_limit', '128M');

require '../model/reportsModel.php';

require '../controllers/capsules/resultsClass.php';

require_once '../resources/libraries/PHPSpreadSheet/vendor/autoload.php';

use PhpSpreadsheet\src\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ini_set('date.timezone', 'America/Bogota');

/**
 * Clase que controla todo lo realcionado con los reportes.
 */
class reportsController {

	private $filesRoute;
	private $spreadsheet;
	private $page1;
	private $page2;
	private $page3;
	private $trl;

	private $documentsName = NULL;

	private $model;
	
	public function __construct($route) {
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
		$this->filesRoute = $route;
		$this->spreadsheet = $reader->load($this->filesRoute);
		$this->page1 = $this->spreadsheet->getSheet(0);
		$this->model = new reportsModel();
	}

	public function setGeneralReport($results) {

		$this->documentsName = 'REPORTE RESULTADOS - ' . date('d-m-Y');
		$this->page2 = $this->spreadsheet->getSheet(1);
		$this->firstPageGeneral($results);
		$this->secondPageGeneral($results);
		$this->saveDocument('../resources/documents/generated/general/');

		return $this->downloadReport('resources/documents/generated/general/');
	}

	public function setSpecificReport($id) {
		$readResult = new resultsClass($id);
		$result = $this->model->readResultOnlyDB($readResult);

		$this->documentsName = 'REPORTE ' . $result['tipoCodigo_proyecto'] . ' - ' . $result['sgps_proyecto'] . ' - ' . date('d-m-Y');

		$this->page1->setCellValue('B2', $result['nombre_tecnologia'] . " - (" . $result['trl_proyecto'] . ")");
		$this->page1->setCellValue('E3', $this->validData($result['tipoCodigo_proyecto']));
		$this->page1->setCellValue('E4', $this->validData($result['sgps_proyecto']));
		$this->page1->setCellValue('E5', $result['ano_proyecto']);
		$this->page1->setCellValue('E6', $this->validData($result['fecha_inicio']));
		$this->page1->setCellValue('E7', $this->validData($result['ultima_modificacion']));
		$this->page1->setCellValue('E8', $this->setInvestigators($result['id_proyecto']));
		$this->page1->setCellValue('E9', $this->validData($result['tipo_resultado']));
		$this->page1->setCellValue('E10', $this->validData($result['grupo_resultado']));
		$this->page1->setCellValue('E11', $this->validData($result['especifico_resultado']));
		$this->page1->setCellValue('E12', $this->validData($result['subarea_proyecto']));
		$this->page1->setCellValue('E13', $this->validData($result['nombre_regional']));
		//$this->page1->setCellValue('E14', $result['nombre_centro']);
		$this->trl = $result['trl_proyecto'];
		$this->page1->setCellValue('E15', $this->setInvestigators($result['id_proyecto']));
		$this->readChecks($result['id_proyecto']);
		$this->setValorationData($result['id_proyecto']);

		$this->saveDocument('../resources/documents/generated/specifics/');
		return $this->downloadReport('resources/documents/generated/specifics/');
	}

	private function firstPageGeneral($results) {
		$resultsCount = 1;
		$rowsCount = 3;

		foreach ($results as $key => $resultados) {
			$this->page1->setCellValue('B' . $rowsCount, $resultsCount);
			$this->page1->setCellValue('C' . $rowsCount, $this->setUppercase($resultados['nombre_proyecto']));
			$this->page1->setCellValue('D' . $rowsCount, $this->setUppercase($resultados['nombre_tecnologia']));
			$this->page1->setCellValue('E' . $rowsCount, $this->validData($resultados['resumen_proyecto']));
			$this->page1->setCellValue('F' . $rowsCount, $this->validData($resultados['tipoCodigo_proyecto']));
			$this->page1->setCellValue('G' . $rowsCount, $resultados['sgps_proyecto']);
			$this->page1->setCellValue('H' . $rowsCount, $resultados['ano_proyecto']);
			$this->page1->setCellValue('I' . $rowsCount, $this->validData($resultados['tipo_resultado']));
			$this->page1->setCellValue('J' . $rowsCount, $this->validData($resultados['grupo_resultado']));
			$this->page1->setCellValue('K' . $rowsCount, $this->validData($resultados['especifico_resultado']));
			$this->page1->setCellValue('L' . $rowsCount, $this->validData($resultados['nombre_red']));
			$this->page1->setCellValue('M' . $rowsCount, $this->setDate($resultados['fecha_inicio']));
			$this->page1->setCellValue('N' . $rowsCount, $this->setDate($resultados['ultima_modificacion']));
			$this->page1->setCellValue('O' . $rowsCount, $resultados['trl_proyecto']);
			$this->page1->setCellValue('P' . $rowsCount, $this->setRights($resultados['cede_derechos']));
			$this->page1->setCellValue('Q' . $rowsCount, $resultados['nombre_regional']);

			$this->page1->setCellValue('R' . $rowsCount, $resultados['nombre_centro']);

			$this->page1->setCellValue('S' . $rowsCount, $this->validData($resultados['nombre_grupo']));
			$this->page1->setCellValue('T' . $rowsCount, $this->setInvestigators($resultados['id_proyecto']));
			$resultsCount++;
			$rowsCount++;
		}
	}

	private function secondPageGeneral($results) {
		$column = array('N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'Z', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AL', 'AN', 'AP', 'AQ', 'AR', 'AT', 'AV', 'AY', 'BA', 'BA', 'K', 'L');
		$rowsCount = 5;
		
		foreach ($results as $key => $resultados) {
			$this->page2->setCellValue('B' . $rowsCount, $resultados['nombre_regional']);

			$this->page2->setCellValue('C' . $rowsCount, $resultados['nombre_centro']);

			$this->page2->setCellValue('D' . $rowsCount, $this->setInvestigators($resultados['nombre_red']));
			$this->page2->setCellValue('E' . $rowsCount, $this->setInvestigators($resultados['id_proyecto']));
			$this->page2->setCellValue('F' . $rowsCount, $this->setUppercase($resultados['nombre_proyecto']));
			$this->page2->setCellValue('G' . $rowsCount, $this->setUppercase($resultados['nombre_tecnologia']));
			$this->page2->setCellValue('H' . $rowsCount, $this->validData($resultados['tipoCodigo_proyecto']));
			$this->page2->setCellValue('I' . $rowsCount, $this->validData($resultados['sgps_proyecto']));
			$this->page2->setCellValue('J' . $rowsCount, $this->validData($resultados['ano_proyecto']));
			$this->page2->setCellValue('K' . $rowsCount, $this->validData($resultados['trl_proyecto']));

			$result = new resultsClass($resultados['id_proyecto']);
			$valoration = $this->model->readValidationDataDB($result);

			$this->page2->setCellValue($column[0] . $rowsCount, $this->validData($valoration['pregunta0']));
			$this->page2->setCellValue($column[1] . $rowsCount, $this->validData($valoration['pregunta1']));
			$this->page2->setCellValue($column[2] . $rowsCount, $this->validData($valoration['pregunta2']));
			$this->page2->setCellValue($column[3] . $rowsCount, $this->validData($valoration['pregunta3']));
			$this->page2->setCellValue($column[4] . $rowsCount, $this->validData($valoration['pregunta4']));
			$this->page2->setCellValue($column[5] . $rowsCount, $this->validData($valoration['pregunta5']));
			$this->page2->setCellValue($column[6] . $rowsCount, $this->validData($valoration['pregunta6']));
			$this->page2->setCellValue($column[7] . $rowsCount, $this->validData($valoration['pregunta7']));
			$this->page2->setCellValue($column[8] . $rowsCount, $this->validData($valoration['pregunta8']));
			$this->page2->setCellValue($column[9] . $rowsCount, $this->validData($valoration['pregunta9']));
			$this->page2->setCellValue($column[10] . $rowsCount, $this->validData($valoration['pregunta10']));
			$this->page2->setCellValue($column[11] . $rowsCount, $this->validData($valoration['pregunta11']));
			$this->page2->setCellValue($column[12] . $rowsCount, $this->validData($valoration['pregunta12']));
			$this->page2->setCellValue($column[13] . $rowsCount, $this->validData($valoration['pregunta13']));
			$this->page2->setCellValue($column[14] . $rowsCount, $this->validData($valoration['pregunta14']));
			$this->page2->setCellValue($column[15] . $rowsCount, $this->validData($valoration['pregunta15']));
			$this->page2->setCellValue($column[16] . $rowsCount, $this->validData($valoration['pregunta16']));
			$this->page2->setCellValue($column[17] . $rowsCount, $this->validData($valoration['pregunta17']));
			$this->page2->setCellValue($column[18] . $rowsCount, $this->validData($valoration['pregunta18']));
			$this->page2->setCellValue($column[19] . $rowsCount, $this->validData($valoration['pregunta19']));
			$this->page2->setCellValue($column[20] . $rowsCount, $this->validData($valoration['pregunta20']));
			$this->page2->setCellValue($column[21] . $rowsCount, $this->validData($valoration['pregunta21']));
			$this->page2->setCellValue($column[22] . $rowsCount, $this->validData($valoration['pregunta22']));
			$this->page2->setCellValue($column[23] . $rowsCount, $this->validData($valoration['pregunta23']));
			$this->page2->setCellValue($column[24] . $rowsCount, $this->validData($valoration['pregunta24']));
			$this->page2->setCellValue($column[25] . $rowsCount, $this->validData($valoration['pregunta25']));
			$this->page2->setCellValue($column[26] . $rowsCount, $this->validData($valoration['pregunta26']));
			$this->page2->setCellValue($column[27] . $rowsCount, $this->validData($valoration['pregunta27']));
			$this->page2->setCellValue($column[28] . $rowsCount, $this->validData($valoration['pregunta28']));
			$this->page2->setCellValue($column[29] . $rowsCount, $this->validData($valoration['pregunta29']));
			$this->page2->setCellValue($column[30] . $rowsCount, $this->validData($valoration['pregunta30']));
			$rowsCount++;
		}
	}

	private function readChecks($id) {
		$readResult = new resultsClass($id);
		$result = $this->model->readChecksDB($readResult);

		$this->page2 = $this->spreadsheet->getSheet(1);
		$this->page2->setCellValue('B2', $this->trl);

		$row = 6;

		foreach ($result as $key => $check) {
			if ($check['pregunta_seleccion'] == 'checked') {
				$this->page2->setCellValue('H' . $row, 'Sí');
				$this->page2->getStyle('H' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FF00');
			}else {
				$this->page2->setCellValue('H' . $row, 'No');
				$this->page2->getStyle('H' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');
			}
			$row++;
		}
	}

	private function setValorationData($id) {
		$result = new resultsClass($id);
		$valoration = $this->model->readValidationDataDB($result);

		$this->page3 = $this->spreadsheet->getSheet(2);
		$this->page3->setCellValue('C6', $this->validData($valoration['nombre_tecnologia']));
		$this->page3->setCellValue('C8', $this->validData($this->trl));
		$this->page3->setCellValue('C10', $this->validData($valoration['pregunta0']));
		$this->page3->setCellValue('C12', $this->validData($valoration['pregunta1']));
		$this->page3->setCellValue('C14', $this->validData($valoration['pregunta2']));
		$this->page3->setCellValue('C16', $this->validData($valoration['pregunta3']));
		$this->page3->setCellValue('C18', $this->validData($valoration['pregunta4']));
		$this->page3->setCellValue('C20', $this->validData($valoration['pregunta5']));
		$this->page3->setCellValue('C22', $this->validData($valoration['pregunta6']));
		$this->page3->setCellValue('C24', $this->validData($valoration['pregunta7']));
		$this->page3->setCellValue('C26', $this->validData($valoration['pregunta8']));
		$this->page3->setCellValue('C28', $this->validData($valoration['pregunta9']));
		$this->page3->setCellValue('C30', $this->validData($valoration['pregunta10']));
		$this->page3->setCellValue('C32', $this->validData($valoration['pregunta11']));
		$this->page3->setCellValue('C34', $this->validData($valoration['pregunta12']));
		$this->page3->setCellValue('C36', $this->validData($valoration['pregunta13']));
		$this->page3->setCellValue('C38', $this->validData($valoration['pregunta14']));
		$this->page3->setCellValue('C40', $this->validData($valoration['pregunta15']));
		$this->page3->setCellValue('C42', $this->validData($valoration['pregunta16']));
		$this->page3->setCellValue('C44', $this->validData($valoration['pregunta17']));
		$this->page3->setCellValue('C46', $this->validData($valoration['pregunta18']));
		$this->page3->setCellValue('C48', $this->validData($valoration['pregunta19']));
		$this->page3->setCellValue('C50', $this->validData($valoration['pregunta20']));
		$this->page3->setCellValue('C52', $this->validData($valoration['pregunta21']));
		$this->page3->setCellValue('C54', $this->validData($valoration['pregunta22']));
		$this->page3->setCellValue('C56', $this->validData($valoration['pregunta23']));
		$this->page3->setCellValue('C58', $this->validData($valoration['pregunta24']));
		$this->page3->setCellValue('C60', $this->validData($valoration['pregunta25']));
		$this->page3->setCellValue('C62', $this->validData($valoration['pregunta26']));
		$this->page3->setCellValue('C64', $this->validData($valoration['pregunta27']));
		$this->page3->setCellValue('C66', $this->validData($valoration['pregunta28']));
	}

	private function setInvestigators($id){
		$resultados = new resultsClass($id);
		$investigators = $this->model->readInvestigatorsResultDB($resultados);

		$investigatorsGroup = "";

		foreach ($investigators as $key => $value) {
			$investigatorsGroup.= $value['documento_usuario'] != NULL ? $value['nombres_usuarios'] . " " . $value['apellidos_usuarios'] . " (" . $value['tipo_investigador'] . "), " :  $value['nombre_temporal'] . " (" . $value['tipo_investigador'] . "), ";
		}
		$investigatorsGroup = substr($investigatorsGroup, 0, -2);
		return $investigatorsGroup . ".";
	}

	private function saveDocument($route){
		if (!is_dir($route)) {
			mkdir($route, 0777, true);
		}
		$writer = new Xlsx($this->spreadsheet);
		return $writer->save($route . $this->documentsName . ".xlsx");
	}

	private function downloadReport($route){
		header("Content-disposition: attachment; filename=" . $this->documentsName . ".xlsx");
		header("Content-type: xls");
		return $route . $this->documentsName . ".xlsx";
	}

	private function setRights($right){
		return $right == "No" || $right == NULL ? "Rechazado" : "Aprobado";
	}

	private function setDate($fecha){
		if ($fecha != NULL && $fecha != '0000-00-00') {
			$ordenar = explode("-", $fecha);
			$ordenado = $ordenar[2] . "/" . $ordenar[1] . "/" . $ordenar[0];
			return $ordenado; 
		}else{
			return "Sin cambios registrados.";
		}
	}

	private function validData($dato){
		return $dato != "" && $dato != NULL ? $dato : "Sin actualizar.";
	}

	private function setUppercase($palabra){
		$palabra = str_replace("&aacute;", "Á", $palabra);
		$palabra = str_replace("&eacute;", "É", $palabra);
		$palabra = str_replace("&iacute;", "Í", $palabra);
		$palabra = str_replace("&oacute;", "Ó", $palabra);
		$palabra = str_replace("&uacute;", "Ú", $palabra);
		$palabra = str_replace("&ntilde;", "Ñ", $palabra);

		$palabra = str_replace("á", "Á", $palabra);
		$palabra = str_replace("é", "É", $palabra);
		$palabra = str_replace("í", "Í", $palabra);
		$palabra = str_replace("ó", "Ó", $palabra);
		$palabra = str_replace("ú", "Ú", $palabra);
		$palabra = str_replace("ñ", "Ñ", $palabra);

		$mayuscula = strtoupper($palabra);
		return $mayuscula;
	}

	private function setCapitalize($dato){
		$dato = str_replace("á", "á", $dato);
		$dato = str_replace("é", "é", $dato);
		$dato = str_replace("í", "í", $dato);
		$dato = str_replace("ó", "ó", $dato);
		$dato = str_replace("ú", "ú", $dato);
		$dato = str_replace("ñ", "ñ", $dato);

		$dato = str_replace("Ã¡", "á", $dato);
		$dato = str_replace("Ã©", "é", $dato);
		$dato = str_replace("Ã", "í", $dato);
		$dato = str_replace("Ã³", "ó", $dato);
		$dato = str_replace("Ãº", "ú", $dato);
		$dato = str_replace("Ã±", "ñ", $dato);

		$dato = str_replace("Ã", "á", $dato);
		$dato = str_replace("Ã‰", "é", $dato);
		$dato = str_replace("Ã", "í", $dato);
		$dato = str_replace("Ã“", "ó", $dato);
		$dato = str_replace("Ãš", "ú", $dato);
		$dato = str_replace("Ã‘", "ñ", $dato);

		$dato = str_replace("&aacute;", "á", $dato);
		$dato = str_replace("&eacute;", "é", $dato);
		$dato = str_replace("&iacute;", "í", $dato);
		$dato = str_replace("&oacute;", "ó", $dato);
		$dato = str_replace("&uacute;", "ú", $dato);
		$dato = str_replace("&ntilde;", "ñ", $dato);

		$capitalizado = ucwords($dato);
		return $capitalizado;
	}

}