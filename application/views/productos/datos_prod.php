<div class="container">
	<div class="card producto">
		<div class="card-block">
			<div class="row">
				<div class="col-md-5 img-fluid">
					<img class="img-fluid" src="<?php echo base_url("assets/img/$datos_prod[imagen].jpg") ?>">
				</div>
				<div class="col-md-7">
					<h3><strong><?php echo $datos_prod['nombre'] ?></strong><br><small><?php echo $datos_prod['descripcion'] ?></small></h3>
					<?php if ($datos_prod['descuento']): ?>
						<h3><li>¡<?php echo $datos_prod['descuento'] ?>% de descuento!</li></h3>
					<?php endif ?>
					<h3><strong>Precio: </strong> <?php echo $precio_final ?>€</h3>
					<?php if (!$datos_prod['stock']): ?>
						<h1 class="text-md-center"><span class="badge badge-danger">Agotado</span></h1>
					<?php else: ?>
						<h1 class="text-md-center"><span class="badge badge-success">Disponible</span></h1>
					<?php endif ?>
					<a href="<?php echo base_url("index.php/carrito/anadir/$datos_prod[id]") ?>" class="btn btn-primary btn-block boton <?php echo $disabled ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Añadir al carrito</a>
				</div>
			</div>
		</div>
	</div>
</div>