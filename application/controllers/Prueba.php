<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prueba extends CI_Controller {

	public function index()
	{
		$this->load->library('PDF');
		$datos_pedido = $this->Model_pedidos->datos_pedido($this->uri->segment(3));
		$lineas = $this->Model_pedidos->lineas_pedido($this->uri->segment(3));
		$precio_pedido = $this->Model_pedidos->precio_pedido($this->uri->segment(3));
		$pdf=new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetY(50);
		$pdf->Cell(0, 10, utf8_decode('Nombre completo: ' . $datos_pedido['nombre'] . ' ' . $datos_pedido['apellidos']));
		$pdf->LN();
		$pdf->Cell(0, 10, utf8_decode('Dirección: ' . $datos_pedido['direccion']));
		$pdf->LN();
		$pdf->Cell(0, 10, utf8_decode('Provincia: ' . $this->Model_productos->nombre_provincia($datos_pedido['id_provincia'])));
		$pdf->LN();
		$pdf->Cell(0, 10, utf8_decode('Fecha: ' . $datos_pedido['fecha']));
		$pdf->LN();
		$pdf->LN();
		$pdf->SetFillColor(255,0,0);
		$pdf->SetTextColor(255);
		$pdf->SetDrawColor(128,0,0);
		$pdf->SetLineWidth(.3);
		$pdf->SetFont('','B');
		//Cabecera
		$pdf->Cell(80,7,'PRODUCTO',1,0,'C',1);
		$pdf->Cell(40,7,'PRECIO',1,0,'C',1);
		$pdf->Cell(30,7,'CANTIDAD',1,0,'C',1);
		$pdf->Cell(40,7,'SUBTOTAL',1,0,'C',1);
		$pdf->Ln();
		$pdf->SetFillColor(224,235,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('');

		$fill=false;
		foreach ($lineas as $linea)
		{
			$nombre = utf8_decode($this->Model_productos->nombre_producto($linea['id_producto']));
			$pdf->Cell(80,6,$nombre,'LR',0,'C',$fill);
			$pdf->Cell(40,6,$linea['precio'],'LR',0,'C',$fill);
			$pdf->Cell(30,6,$linea['cantidad'],'LR',0,'C',$fill);
			$pdf->Cell(40,6,$linea['cantidad'] * $linea['precio'],'LR',0,'C',$fill);
			$pdf->Ln();
			$fill=!$fill;
		}
		$pdf->SetFont('','B');
		$fill = true;
		$pdf->Cell(190,0,'','T');
		$pdf->Ln();
		$pdf->Cell(190,7,'TOTAL: ' . $precio_pedido,1,0,'C');
		$pdf->Output();
	}



}