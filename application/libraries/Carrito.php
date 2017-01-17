<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrito
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
        $carrito = [];
	}

	public function anadir($id_producto)
	{
		$carrito[] = $id_producto;
		$this->ci->session->set_userdata('carrito', $carrito);
	}

	public function total_prods()
	{
		return count($carrito);
	}

	

}
