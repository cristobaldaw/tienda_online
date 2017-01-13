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
						<h3><li><strong>Precio: </strong> <?php echo $datos_prod['precio'] ?>€</li></h3>
						<h3><li><strong>Unidades en stock: </strong><?php echo $datos_prod['stock'] ?></li></h3>
					</ul>
					<?php if ($datos_prod['stock']): ?>
						<button class="btn btn-primary btn-block"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Añadir al carrito</button>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>