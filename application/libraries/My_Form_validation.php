<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Form_validation extends CI_Form_validation
{
	protected $ci;

	public function __construct()
	{
		parent::__construct();
        $this->ci =& get_instance();
	}

	public function registro()
	{
		$this->ci->form_validation->set_error_delimiters('<span class="error">', '<span>');
		$this->ci->form_validation->set_rules('nombre', 'nombre', 'required');
		$this->ci->form_validation->set_rules('apellidos', 'apellidos', 'required');
		$this->ci->form_validation->set_rules('dni', 'dni', 'required');
		$this->ci->form_validation->set_rules('direccion', 'direccion', 'required');
		$this->ci->form_validation->set_rules('id_provincia', 'provincia', 'greater_than[0]');
		$this->ci->form_validation->set_rules('cp', 'código postal', 'trim|required|exact_length[5]|integer');
		$this->ci->form_validation->set_rules('usuario', 'usuario', 'required|is_unique[usuarios.usuario]');
		$this->ci->form_validation->set_rules('email', 'correo electrónico', 'required|valid_email');
		$this->ci->form_validation->set_rules('pass', 'contraseña', 'required');
		$this->ci->form_validation->set_rules('conf_pass', 'confirmar contraseña', 'required|matches[pass]');
	}

	

}
