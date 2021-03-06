<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_carrito
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
        $this->carrito = $this->ci->session->userdata('carrito');
	}

	private $carrito;

	/**
	 * Añade un producto al carrito. Si ya está dentro sube la cantidad en 1
	 * @param number $id_producto
	 */
	public function anadir($id_producto)
	{
		if ($this->esta_dentro($id_producto))
		{
			$this->sube_cantidad($id_producto);
		}
		else
		{
			$this->carrito[$id_producto] = 1;
		}
		$this->ci->session->set_userdata('carrito', $this->carrito);        
	}

	/**
	 * Número total de productos en el carrito
	 * @return number
	 */
	public function total_prods()
	{
		return (isset($_SESSION['carrito'])) ? array_sum($this->ci->session->userdata('carrito')) : 0;
	}

	/**
	 * Vacía el carrito
	 */
	public function vaciar()
	{
		$this->ci->session->unset_userdata('carrito');
	}

	/**
	 * Elimina un producto del carrito
	 * @param number $id_producto
	 */
	public function eliminar($id_producto)
	{
		unset($this->carrito[$id_producto]);
		$this->ci->session->set_userdata('carrito', $this->carrito);
	}

	/**
	 * Aumenta la cantidad de un producto
	 * @param number $id_producto
	 */
	public function sube_cantidad($id_producto)
	{
		if ($this->esta_dentro($id_producto))
		{
			$this->carrito[$id_producto]++;
		}
		$this->ci->session->set_userdata('carrito', $this->carrito);
	}

	/**
	 * Disminuye la cantidad de un producto
	 * @param number $id_producto
	 */
	public function baja_cantidad($id_producto)
	{
		if ($this->esta_dentro($id_producto) && $this->carrito[$id_producto] > 1)
		{
			$this->carrito[$id_producto]--;
		}
		$this->ci->session->set_userdata('carrito', $this->carrito);
	}

	/**
	 * Comprueba si un producto ya está en el carrito
	 * @param number $id_producto 
	 * @return boolean
	 */
	public function esta_dentro($id_producto)
	{
		return (isset($this->carrito[$id_producto]));
	}
	
	/**
	 * Calcula el precio de una línea del pedido
	 * @param number $id_producto
	 */
	public function precio_linea($id_producto)
	{
		$precio_final = $this->ci->Model_productos->precio_final($id_producto);
		return $precio_final * $this->carrito[$id_producto];
	}

	/**
	 * Calcula el precio total del carrito
	 * @return number
	 */
	public function precio_total()
	{
		$total = 0;
		foreach ($this->ci->session->userdata('carrito') as $id_producto => $cantidad)
		{
			$total += $this->precio_linea($id_producto);
		}
		return $total;
	}


}
