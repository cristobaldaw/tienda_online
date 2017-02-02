<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_productos extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_categorias()
	{
		$this->db->where('oculto', 0);
		$query = $this->db->get('categorias');
		return $query->result_array();
	}

	public function prods_by_cat($id_cat, $inicio = '', $tam_pagina = '')
	{
		$this->db->limit($inicio, $tam_pagina);
		$this->db->select('productos.*');
		$this->db->from('productos');
		$this->db->join('categorias', 'productos.id_categoria = categorias.id');
		$this->db->where('id_categoria', $id_cat);
		$this->db->where('productos.oculto', 0);
		$this->db->where('categorias.oculto', 0);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function total_by_cat($id_cat)
	{
		$this->db->select('productos.*');
		$this->db->from('productos');
		$this->db->join('categorias', 'productos.id_categoria = categorias.id');
		$this->db->where('id_categoria', $id_cat);
		$this->db->where('productos.oculto', 0);
		$this->db->where('categorias.oculto', 0);
		return $this->db->count_all_results();
	}

	public function prod_destacados()
	{
		$this->db->select('productos.*');
		$this->db->from('productos');
		$this->db->join('categorias', 'productos.id_categoria = categorias.id');
		$this->db->where('productos.oculto', 0);
		$this->db->where('categorias.oculto', 0);
		$this->db->where('productos.destacado', 1);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function datos_categoria($id_cat)
	{
		$this->db->from('categorias');
		$this->db->where('id', $id_cat);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function prod_by_id($id_prod)
	{
		$query = $this->db->get_where('productos', array('id' => $id_prod));
		return $query->row_array();
	}

	public function precio_final($id_prod)
	{
		$query = $this->db->get_where('productos', array('id' => $id_prod))->row_array();
		$con_descuento = ($query['descuento']) ? $query['precio'] - ($query['precio'] * $query['descuento'] / 100) : $query['precio'];
		$con_iva = ($query['iva']) ? $con_descuento + ($con_descuento * $query['iva'] / 100) : $con_descuento;
		return round($con_iva, 2);
	}

	public function nombre_provincia($id_provincia)
	{
		$query = $this->db->get_where('provincias', array('id' => $id_provincia));
		return $query->row()->nombre;
	}

	public function stock_producto($id_producto)
	{
		$this->db->select('stock');
		$query = $this->db->get_where('productos', array('id' => $id_producto));
		return $query->row()->stock;
	}

	public function nombre_producto($id_producto)
	{
		$this->db->select('nombre');
		$query = $this->db->get_where('productos', array('id' => $id_producto));
		return $query->row()->nombre;
	}

	public function insertar_categoria($datos)
	{
		$this->db->insert('categorias', $datos);
	}

	public function insertar_producto($datos)
	{
		$this->db->insert('productos', $datos);
	}
}