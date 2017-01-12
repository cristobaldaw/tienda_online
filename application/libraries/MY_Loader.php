<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{
	protected $ci;

	public function __construct()
	{
		parent::__construct();
        $this->ci =& get_instance();
	}

	public function vista($vista, $vars = [], $return = false)
	{
		$this->ci->load->view('template/header', array('title' => 'aa'));
		$this->ci->load->view($vista, $datos, $return);
		$this->ci->load->view('template/footer');
	}
	

}
