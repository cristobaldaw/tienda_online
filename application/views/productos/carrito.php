<div class="container">	
	<table id="cart" class="table table-bordered">
		<thead class="table-inverse">
			<tr>
				<th class="text-md-center">Producto</th>
				<th class="text-md-center">Precio</th>
				<th class="text-md-center">Cantidad</th>
				<th class="text-md-center">Subtotal</th>
				<th class="text-md-center"></th>
			</tr>
		</thead>
		<tbody>
		<?php if (empty($this->session->userdata('carrito'))): ?>
			<tr>
				<td colspan="5" class="text-md-center">No hay productos en el carrito</td>
			</tr>
		<?php else: ?>
			<?php foreach ($this->session->userdata('carrito') as $id_producto => $cantidad):
				$datos_prod = $this->Model_productos->prod_by_id($id_producto) ?>
				<tr>
					<td>
						<div class="row">
							<div class="col-sm-2 hidden-xs"><a href="<?php echo base_url("index.php/productos/mostrar/$id_producto") ?>"><img src="<?php echo base_url("assets/img/$datos_prod[imagen]") ?>.jpg" class="img-fluid"/></a></div>
							<div class="col-sm-10">
								<h4 class="nomargin"><a href="<?php echo base_url("index.php/productos/mostrar/$id_producto") ?>"><?php echo $datos_prod['nombre'] ?></a></h4>
								<p><?php echo $datos_prod['descripcion'] ?></p>
							</div>
						</div>
					</td>
					<td><?php echo $this->Model_productos->precio_final($id_producto) ?>€</td>
					<td class="text-md-center">
						<a href="<?php echo base_url("index.php/carrito/sube/$id_producto") ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
						<label><?php echo $cantidad ?></label>
						<?php if ($cantidad > 1): ?>
							<a href="<?php echo base_url("index.php/carrito/baja/$id_producto") ?>"><i class="fa fa-minus" aria-hidden="true"></i></a>
						<?php endif ?>
					</td>
					<td class="text-center"><?php echo $this->Model_carrito->precio_linea($id_producto); ?>€</td>
					<td class="text-md-center">
						<a href="<?php echo base_url("index.php/carrito/eliminar/$id_producto") ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
					</td>
				</tr>
			<?php endforeach ?>
		<?php endif ?>
		</tbody>
		<?php if (!empty($this->session->userdata('carrito'))): ?>
			<tfoot>
				<tr>
					<td><a href="<?php echo base_url() ?>" class="btn btn-primary boton"><i class="fa fa-angle-left"></i> Seguir comprando</a>
					<a href="<?php echo base_url('index.php/carrito/vaciar') ?>" class="btn btn-danger boton"><i class="fa fa-times" aria-hidden="true"></i> Vaciar carrito</a></td>
					<td class="hidden-xs text-center" colspan="3"><strong>TOTAL: <?php echo $precio_total ?>€</strong></td>
					<td><a href="#" class="btn btn-success btn-block boton">Checkout <i class="fa fa-angle-right"></i></a></td>
				</tr>
			</tfoot>
		<?php endif ?>
	</table>
</div>