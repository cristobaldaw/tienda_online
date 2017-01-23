<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrito extends CI_Controller {

	public function index()
	{
		if (!isset($_SESSION['carrito']))
		{
			$this->session->set_userdata('carrito', $carrito = []);
		}
		$precio_total = $this->lib_carrito->precio_total();
		$this->load->plantilla('productos/carrito', array('precio_total' => $precio_total));
	}

	public function anadir()
	{
		$datos_prod = $this->Model_productos->prod_by_id($this->uri->segment(3));
		if ($datos_prod['stock'])
		{
			$this->lib_carrito->anadir($this->uri->segment(3));
		}
		redirect(base_url('index.php/carrito'));
	}

	public function eliminar()
	{
		$this->lib_carrito->eliminar($this->uri->segment(3));
		redirect(base_url('index.php/carrito'));
	}

	public function vaciar()
	{
		$this->lib_carrito->vaciar();
		redirect(base_url('index.php/carrito'));
	}

	public function sube()
	{
		$this->lib_carrito->sube_cantidad($this->uri->segment(3));
		redirect(base_url('index.php/carrito'));
	}

	public function baja()
	{
		$this->lib_carrito->baja_cantidad($this->uri->segment(3));
		redirect(base_url('index.php/carrito'));
	}

}