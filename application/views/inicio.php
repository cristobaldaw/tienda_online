<div class="container">
	<div class="text-md-center">
		<h4><?php echo $localizacion ?></h4>
		<h1>Echa un vistazo a nuestros productos destacados</h1>
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner" role="listbox">
				<?php foreach ($destacados as $prod):
					$disabled = (!$prod['stock']) ? 'disabled' : ''; ?>
					<div class="carousel-item <?php if ($active) echo "active"; ?>">
						<div class="col-md-4">
							<a href="<?php echo base_url("index.php/productos/mostrar/$prod[id]") ?>"><img class="d-block img-fluid" src="<?php echo base_url("assets/img/$prod[imagen].jpg") ?>"></a>
						</div>
						<div class="pull-md-right d-none d-md-block">
							<h3><a href="<?php echo base_url("index.php/productos/mostrar/$prod[id]") ?>" class="nombre-prod"><?php echo $prod['nombre'] ?></a></h3>
							<p><?php echo $prod['descripcion'] ?></p>
							<?php if (!$prod['stock']): ?>
								<h2 class="text-md-center"><span class="badge badge-danger">Agotado</span></h2>
							<?php else: ?>
								<h2 class="text-md-center"><span class="badge badge-success">Disponible</span></h2>
							<?php endif ?>
							<a href="<?php echo base_url("index.php/carrito/anadir/$prod[id]") ?>" class="btn btn-primary boton <?php echo $disabled ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Añadir al carrito</a>
							<h3><?php echo $this->Model_productos->precio_final($prod['id']) ?>€</h3>
							
						</div>
					</div>
					<?php $active = false;
				endforeach ?>
			</div>
			<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<i class="fa fa-chevron-left fa-4x" aria-hidden="true"></i>
			</a>
			<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<i class="fa fa-chevron-right fa-4x" aria-hidden="true"></i>
			</a>
		</div>
	</div>
	<h1>Categorías</h1>
	<div class="row">
		<?php foreach ($categorias as $cat): ?>
				<div class="card card-inverse p-3 text-center col-md-12 card-cat">
					<a href="<?php echo base_url("index.php/productos/categoria/$cat[id]") ?>">
						<blockquote class="card-blockquote">
							<p><?php echo $cat['nombre'] ?></p>
							<footer>
								<small>
									<?php echo $cat['descripcion'] ?>
								</small>
							</footer>
						</blockquote>
					</a>
				</div>
		<?php endforeach ?>
	</div>
</div>