<div class="container">
	<div class="card text-md-center">
		<div class="card-block">
			<ul>
				<?php foreach ($error as $id_producto => $stock):
					$nombre_prod = $this->Model_productos->nombre_producto($id_producto);
					$unidades = ($stock == 1) ? 'unidad' : 'unidades'; ?>
					<h3><li>No hay suficiente stock de <a href="<?php echo base_url("index.php/productos/mostrar/$id_producto") ?>"><?php echo $nombre_prod ?></a>. Hay <?php echo $stock . ' ' . $unidades ?> en stock.</li></h3>
				<?php endforeach ?>
			</ul>
			<a href="<?php echo base_url('index.php/carrito') ?>" class="btn btn-primary boton"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Volver al carrito</a>
		</div>
	</div>
</div>