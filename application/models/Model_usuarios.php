<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_usuarios extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Añade un usuario a la base de datos
	 * @param array $datos 
	 * @return number
	 */
	public function anadir($datos)
	{
		unset($datos['conf_pass']);
		$datos['pass'] = md5($datos['pass']);
		$datos['borrado'] = 0;
		$this->db->insert('usuarios', $datos);
		return $this->db->insert_id();
	}

	/**
	 * Comprueba si un login es correcto y devuelve los datos en caso de serlo
	 * @param string $usuario 
	 * @param string $pass 
	 * @return array
	 */
	public function login_ok($usuario, $pass)
	{
		return $this->db->get_where('usuarios', array('usuario' => $usuario, 'pass' => md5($pass), 'borrado' => 0))->row_array();
	}

	/**
	 * Devuelve los datos de un usuario
	 * @param number $id_usuario 
	 * @return array
	 */
	public function datos_usuario($id_usuario)
	{
		return $this->db->get_where('usuarios', array('id' => $id_usuario))->row_array();
	}

	/**
	 * Elimina un usuario (modifica el campo 'borrado')
	 * @param number $id_usuario
	 */
	public function eliminar($id_usuario)
	{
		$this->db->update('usuarios', array('borrado' => 1), array('id' => $id_usuario));
	}

	/**
	 * Modifica los datos de un usuario
	 * @param number $id_usuario 
	 * @param array $datos
	 */
	public function modificar($id_usuario, $datos)
	{
		$this->db->update('usuarios', $datos, array('id' => $id_usuario));
	}

	/**
	 * Cambia la contraseña de un usuario
	 * @param number $id_usuario 
	 * @param string $pass
	 */
	public function cambia_pass($id_usuario, $pass)
	{
		$this->db->update('usuarios', array('pass' => md5($pass)), array('id' => $id_usuario));
	}

	/**
	 * Saca todas las provincias de la base de datos
	 * @return array
	 */
	public function get_all_provincias()
	{
		$this->db->order_by('nombre');
		$rs = $this->db->get('provincias')->result_array();
		foreach ($rs as $provincia)
		{
			$provincias[$provincia['id']] = $provincia['nombre'];
		}
		return $provincias;
	}

	/**
	 * Devuelve los datos de un usuario, dado un email
	 * @param string $email 
	 * @return array
	 */
	public function user_by_email($email)
	{
		return $this->db->get_where('usuarios', array('email' => $email))->row_array();
	}

}