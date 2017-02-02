<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class XML extends CI_Controller {

	public function exportar() {

		header('Content-type: text/xml');
		header('Content-Disposition: attachment; filename="categorias_productos.xml"');

		$xml=new XMLWriter();
		$xml->openMemory();
		$xml->startDocument('1.0','UTF-8');
		$xml->setIndent(true);
		$xml->startElement('tienda');
		$categorias = $this->Model_productos->get_all_categorias();
		foreach ($categorias as $categoria):
			$productos = $this->Model_productos->prods_by_cat($categoria['id']);
			$xml->startElement('categoria');
				$xml->startElement('id');
					$xml->text($categoria['id']);
				$xml->endElement();
				$xml->startElement('cod');
					$xml->text($categoria['cod']);
				$xml->endElement();
				$xml->startElement('nombre');
					$xml->text($categoria['nombre']);
				$xml->endElement();
				$xml->startElement('descripcion');
					$xml->text($categoria['descripcion']);
				$xml->endElement();
				$xml->startElement('oculto');
					$xml->text($categoria['oculto']);
				$xml->endElement();
				$xml->startElement('productos');
					foreach ($productos as $prod):
						$xml->startElement('producto');
							$xml->startElement('id');
								$xml->text($prod['id']);
							$xml->endElement();
							$xml->startElement('cod');
								$xml->text($prod['cod']);
							$xml->endElement();
							$xml->startElement('nombre');
								$xml->text($prod['nombre']);
							$xml->endElement();
							$xml->startElement('precio');
								$xml->text($prod['precio']);
							$xml->endElement();
							$xml->startElement('descuento');
								$xml->text($prod['descuento']);
							$xml->endElement();
							$xml->startElement('imagen');
								$xml->text($prod['imagen']);
							$xml->endElement();
							$xml->startElement('iva');
								$xml->text($prod['iva']);
							$xml->endElement();
							$xml->startElement('descripcion');
								$xml->text($prod['descripcion']);
							$xml->endElement();
							$xml->startElement('id_categoria');
								$xml->text($prod['id_categoria']);
							$xml->endElement();
							$xml->startElement('stock');
								$xml->text($prod['stock']);
							$xml->endElement();
							$xml->startElement('fecha_ini');
								$xml->text($prod['fecha_ini']);
							$xml->endElement();
							$xml->startElement('fecha_fin');
								$xml->text($prod['fecha_fin']);
							$xml->endElement();
							$xml->startElement('oculto');
								$xml->text($prod['oculto']);
							$xml->endElement();
							$xml->startElement('destacado');
								$xml->text($prod['destacado']);
							$xml->endElement();
						$xml->endElement();
					endforeach;
				$xml->endElement();
			$xml->endElement();
		endforeach;
		$xml->endElement();
		$xml->endDocument();
		$output = $xml->outputMemory();
		echo $output;

	}

	public function importar()
	{
		$this->load->plantilla('productos/importar_xml');
	}

	public function importacion()
	{
		$archivo = $_FILES['xml']['tmp_name'];
		$xml = simplexml_load_file($archivo);
		foreach ($xml->categoria as $datos_cat)
		{
			$this->Model_productos->insertar_categoria($datos_cat);
			foreach ($datos_cat->productos->producto as $datos_prod)
			{
				$this->Model_productos->insertar_producto($datos_prod);
			}
		}
	}

}