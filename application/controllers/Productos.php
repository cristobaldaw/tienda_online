<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

 	/**
 	 * Carga la página principal con los productos destacados
 	 */
	public function index()
	{
		$client = new SoapClient('http://ws.cdyne.com/ip2geo/ip2geo.asmx?wsdl');		 
		$result = $client->ResolveIP(array('ipAddress' => $this->input->ip_address(), 'licenseKey' => 0));
		$localizacion = 'Nos visita desde ' . $result->ResolveIPResult->City . ', ' . $result->ResolveIPResult->Country;
		$destacados = $this->Model_productos->prod_destacados();
		$categorias = $this->Model_productos->get_all_categorias();
		$this->load->plantilla('inicio', array('destacados' => $destacados, 'categorias' => $categorias, 'active' => true, 'localizacion' => $localizacion), false, 'SmartShop');
	}

	/**
	 * Muestra los productos de una categoría, con paginación
	 */
	public function categoria()
	{
		$this->load->library('pagination');
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$productos = $this->Model_productos->prods_by_cat($this->uri->segment(3), $this->pagination->per_page, $page);
		$datos_cat = $this->Model_productos->datos_categoria($this->uri->segment(3));
		$config['total_rows'] = $this->Model_productos->total_by_cat($this->uri->segment(3));
		$config['base_url'] = base_url('index.php/productos/categoria/' . $this->uri->segment(3));
		$this->pagination->initialize($config);
		$this->load->plantilla('productos/prods_by_cat', array('productos' => $productos, 'datos_cat' => $datos_cat), false, "SmartShop - $datos_cat[nombre]");
	}

	/**
	 * Muestra los datos de un producto
	 */
	public function mostrar()
	{
		$datos_prod = $this->Model_productos->prod_by_id($this->uri->segment(3));
		$precio_final = $this->Model_productos->precio_final($datos_prod['id']);
		$disabled = (!$datos_prod['stock']) ? 'disabled' : '';
		$this->load->plantilla('productos/datos_prod', array('datos_prod' => $datos_prod, 'precio_final' => $precio_final, 'disabled' => $disabled), false, "SmartShop - $datos_prod[nombre]");
	}

}