<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
	}

	public function vista($vista, $datos = [], $return = false, $title = '')
	{
		$this->ci->load->model('Model_productos');
		$categorias = $this->ci->Model_productos->get_all_categorias();
		$this->ci->load->view('template/header', array('title' => $title, 'categorias' => $categorias));
		$this->ci->load->view($vista, $datos, $return);
		$this->ci->load->view('template/footer');
	}
	
}
