<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_pedidos extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Inserta un pedido en la base de datos y devuelve su id
	 * @param array $datos 
	 * @return number
	 */
	public function insertar_pedido($datos)
	{
		$this->db->insert('pedidos', $datos);
		return $this->db->insert_id();
	}

	/**
	 * Inserta una línea de pedido en la base de datos
	 * @param array $datos
	 */
	public function insertar_linea($datos)
	{
		$this->db->insert('linea_pedido', $datos);
	}

	/**
	 * Devuelve los datos de un pedido
	 * @param number $id_pedido 
	 * @return array
	 */
	public function datos_pedido($id_pedido)
	{
		$this->db->select("*, date_format(fecha, '%d/%m/%Y') as fecha");
		return $this->db->get_where('pedidos', array('id' => $id_pedido))->row_array();
	}

	/**
	 * Devuelve todos los pedidos que ha realizado un usuario
	 * @param number $id_usuario 
	 * @return array
	 */
	public function pedidos_usuario($id_usuario)
	{
		$this->db->select("*, date_format(fecha, '%d/%m/%Y') as fecha");
		return $this->db->get_where('pedidos', array('id_usuario' => $id_usuario))->result_array();
	}

	/**
	 * Devuelve todas las líneas de un pedido
	 * @param number $id_pedido 
	 * @return array
	 */
	public function lineas_pedido($id_pedido)
	{
		$this->db->select('p.id as id_producto, p.nombre, p.imagen, l.precio, l.cantidad, (l.precio * l.cantidad) as precio_linea');
		$this->db->from('linea_pedido l')->join('productos p', 'l.id_producto = p.id');
		$this->db->where('l.id_pedido', $id_pedido);
		return $this->db->get()->result_array();
	}

	/**
	 * Devuelve el precio total de una línea de pedido
	 * @param number $id_linea 
	 * @return number
	 */
	public function precio_linea($id_linea)
	{
		$query = $this->db->get_where('linea_pedido', array('id' => $id_linea));
		return $query->row_array()['precio'] * $query->row_array()['cantidad'];
	}

	/**
	 * Devuelve el precio total de un pedido
	 * @param number $id_pedido 
	 * @return number
	 */
	public function precio_pedido($id_pedido)
	{
		$this->db->select('sum(cantidad * precio) as precio_pedido');
		return $this->db->get_where('linea_pedido', array('id_pedido' => $id_pedido))->row()->precio_pedido;
	}

	/**
	 * Cambia el estado de un pedido a cancelado
	 * @param number $id_pedido
	 */
	public function cancela_pedido($id_pedido)
	{
		$this->db->update('pedidos', array('estado' => 'ca'), array('id' => $id_pedido));
	}

}