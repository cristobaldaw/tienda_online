<div class="container">	
	<table id="cart" class="table">
		<thead class="table-inverse">
			<tr>
				<td class="text-md-center">Producto</td>
				<td class="text-md-center">Precio</td>
				<td class="text-md-center">Cantidad</td>
				<td class="text-md-center">Subtotal</td>
				<td class="text-md-center"></td>
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
				<tr id="fila<?php echo $id_producto ?>" class="fila_prod">
					<td>
						<div class="row">
							<div class="col-md-3">
								<a href="<?php echo base_url("index.php/productos/mostrar/$datos_prod[id]") ?>"><img src="<?php echo base_url("assets/img/$datos_prod[imagen]") ?>.jpg" class="img-fluid"></a>
							</div>
							<div class="col-md-9">
								<h4><a href="<?php echo base_url("index.php/productos/mostrar/$id_producto") ?>"><?php echo $datos_prod['nombre'] ?></a></h4>
								<p><?php echo $datos_prod['descripcion'] ?></p>
							</div>
						</div>
					</td>
					<td class="text-md-center precio<?php echo $id_producto ?>"><?php echo $this->Model_productos->precio_final($id_producto) ?>€</td>
					<td class="text-md-center">
						<a href="#" class="sube-cant" id_prod="<?php echo $id_producto ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
						<label id="cantidad<?php echo $id_producto ?>" class="cantidad"><?php echo $cantidad ?></label>
						<a href="#" class="baja-cant" id_prod="<?php echo $id_producto ?>"><i class="fa fa-minus" aria-hidden="true"></i></a>
					</td>
					<td class="text-md-center"><label id="subtotal<?php echo $id_producto ?>" class="subtotal"><?php echo $this->lib_carrito->precio_linea($id_producto); ?></label>€</td>
					<td class="text-md-center">
						<h4><a href="#" class="rojo eliminar" id_prod="<?php echo $id_producto ?>"><i class="fa fa-times" aria-hidden="true"></i></a></h4>
					</td>
				</tr>
			<?php endforeach ?>
		<?php endif ?>
		</tbody>
		<?php if (!empty($this->session->userdata('carrito'))): ?>
			<tfoot>
				<tr>
					<td><a href="<?php echo base_url() ?>" class="btn btn-primary boton"><i class="fa fa-angle-left"></i> Seguir comprando</a>
					<button class="btn btn-danger boton" id="vaciar"><i class="fa fa-times" aria-hidden="true"></i> Vaciar carrito</button>
					<td class="hidden-xs text-center" colspan="3"><strong>TOTAL: <label id="total"><?php echo $precio_total ?></label>€</strong></td>
					<td><a href="<?php echo base_url('index.php/pedidos/realizar') ?>" class="btn btn-success btn-block boton">Tramitar pedido <i class="fa fa-angle-right"></i></a></td>
				</tr>
			</tfoot>
		<?php endif ?>
	</table>
</div>