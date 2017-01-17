<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	function registro()
	{
		$this->Model_usuarios->solo_no_logueado();
		$this->form_validation->registro();
		$provincias = $this->Model_usuarios->get_all_provincias();
		if (!$this->form_validation->run())
		{
			$this->load->plantilla('usuarios/registro', array('provincias' => $provincias), '', 'Registro');
		}
		else
		{
			$id_usuario = $this->Model_usuarios->anadir($this->input->post());
			$usuario = $this->input->post('usuario');
			$sesion_usuario = array(
				'id_usuario' => $id_usuario,
				'usuario' => $usuario
				);
			$this->session->set_userdata($sesion_usuario);
			redirect(base_url());
		}
	}

	function login()
	{
		$this->Model_usuarios->solo_no_logueado();
		if (!$this->input->post())
		{
			$this->load->plantilla('usuarios/login');
		}
		else
		{
			$login_ok = $this->Model_usuarios->login_ok($this->input->post('usuario'), $this->input->post('pass'));
			if ($login_ok)
			{
				$sesion_usuario = array(
					'id_usuario' => $login_ok['id'],
					'usuario' => $login_ok['usuario']
				);
				$this->session->set_userdata($sesion_usuario);
				redirect(base_url());
			}
			else
			{
				$this->load->plantilla('usuarios/login', array('error' => true));
			}
		}
	}

	function preferencias()
	{
		$this->Model_usuarios->solo_logueado();
		$this->load->plantilla('usuarios/preferencias');
	}

	function eliminar()
	{
		$this->Model_usuarios->solo_logueado();
		$this->Model_usuarios->eliminar($this->session->userdata('id_usuario'));
		$this->session->unset_userdata('id_usuario');
		$this->session->unset_userdata('usuario');
		redirect(base_url());
	}

	function modificar()
	{
		$datos = $this->Model_usuarios->datos_usuario($this->session->userdata('id_usuario'));
		$provincias = $this->Model_usuarios->get_all_provincias();
		$this->form_validation->modificar_usuarios();
		if (!$this->form_validation->run())
		{
			$this->load->plantilla('usuarios/modificar', array('datos' => $datos, 'provincias' => $provincias));
		}
		else
		{
			$this->Model_usuarios->modificar($this->session->userdata('id_usuario'), $this->input->post());
			redirect('usuarios/preferencias');
		}
	}

	function Logout()
	{
		$this->Model_usuarios->solo_logueado();
		$this->session->unset_userdata('id_usuario');
		$this->session->unset_userdata('usuario');
		redirect(base_url());
	}

}