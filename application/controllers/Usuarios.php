<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('dni');
	}

	function registro()
	{
		$this->Model_usuarios->solo_no_logueado();
		$this->reglas_registro();
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
		$this->reglas_modificar();
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

	function pide_correo()
	{
		$this->form_validation->set_rules('email', 'correo electrónico', 'required|valid_email');
		if (!$this->form_validation->run())
		{
			$this->load->plantilla('usuarios/pide_correo');
		}
		else
		{
			$this->load->plantilla('usuarios/correo_exito');
			if ($datos = $this->Model_usuarios->user_by_email($this->input->post('email')))
			{

				$this->load->library('email');
				
				$this->email->from('aula4@iessansebastian.com', 'Cristóbal');
				$this->email->to($datos['email']);
				
				$this->email->subject('Enlace para restablecer contraseña');
				$this->email->message(base_url('index.php/usuarios/cambia_pass/' . $datos['id'] . '/' . sha1($datos['nombre'] . $datos['cp'] . date('m-y-d'))));	
				$this->email->send();

				echo $this->email->print_debugger();
			}			
		}
		
	}

	function cambia_pass()
	{
		if ($this->Model_usuarios->comprueba_enlace($this->uri->segment(3), $this->uri->segment(4)))
		{
			$this->form_validation->set_rules('pass', 'contraseña', 'required', array('required' => 'Introduzca contraseña'));
			if (!$this->form_validation->run())
			{
				$this->load->plantilla('usuarios/cambia_pass');
			}
			else
			{
				$this->Model_usuarios->cambia_pass($this->uri->segment(3), $this->input->post('pass'));
				redirect(base_url());
			}
		}
		else
		{
			redirect(base_url());
		}
	}


	private function reglas_registro()
	{
		$this->form_validation->set_rules('nombre', 'nombre', 'required');
		$this->form_validation->set_rules('apellidos', 'apellidos', 'required');
		$this->form_validation->set_rules('dni', 'dni', 'required|callback_dni_check');
		$this->form_validation->set_rules('direccion', 'direccion', 'required');
		$this->form_validation->set_rules('id_provincia', 'provincia', 'greater_than[0]', array('greater_than' => 'El campo {field} es obligatorio'));
		$this->form_validation->set_rules('cp', 'código postal', 'trim|required|exact_length[5]|integer');
		$this->form_validation->set_rules('usuario', 'usuario', 'required|is_unique[usuarios.usuario]');
		$this->form_validation->set_rules('email', 'correo electrónico', 'required|valid_email');
		$this->form_validation->set_rules('pass', 'contraseña', 'required');
		$this->form_validation->set_rules('conf_pass', 'confirmar contraseña', 'required|matches[pass]');
	}

	private function reglas_modificar()
	{
		$this->form_validation->set_rules('nombre', 'nombre', 'required');
		$this->form_validation->set_rules('apellidos', 'apellidos', 'required');
		$this->form_validation->set_rules('direccion', 'direccion', 'required');
		$this->form_validation->set_rules('id_provincia', 'provincia', 'greater_than[0]', array('greater_than' => 'El campo {field} es obligatorio'));
		$this->form_validation->set_rules('cp', 'código postal', 'trim|required|exact_length[5]|integer');
		$this->form_validation->set_rules('email', 'correo electrónico', 'required|valid_email');
	}

	public function dni_check($dni)
	{
		if (dni_valida_nif_cif_nie($dni))
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('dni_check', 'Introduzca un DNI válido');
			return false;
		}
	}

}