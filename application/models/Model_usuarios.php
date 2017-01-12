<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_usuarios extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function anadir($datos)
	{
		$this->db->insert('usuarios', $datos);
	}

	public function login_ok($usuario, $pass)
	{
		$this->db->from('usuarios');
		$this->db->where(array('usuario' => $usuario, 'pass' => md5($pass)));
		return $this->db->count_all_results();
	}

}