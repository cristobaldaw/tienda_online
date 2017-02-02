<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/third_party/fpdf/fpdf.php';

class PDF extends FPDF
{


	function Header()
	{
		$this->Image(APPPATH.'/third_party/fpdf/logo.png',10,8,33);
    // Arial bold 15
		$this->SetFont('Arial','B',15);
    // Movernos a la derecha
		$this->Cell(80);
    // Título
		$this->Cell(30,10,utf8_decode('Información sobre el pedido'),0,0,'C');
    // Salto de línea
		$this->Ln(20);
	}

	function Footer()
	{
    // Posición: a 1,5 cm del final
		$this->SetY(-15);
    // Arial italic 8
		$this->SetFont('Arial','I',8);
    // Número de página
		$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
	}	

}
