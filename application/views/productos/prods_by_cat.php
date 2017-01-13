<div class="container">
	<div class="jumbotron jumbotron-fluid text-md-center">
		<div class="container">
		<h1 class="display-3"><?php echo $datos_cat['nombre'] ?></h1>
			<p class="lead"><?php echo $datos_cat['descripcion'] ?></p>
		</div>
	</div>
	<div class="row">
		<?php foreach ($productos as $prod): ?>
			<div class="col-md-4">
				<div class="card producto">
					<a href="<?php echo base_url("productos/mostrar/$prod[id]") ?>"><img class="card-img-top img-responsive img-fluid" src="<?php echo base_url("assets/img/$prod[imagen].jpg") ?>" alt="Card image cap"></a>
					<div class="card-block">
						<?php if (!$prod['stock']): ?>
							<h2 class="text-md-center"><span class="badge badge-danger">Agotado</span></h2>
						<?php else: ?>
							<h2 class="text-md-center"><span class="badge badge-success">Disponible</span></h2>
						<?php endif ?>
						<a href="<?php echo base_url("productos/mostrar/$prod[id]") ?>"><h3 class="card-title col-md-10"><?php echo $prod['nombre'] ?></h3></a>
						<button class="btn btn-sm btn-info btn-info float-md-right" title="Mostrar información del producto"><i class="fa fa-search-plus" aria-hidden="true"></i></button>
						<p class="card-text info-prod"><?php echo $prod['descripcion'] ?></p>
						<h3 class="text-md-center"><strong><?php echo $prod['precio'] ?>€</strong></h3>
						<?php if ($prod['stock']): ?>
							<a href="#" class="btn btn-primary btn-block"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Añadir al carrito</a>
						<?php endif ?>
					</div>
				</div>
			</div>
		<?php endforeach ?> 
	</div>
	<div class="text-md-center">
		<?php echo $this->pagination->create_links() ?>
	</div>
</div>