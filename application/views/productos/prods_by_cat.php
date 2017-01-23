<div class="container">
	<div class="jumbotron jumbotron-fluid text-md-center">
		<div class="container">
		<h1 class="display-3"><?php echo $datos_cat['nombre'] ?></h1>
			<p class="lead"><?php echo $datos_cat['descripcion'] ?></p>
		</div>
	</div>
	<div class="row">
		<?php foreach ($productos as $prod):
			$disabled = (!$prod['stock']) ? 'disabled' : ''; ?>
			<div class="col-md-4">
				<div class="card producto">
					<a href="<?php echo base_url("index.php/productos/mostrar/$prod[id]") ?>"><img class="card-img-top img-responsive img-fluid" src="<?php echo base_url("assets/img/$prod[imagen].jpg") ?>" alt="Card image cap"></a>
					<div class="card-block">
						<?php if (!$prod['stock']): ?>
							<h2 class="text-md-center"><span class="badge badge-danger">Agotado</span></h2>
						<?php else: ?>
							<h2 class="text-md-center"><span class="badge badge-success">Disponible</span></h2>
						<?php endif ?>
						<div class="row">
							<div class="col-md-12 text-md-center">
								<a href="<?php echo base_url("index.php/productos/mostrar/$prod[id]") ?>" class="nombre-prod"><h5 class="card-title"><?php echo $prod['nombre'] ?></h5></a>
							</div>
						</div>
						<?php if ($prod['descuento']): ?>
							<h5 class="text-md-center"><strong>¡<?php echo $prod['descuento'] ?>% de descuento!</strong></h5>
						<?php endif ?>
						<h3 class="text-md-center"><strong><?php echo $this->Model_productos->precio_final($prod['id']) ?>€</strong></h3>
						<button class="btn btn-sm btn-info float-md-right" title="Mostrar información del producto"><i class="fa fa-plus" aria-hidden="true"></i></button>
						<p class="card-text text-md-center info-prod"><?php echo $prod['descripcion'] ?></p>
						<a href="<?php echo base_url("index.php/carrito/anadir/$prod[id]") ?>" class="btn btn-primary btn-block boton <?php echo $disabled ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Añadir al carrito</a>
					</div>
				</div>
			</div>
		<?php endforeach ?> 
	</div>
	<div class="text-md-center">
		<?php echo $this->pagination->create_links() ?>
	</div>
</div>