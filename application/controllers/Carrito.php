<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrito extends CI_Controller {

	/**
	 * Carga la vista del carrito y lo inicializa si no se ha creado
	 * @return type
	 */
	public function index()
	{
		if (!isset($_SESSION['carrito']))
		{
			$this->session->set_userdata('carrito', $carrito = []);
		}
		$precio_total = $this->lib_carrito->precio_total();
		$this->load->plantilla('productos/carrito', array('precio_total' => $precio_total), false, 'SmartShop - Carrito');
	}

	/**
	 * Añade un producto al carrito, solo si hay stock
	 */
	public function anadir()
	{
		$stock = $this->Model_productos->stock_producto($this->uri->segment(3));
		if ($stock)
		{
			$this->lib_carrito->anadir($this->uri->segment(3));
		}
		redirect(base_url('index.php/carrito'));
	}

	/**
	 * Elimina un producto del carrito
	 */
	public function eliminar()
	{
		$this->lib_carrito->eliminar($this->uri->segment(3));
	}

	/**
	 * Vacia el carrito
	 */
	public function vaciar()
	{
		$this->lib_carrito->vaciar();
	}

	/**
	 * Aumenta la cantidad de un producto
	 */
	public function sube()
	{
		$this->lib_carrito->sube_cantidad($this->uri->segment(3));
	}

	/**
	 * Disminuye la cantidad de un producto
	 */
	public function baja()
	{
		$this->lib_carrito->baja_cantidad($this->uri->segment(3));
	}

}