<div class="container">
	<table class="table table-bordered text-md-center">
		<thead class="table-inverse">
			<tr>
				<td>Fecha</td>
				<td>Nombre</td>
				<td>Apellidos</td>
				<td>Provincia</td>
				<td>Dirección</td>
				<td>Código postal</td>
				<td colspan="2">Opciones</td>
			</tr>
		</thead>
		<tbody>
			<?php if (!$pedidos): ?>
				<tr>
					<td colspan="7">Aún no ha realizado ningún pedido</td>
				</tr>
			<?php else: ?>
				<?php foreach ($pedidos as $pedido): ?>
					<tr>
						<td><?php echo $pedido['fecha'] ?></td>
						<td><?php echo $pedido['nombre'] ?></td>
						<td><?php echo $pedido['apellidos'] ?></td>
						<td><?php echo $this->Model_productos->nombre_provincia($pedido['id_provincia']) ?></td>
						<td><?php echo $pedido['direccion'] ?></td>
						<td><?php echo $pedido['cp'] ?></td>
						<td><a href="#" class="link-detalles" id_pedido="<?php echo $pedido['id'] ?>">Ver detalles del pedido</a></td>
						<td><a href="<?php echo base_url("index.php/prueba/index/$pedido[id]") ?>"><i class="fa fa-file-text rojo" aria-hidden="true"></i> PDF</a></td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
		</tbody>
	</table>
	<a href="<?php echo base_url('index.php/usuarios/preferencias') ?>" class="btn btn-primary boton"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
</div>







<div class="modal fade" id="modal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
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
					<tbody id="table-modal">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>