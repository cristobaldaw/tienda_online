<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_provincias extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_provincias()
	{
		$this->db->order_by('nombre');
		$query = $this->db->get('provincias');
		$rs = $query->result_array();
		foreach ($rs as $provincia)
		{
			$provincias[$provincia['id']] = $provincia['nombre'];
		}
		return $provincias;
	}

}