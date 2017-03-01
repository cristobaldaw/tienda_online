<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	/**
	 * Registro de usuario
	 */
	function registro()
	{
		$this->solo_no_logueado();
		$this->reglas_registro();
		$provincias = $this->Model_usuarios->get_all_provincias();
		if (!$this->form_validation->run())
		{
			$this->load->plantilla('usuarios/registro', array('provincias' => $provincias), '', 'SmartShop - Registro');
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

	/**
	 * Login de usuario
	 */
	function login()
	{
		$this->solo_no_logueado();
		if (!$this->input->post())
		{
			$this->load->plantilla('usuarios/login', '', false, 'SmartShop - Iniciar sesión');
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

	/**
	 * Carga la vista de preferencias del usuario
	 */
	function preferencias()
	{
		$this->solo_logueado();
		$this->load->plantilla('usuarios/preferencias', '', false, 'SmartShop - Preferencias de mi cuenta');
	}

	/**
	 * Da de baja un usuario de la base de datos
	 * @return type
	 */
	function eliminar()
	{
		$this->solo_logueado();
		$this->Model_usuarios->eliminar($this->session->userdata('id_usuario'));
		$this->session->unset_userdata('id_usuario');
		$this->session->unset_userdata('usuario');
		redirect(base_url());
	}

	/**
	 * Modifica los datos de un usuario
	 */
	function modificar()
	{
		$this->solo_logueado();
		$datos = $this->Model_usuarios->datos_usuario($this->session->userdata('id_usuario'));
		$provincias = $this->Model_usuarios->get_all_provincias();
		$this->reglas_modificar();
		if (!$this->form_validation->run())
		{
			$this->load->plantilla('usuarios/modificar', array('datos' => $datos, 'provincias' => $provincias), false, 'SmartShop - Modificar datos de mi cuenta');
		}
		else
		{
			$this->Model_usuarios->modificar($this->session->userdata('id_usuario'), $this->input->post());
			redirect('usuarios/preferencias');
		}
	}

	/**
	 * Cierra sesión
	 */
	function Logout()
	{
		$this->solo_logueado();
		$this->session->unset_userdata('id_usuario');
		$this->session->unset_userdata('usuario');
		redirect(base_url());
	}

	/**
	 * Pide el correo para recuperar contraseña y lo envía a la dirección especificada, solo si existe
	 */
	function pide_correo()
	{
		$this->solo_no_logueado();
		$this->form_validation->set_rules('email', 'correo electrónico', 'required|valid_email');
		if (!$this->form_validation->run())
		{
			$this->load->plantilla('usuarios/pide_correo', '', false, 'SmartShop - Recuperar contraseña');
		}
		else
		{
			$this->load->plantilla('usuarios/correo_exito');
			if ($datos = $this->Model_usuarios->user_by_email($this->input->post('email')))
			{
				$this->load->library('email');
				
				$this->email->from('aula4@iessansebastian.com', 'SmartShop');
				$this->email->to($datos['email']);
				
				$this->email->subject('Enlace para restablecer contraseña');
				$this->email->message(base_url('index.php/usuarios/cambia_pass/' . $datos['id'] . '/' . sha1($datos['nombre'] . $datos['cp'] . date('m-y-d'))));	
				$this->email->send();
			}			
		}
		
	}

	/**
	 * Cambia la contraseña del usuario, solo si el hash es correcto
	 */
	function cambia_pass()
	{
		$datos = $this->Model_usuarios->datos_usuario($this->uri->segment(3));
		$hash = sha1($datos['nombre'] . $datos['cp'] . date('m-y-d'));
		if ($hash == $this->uri->segment(4))
		{
			$this->form_validation->set_rules('pass', 'contraseña', 'required', array('required' => 'Introduzca contraseña'));
			if (!$this->form_validation->run())
			{
				$this->load->plantilla('usuarios/cambia_pass', '', false, 'SmartShop - Recuperar contraseña');
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

	/**
	 * Reglas para la validación de un registro de usuario
	 */
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

	/**
	 * Reglas para la validación de modificación de datos de un usuario
	 */
	private function reglas_modificar()
	{
		$this->form_validation->set_rules('nombre', 'nombre', 'required');
		$this->form_validation->set_rules('apellidos', 'apellidos', 'required');
		$this->form_validation->set_rules('direccion', 'direccion', 'required');
		$this->form_validation->set_rules('id_provincia', 'provincia', 'greater_than[0]', array('greater_than' => 'El campo {field} es obligatorio'));
		$this->form_validation->set_rules('cp', 'código postal', 'trim|required|exact_length[5]|integer');
		$this->form_validation->set_rules('email', 'correo electrónico', 'required|valid_email');
	}

	/**
	 * Comprueba si un DNI es válido
	 * @param string $dni
	 */
	public function dni_check($dni)
	{
		$this->load->helper('dni');
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

	/**
	 * Solo permite entrar si el usuario está logueado
	 */
	private function solo_logueado()
	{
		if (!$this->session->has_userdata('usuario'))
		{
			redirect(base_url('index.php/usuarios/login'));
		}
	}

	/**
	 * Solo permite entrar si el usuario no está logueado
	 */
	private function solo_no_logueado()
	{
		if ($this->session->has_userdata('usuario'))
		{
			redirect(base_url());
		}
	}

}