<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {

	public function index()
	{
		$pedidos = $this->Model_pedidos->pedidos_usuario($this->session->userdata('id_usuario'));
		$this->load->plantilla('pedidos/pedidos.php', array('pedidos' => $pedidos));
	}

	public function realizar()
	{
		$this->Model_usuarios->solo_logueado();
		if (empty($this->session->userdata('carrito')))
		{
			redirect(base_url('index.php/carrito'));
		}
		if ($error = $this->Model_pedidos->comprueba_stock())
		{
			$this->load->plantilla('pedidos/no_stock', array('error' => $error));
		}
		else
		{
			$datos_usuario = $this->Model_usuarios->datos_usuario($this->session->userdata('id_usuario'));
			$datos_pedido = array(
				'id_usuario' => $datos_usuario['id'],
				'nombre' => $datos_usuario['nombre'],
				'apellidos' => $datos_usuario['apellidos'],
				'direccion' => $datos_usuario['direccion'],
				'email' => $datos_usuario['email'],
				'cp' => $datos_usuario['cp'],
				'estado' => 'aaa',
				'id_provincia' => $datos_usuario['id_provincia']
				);
			$id_pedido = $this->Model_pedidos->insertar_pedido($datos_pedido);
			foreach ($this->session->userdata('carrito') as $id_producto => $cantidad)
			{
				$datos_linea = array(
					'id_producto' => $id_producto,
					'id_pedido' => $id_pedido,
					'cantidad' => $cantidad,
					'precio' => $this->Model_productos->precio_final($id_producto)
					);
				$this->Model_pedidos->insertar_linea($datos_linea);
			}

			$this->load->library('email');
			
			$this->email->from('aula4@iessansebastian.com', 'Cristóbal');
			$this->email->to('cristobaldominguez95@gmail.com');
			
			$this->email->subject('Pedido realizado con éxito');
			$this->email->message("Puede consultar los detalles de su pedido en el siguiente enlace: http://iessansebastian.com/alumnos/2daw16/crisdo/index.php/pedidos/lineas/$id_pedido");
			
			$this->email->send();

			$this->session->unset_userdata('carrito');
			$this->load->plantilla('pedidos/envio_exito.php');
		}
	}

	public function lineas()
	{
		$lineas = $this->Model_pedidos->lineas_pedido($this->input->post('id_pedido'));
		echo json_encode($lineas);
		// $precio_pedido = $this->Model_pedidos->precio_pedido($this->uri->segment(3));
		// $this->load->plantilla('pedidos/lineas', array('lineas' => $lineas, 'precio_pedido' => $precio_pedido));
	}

}