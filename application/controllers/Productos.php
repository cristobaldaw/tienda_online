<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->Model('Model_productos');
		$this->load->helper('url');
		$this->load->library('pagination');
	}

	public function categoria()
	{
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$productos = $this->Model_productos->prods_by_cat($this->uri->segment(3), $this->pagination->per_page, $page);
		$datos_cat = $this->Model_productos->datos_categoria($this->uri->segment(3));
		$config['total_rows'] = $this->Model_productos->total_by_cat($this->uri->segment(3));
		$config['base_url'] = base_url('productos/categoria/' . $this->uri->segment(3));
		$this->pagination->initialize($config);
		$this->load->vista('productos/prods_by_cat', array('productos' => $productos, 'datos_cat' => $datos_cat));
	}



}