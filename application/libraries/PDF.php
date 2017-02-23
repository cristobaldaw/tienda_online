<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/third_party/fpdf/fpdf.php';

class PDF extends Fpdf
{

	public function Header()
	{
		$this->Image(APPPATH.'/third_party/fpdf/logo.png',10,8,33);
		$this->SetFont('Arial','B',15);
		$this->Cell(80);
		$this->Cell(30,10,utf8_decode('Información sobre el pedido'),0,0,'C');
		$this->Ln(20);
	}

	public function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
	}

}