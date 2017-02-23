<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Incluimos definición de clase padre
require_once(APPPATH.'/libraries/JSON_WebServer_Controller.php');

class Agregador extends JSON_WebServer_Controller {

    public function __construct() {
        parent::__construct();
        
        // Registramos funciones disponibles
        $this->RegisterFunction('Total()', 'Devuelve el número de elementos que tenemos en la tienda');
        $this->RegisterFunction('Lista(offset, limit)', 
                'Devuelve una lista de productos de tamaño máximo [limit] comenzando desde la posición desde [offset]');
    }

    public function Total()
    {
        return $this->Model_productos->Total();
    }
    
    public function Lista($offset, $limit)
    {
        $lista_prods = [];
        $productos = $this->Model_productos->Lista($offset, $limit);
        foreach ($productos as $lista)
        {
            $lista_prods[] = array(
                'nombre' => $lista['nombre'],
                'descripcion' => $lista['descripcion'],
                'precio' => $lista['precio'],
                'img' => base_url("assets/img/$lista[imagen].jpg"),
                'url' => base_url("index.php/productos/mostrar/$lista[id]")
                );
        }
        return $lista_prods;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */