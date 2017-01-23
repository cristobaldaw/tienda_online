<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_pedidos extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function insertar_pedido($datos)
	{
		$this->db->insert('pedidos', $datos);
		return $this->db->insert_id();
	}

	public function insertar_linea($datos)
	{
		$this->db->insert('linea_pedido', $datos);
	}

	public function pedidos_usuario($id_usuario)
	{
		$this->db->select("*, date_format(fecha, '%d/%m/%Y') as fecha");
		$query = $this->db->get_where('pedidos', array('id_usuario' => $id_usuario));
		return $query->result_array();
	}

	public function lineas_pedido($id_pedido)
	{
		$query = $this->db->get_where('linea_pedido', array('id_pedido' => $id_pedido));
		return $query->result_array();
	}

	public function precio_linea($id_linea)
	{
		$query = $this->db->get_where('linea_pedido', array('id' => $id_linea));
		return $query->row_array()['precio'] * $query->row_array()['cantidad'];
	}

	public function precio_pedido($id_pedido)
	{
		$this->db->select('sum(cantidad * precio) as precio_pedido');
		$this->db->from('linea_pedido');
		$this->db->where('id_pedido', $id_pedido);
		$query = $this->db->get();
		return $query->row_array()['precio_pedido'];
	}

	public function comprueba_stock()
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