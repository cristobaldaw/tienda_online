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
		return $this->db->get_where('categorias', array('oculto' => 0))->result_array();
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
		return $this->db->get()->result_array();
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
		return $this->db->query('select p.* from productos p join categorias c on p.id_categoria = c.id where p.oculto = 0 and c.oculto = 0 and (p.destacado = 1 or SYSDATE() between p.fecha_ini and p.fecha_fin)')->result_array();
	}

	public function datos_categoria($id_cat)
	{
		return $this->db->get_where('categorias', array('id' => $id_cat))->row_array();
	}

	public function prod_by_id($id_prod)
	{
		return $this->db->get_where('productos', array('id' => $id_prod))->row_array();
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
		return $this->db->get_where('provincias', array('id' => $id_provincia))->row_array()['nombre'];
	}

	public function stock_producto($id_producto)
	{
		return $this->db->get_where('productos', array('id' => $id_producto))->row()->stock;
	}

	public function aumenta_stock($id_producto, $cantidad)
	{
		$this->db->query("update productos set stock = (stock + $cantidad) where id = $id_producto");
	}

	public function nombre_producto($id_producto)
	{
		return $this->db->get_where('productos', array('id' => $id_producto))->row()->nombre;
	}

	public function insertar_categoria($datos)
	{
		$this->db->insert('categorias', $datos);
	}

	public function insertar_producto($datos)
	{
		$this->db->insert('productos', $datos);
	}

	public function Total()
	{
		return $this->db->count_all('productos');
	}

	public function Lista($offset, $limit)
	{
		$this->db->limit($limit, $offset);
		return $this->db->get('productos')->result_array();
	}

}