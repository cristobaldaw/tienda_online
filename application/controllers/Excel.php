<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/third_party/phpexcel/Classes/PHPExcel.php';
require APPPATH.'/third_party/phpexcel/Classes/PHPExcel/IOFactory.php';

class Excel extends CI_Controller {

	/**
	 * Carga la plantilla de importación excel
	 */
	public function index()
	{
		$this->load->plantilla('productos/importar_excel');
	}

	/**
	 * Proceso de importación de productos desde un fichero Excel a la base de datos
	 */
	public function importacion_prods()
	{
		$archivo = $_FILES['excel']['tmp_name'];
		move_uploaded_file($archivo, APPPATH . 'upload\ ' . $_FILES['excel']['name']);
		$nombre_archivo = APPPATH . 'upload\ ' . $_FILES['excel']['name'];
		$objPHPExcel = PHPExcel_IOFactory::load($nombre_archivo);
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$worksheetTitle     = $worksheet->getTitle();
			$highestRow         = $worksheet->getHighestRow();
			$highestColumn      = $worksheet->getHighestColumn();
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			$nrColumns = ord($highestColumn) - 64;
			for ($row = 2; $row <= $highestRow; ++ $row) {
				$datos_prod = array(
					"cod" => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
					"nombre" => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
					"precio" => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
					"descuento" => $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
					"imagen" => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
					"iva" => $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
					"descripcion" => $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
					"id_categoria" => $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
					"stock" => $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
					"oculto" => $worksheet->getCellByColumnAndRow(9, $row)->getValue(),
					"destacado" => $worksheet->getCellByColumnAndRow(10, $row)->getValue()
					);
				$this->Model_productos->insertar_producto($datos_prod);
			}
		}
	}

	/**
	 * Proceso de importación de productos desde un fichero Excel a la base de datos
	 */
	public function importacion_cats()
	{
		$archivo = $_FILES['excel']['tmp_name'];
		move_uploaded_file($archivo, APPPATH . 'upload\ ' . $_FILES['excel']['name']);
		$nombre_archivo = APPPATH . 'upload\ ' . $_FILES['excel']['name'];
		$objPHPExcel = PHPExcel_IOFactory::load($nombre_archivo);
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$worksheetTitle     = $worksheet->getTitle();
			$highestRow         = $worksheet->getHighestRow();
			$highestColumn      = $worksheet->getHighestColumn();
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			$nrColumns = ord($highestColumn) - 64;
			for ($row = 2; $row <= $highestRow; ++ $row) {
				$datos_prod = array(
					"cod" => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
					"nombre" => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
					"descripcion" => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
					"oculto" => $worksheet->getCellByColumnAndRow(3, $row)->getValue()
					);
				$this->Model_productos->insertar_categoria($datos_prod);
			}
		}
	}

}