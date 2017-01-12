<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Model_provincias', 'Model_usuarios'));
		$this->load->helper('url');
		$this->load->library('form_validation');
	}

	function registro()
	{
		$this->form_validation->registro();
		$provincias = $this->Model_provincias->get_all_provincias();
		if (!$this->form_validation->run())
		{
			$this->load->vista('usuarios/registro', array('provincias' => $provincias), '', 'Registro');
		}
		else
		{
			unset($_POST['conf_pass']);
			$_POST['pass'] = md5($this->input->post('pass'));
			$this->Model_usuarios->anadir($this->input->post());
		}
	}

	function login()
	{
		if (!$this->input->post())
		{
			$this->load->vista('usuarios/login');
		}
		else
		{
			if ($this->Model_usuarios->login_ok($this->input->post('usuario'), $this->input->post('pass')))
			{
				echo "loginok";
			}
			else
			{
				$this->load->view('usuarios/login', array('error' => true));
			}
		}
	}

}
