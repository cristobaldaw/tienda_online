<div class="container">
	<div class="card producto">
		<div class="card-block">
			<div class="row">
				<div class="col-md-6 img-fluid">
					<img class="img-fluid" src="<?php echo base_url("assets/img/$datos_prod[imagen].jpg") ?>">
				</div>
				<div class="col-md-6">
					<ul>
						<h3><li><strong><?php echo $datos_prod['nombre'] ?></strong><br><small><?php echo $datos_prod['descripcion'] ?></small></li></h3>
						<?php if ($datos_prod['descuento']): ?>
							<h3><li>¡<?php echo $datos_prod['descuento'] ?>% de descuento!</li></h3>
						<?php endif ?>
						<h3><li><strong>Precio: </strong> <?php echo $this->Model_productos->precio_final($datos_prod['id']) ?>€</li></h3>
						<h3><li><strong>Unidades en stock: </strong><?php echo $datos_prod['stock'] ?></li></h3>
					</ul>
					<?php if ($datos_prod['stock']): ?>
						<a href="<?php echo base_url("index.php/carrito/anadir/$datos_prod[id]") ?>" class="btn btn-primary btn-block boton"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Añadir al carrito</a>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>