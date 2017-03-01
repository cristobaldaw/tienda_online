<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {

	/**
	 * Muestra una lista con los pedidos de un usuario
	 */
	public function index()
	{
		$pedidos = $this->Model_pedidos->pedidos_usuario($this->session->userdata('id_usuario'));
		$this->load->plantilla('pedidos/pedidos.php', array('pedidos' => $pedidos), false, 'Smartshop - Mis pedidos');
	}

	/**
	 * Realiza un pedido y envía un email al usuario
	 */
	public function realizar()
	{
		$this->solo_logueado();
		if (empty($this->session->userdata('carrito')))
		{
			redirect(base_url('index.php/carrito'));
		}
		if ($error = $this->comprueba_stock())
		{
			$this->load->plantilla('pedidos/no_stock', array('error' => $error));
		}
		else
		{
			$datos_usuario = $this->Model_usuarios->datos_usuario($this->session->userdata('id_usuario'));
			$datos_pedido = array(
				'id_usuario' => $datos_usuario['id'],
				'nombre' => $datos_usuario['nombre'],
				'apellidos' => $datos_usuario['apellidos'],
				'direccion' => $datos_usuario['direccion'],
				'email' => $datos_usuario['email'],
				'cp' => $datos_usuario['cp'],
				'estado' => 'pe',
				'id_provincia' => $datos_usuario['id_provincia']
				);
			$id_pedido = $this->Model_pedidos->insertar_pedido($datos_pedido);
			foreach ($this->session->userdata('carrito') as $id_producto => $cantidad)
			{
				$datos_linea = array(
					'id_producto' => $id_producto,
					'id_pedido' => $id_pedido,
					'cantidad' => $cantidad,
					'precio' => $this->Model_productos->precio_final($id_producto)
					);
				$this->Model_pedidos->insertar_linea($datos_linea);
			}
			$datos_linea = $this->Model_pedidos->lineas_pedido($id_pedido);

			$html = $this->load->view('pedidos/contenido_email', array('datos_usuario' => $datos_usuario, 'datos_linea' => $datos_linea, 'provincia' => $this->Model_productos->nombre_provincia($datos_usuario['id_provincia']), 'precio_final' => 0), true);
			$pdf = $this->abre_pdf($id_pedido);

			$this->load->library('email');
			$this->email->from('aula4@iessansebastian.com', 'Cristóbal');
			$this->email->to($datos_usuario['email']);
			
			$this->email->subject('Pedido realizado con éxito');
			$this->email->message($html);
			$this->email->attach($pdf);
			
			$this->email->send();

			$this->session->unset_userdata('carrito');
			$this->load->plantilla('pedidos/envio_exito.php');
			
		}
	}

	/**
	 * Muestra los productos de un pedido
	 */
	public function lineas()
	{
		$lineas = $this->Model_pedidos->lineas_pedido($this->input->post('id_pedido'));
		echo json_encode($lineas);
	}

	/**
	 * Cancela un pedido
	 */
	public function cancelar()
	{
		$this->Model_pedidos->cancela_pedido($this->uri->segment(3));
		$lineas = $this->Model_pedidos->lineas_pedido($this->uri->segment(3));
		foreach ($lineas as $linea)
		{
			$this->Model_productos->aumenta_stock($linea['id_producto'], $linea['cantidad']);
		}
	}

	/**
	 * Muestra el PDF con los datos de un pedido
	 * @param number $id_pedido
	 */
	public function abre_pdf($id_pedido)
	{
		define('EURO',chr(128));
		$this->load->library('PDF');
		$datos_pedido = $this->Model_pedidos->datos_pedido($id_pedido);
		$lineas = $this->Model_pedidos->lineas_pedido($id_pedido);
		$precio_pedido = $this->Model_pedidos->precio_pedido($id_pedido);
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
			$pdf->Cell(40,6,$linea['precio'].EURO,'LR',0,'C',$fill);
			$pdf->Cell(30,6,$linea['cantidad'],'LR',0,'C',$fill);
			$pdf->Cell(40,6,($linea['cantidad'] * $linea['precio']).EURO,'LR',0,'C',$fill);
			$pdf->Ln();
			$fill=!$fill;
		}
		$pdf->SetFont('','B');
		$fill = true;
		$pdf->Cell(190,0,'','T');
		$pdf->Ln();
		$pdf->Cell(190,7,'TOTAL: ' . $precio_pedido.EURO,1,0,'C');
		if ($this->uri->segment(4) == 'open')
		{
			$pdf->Output();
		}
		else
		{
			$nombre = tempnam(APPPATH . 'upload/', 'fact-') . '.pdf';
			$pdf->Output('F', $nombre);
			return $nombre;
		}
	}

	/**
	 * Solo permite entrar si el usuario está logueado
	 */
	private function solo_logueado()
	{
		if (!$this->session->has_userdata('usuario'))
		{
			redirect(base_url('index.php/usuarios/login'));
		}
	}

	/**
	 * Comprueba si hay suficiente stock de un pedido
	 * @return array
	 */
	private function comprueba_stock()
	{
		$error = [];
		foreach ($this->session->userdata('carrito') as $id_producto => $cantidad)
		{
			$stock = $this->Model_productos->stock_producto($id_producto);
			if ($cantidad > $stock)
			{
				$error[$id_producto] = $stock;
			}
		}
		return $error;
	}

}