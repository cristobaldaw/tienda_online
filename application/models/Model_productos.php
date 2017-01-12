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

	public function prods_by_cat($id_cat, $inicio, $tam_pagina)
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

	public function datos_categoria($id_cat)
	{
		$this->db->from('categorias');
		$this->db->where('id', $id_cat);
		$query = $this->db->get();
		return $query->row_array();
	}

}