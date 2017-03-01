<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_productos extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Devuelve todas las categorías que no están ocultas
	 * @return array
	 */
	public function get_all_categorias()
	{
		return $this->db->get_where('categorias', array('oculto' => 0))->result_array();
	}

	/**
	 * Devuelve todos los productos de una categoría, teniendo en cuenta la paginación
	 * @param number $id_cat 
	 * @param number $inicio 
	 * @param number $tam_pagina 
	 * @return array
	 */
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

	/**
	 * Total de productos de una categoría
	 * @param number $id_cat 
	 * @return number
	 */
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

	/**
	 * Devuelve los productos destacados
	 * @return array
	 */
	public function prod_destacados()
	{
		return $this->db->query('select p.* from productos p join categorias c on p.id_categoria = c.id where p.oculto = 0 and c.oculto = 0 and (p.destacado = 1 or SYSDATE() between p.fecha_ini and p.fecha_fin)')->result_array();
	}

	/**
	 * Devuelve los datos de una categoría
	 * @param number $id_cat 
	 * @return array
	 */
	public function datos_categoria($id_cat)
	{
		return $this->db->get_where('categorias', array('id' => $id_cat))->row_array();
	}

	/**
	 * Devuelve los datos de un producto, dado un id
	 * @param number $id_prod 
	 * @return array
	 */
	public function prod_by_id($id_prod)
	{
		return $this->db->get_where('productos', array('id' => $id_prod))->row_array();
	}

	/**
	 * Calcula el precio final de un producto, teniendo en cuenta el descuento y el iva
	 * @param number $id_prod 
	 * @return number
	 */
	public function precio_final($id_prod)
	{
		$query = $this->db->get_where('productos', array('id' => $id_prod))->row_array();
		$con_descuento = ($query['descuento']) ? $query['precio'] - ($query['precio'] * $query['descuento'] / 100) : $query['precio'];
		$con_iva = ($query['iva']) ? $con_descuento + ($con_descuento * $query['iva'] / 100) : $con_descuento;
		return round($con_iva, 2);
	}

	/**
	 * Devuelve el nombre de una provincia
	 * @param number $id_provincia 
	 * @return string
	 */
	public function nombre_provincia($id_provincia)
	{
		return $this->db->get_where('provincias', array('id' => $id_provincia))->row_array()['nombre'];
	}

	/**
	 * Devuelve el stock actual de un producto
	 * @param number $id_producto 
	 * @return number
	 */
	public function stock_producto($id_producto)
	{
		return $this->db->get_where('productos', array('id' => $id_producto))->row()->stock;
	}

	/**
	 * Aumenta el stock de un producto
	 * @param number $id_producto 
	 * @param number $cantidad
	 */
	public function aumenta_stock($id_producto, $cantidad)
	{
		$this->db->query("update productos set stock = (stock + $cantidad) where id = $id_producto");
	}

	/**
	 * Devuelve el nombre de un producto
	 * @param number $id_producto 
	 * @return string
	 */
	public function nombre_producto($id_producto)
	{
		return $this->db->get_where('productos', array('id' => $id_producto))->row()->nombre;
	}

	/**
	 * Inserta una categoría en la base de datos
	 * @param array $datos
	 */
	public function insertar_categoria($datos)
	{
		$this->db->insert('categorias', $datos);
	}

	/**
	 * Inserta un producto en la base de datos
	 * @param array $datos
	 */
	public function insertar_producto($datos)
	{
		$this->db->insert('productos', $datos);
	}

	/**
	 * Número total de productos
	 * @return number
	 */
	public function Total()
	{
		return $this->db->count_all('productos');
	}

	/**
	 * Devuelve todos los productos, con paginación
	 * @param number $offset 
	 * @param number $limit 
	 * @return array
	 */
	public function Lista($offset, $limit)
	{
		$this->db->limit($limit, $offset);
		return $this->db->get('productos')->result_array();
	}

}