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
		unset($datos['conf_pass']);
		$datos['pass'] = md5($datos['pass']);
		$datos['borrado'] = 0;
		$this->db->insert('usuarios', $datos);
		return $this->db->insert_id();
	}

	public function login_ok($usuario, $pass)
	{
		$query = $this->db->get_where('usuarios', array('usuario' => $usuario, 'pass' => md5($pass), 'borrado' => 0));
		return $query->row_array();
	}

	public function datos_usuario($id_usuario)
	{
		$query = $this->db->get_where('usuarios', array('id' => $id_usuario));
		return $query->row_array();
	}

	public function eliminar($id_usuario)
	{
		$this->db->update('usuarios', array('borrado' => 1), array('id' => $id_usuario));
	}

	public function modificar($id_usuario, $datos)
	{
		$this->db->update('usuarios', $datos, array('id' => $id_usuario));
	}

	public function solo_logueado()
	{
		if (!$this->session->has_userdata('usuario'))
		{
			redirect(base_url('index.php/usuarios/login'));
		}
	}

	public function solo_no_logueado()
	{
		if ($this->session->has_userdata('usuario'))
		{
			redirect(base_url());
		}
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