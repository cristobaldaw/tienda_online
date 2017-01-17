<div class="container">
	<div class="text-md-center">
		<h1>Echa un vistazo a nuestros productos destacados</h1>
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner" role="listbox">
				<?php foreach ($destacados as $dest): ?>
					<div class="carousel-item<?php if (!$cont)echo " active"; ?>">
						<div class="col-md-4">
							<img class="d-block img-fluid" src="<?php echo base_url("assets/img/$dest[imagen].jpg") ?>">
						</div>
						<div class="pull-md-right d-none d-md-block">
							<h3><?php echo $dest['nombre'] ?></h3>
							<p><?php echo $dest['descripcion'] ?></p>
							<h3><?php echo $this->Model_productos->precio_final($dest['id']) ?>€</h3>
							<button class="btn btn-lg btn-success"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Añadir al carrito</button>
						</div>
					</div>
				<?php $cont++; endforeach ?>
			</div>
			<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<i class="fa fa-chevron-left fa-4x" aria-hidden="true"></i>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<i class="fa fa-chevron-right fa-4x" aria-hidden="true"></i>
				<span class="sr-only">Next</span>
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