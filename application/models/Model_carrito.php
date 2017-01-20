<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_carrito extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function precio_linea($id_producto)
	{
		$precio_final = $this->Model_productos->precio_final($id_producto);
		return $precio_final * $this->session->userdata('carrito')[$id_producto];
	}

	public function precio_total()
	{
		$total = 0;
		foreach ($this->session->userdata('carrito') as $id_producto => $cantidad)
		{
			$total += $this->precio_linea($id_producto);
		}
		return $total;
	}

}