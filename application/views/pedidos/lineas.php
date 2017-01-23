<div class="container">
	<table class="table table-bordered table-prods">
		<thead class="table-inverse text-md-center">
			<tr>
				<td>Producto</td>
				<td>Precio</td>
				<td>Cantidad</td>
				<td>Subtotal</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($lineas as $linea):
				$datos_prod = $this->Model_productos->prod_by_id($linea['id_producto'])?>
				<tr>
					<td>
						<div class="row">
							<div class="col-md-2">
								<a href="<?php echo base_url("index.php/productos/mostrar/$linea[id_producto]") ?>"><img src="<?php echo base_url("assets/img/$datos_prod[imagen]") ?>.jpg" class="img-fluid"></a>
							</div>
							<div class="col-md-10">
								<h4><a href="<?php echo base_url("index.php/productos/mostrar/$linea[id_producto]") ?>"><?php echo $datos_prod['nombre'] ?></a></h4>
								<p><?php echo $datos_prod['descripcion'] ?></p>
							</div>
						</div>
					</td>
					<td class="text-md-center"><?php echo $linea['precio'] ?>€</td>
					<td class="text-md-center"><?php echo $linea['cantidad'] ?></td>
					<td class="text-md-center"><?php echo $this->Model_pedidos->precio_linea($linea['id']) ?>€</td>
				</tr>
			<?php endforeach ?>
			<tr class="text-md-center">
				<td colspan="4" class="bg-info text-white"><strong>TOTAL: <?php echo $precio_pedido ?>€</strong></td>
			</tr>
		</tbody>
	</table>
	<a href="<?php echo base_url('index.php/pedidos') ?>" class="btn btn-primary boton"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
</div>