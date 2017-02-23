<div class="container">
	<div class="text-md-center">
		<div class="card">
			<div class="card-block">
				<h2><a href="<?php echo base_url('index.php/usuarios/modificar') ?>"><i class="fa fa-pencil" aria-hidden="true"></i> Modificar datos de mi cuenta</a></h2>			
				<h2><a href="<?php echo base_url('index.php/pedidos') ?>"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Ver mis pedidos</a></h2>
				<h2><a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-times" aria-hidden="true"></i> Dar de baja mi cuenta</a></h2>
				<h2><a href="<?php echo base_url('index.php/XML/exportar') ?>"><i class="fa fa-file" aria-hidden="true"></i> Exportar productos y categorías a XML</a></h2>
				<h2><a href="<?php echo base_url('index.php/XML/importar') ?>"><i class="fa fa-file" aria-hidden="true"></i> Importar productos y categorías desde un fichero XML</a></h2>
				<h2><a href="<?php echo base_url('index.php/excel') ?>"><i class="fa fa-table" aria-hidden="true"></i> Importar productos y categorías desde un fichero Excel</a></h2>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header text-md-center">
				<h5 class="modal-title" id="exampleModalLabel">¿Está seguro de que desea eliminar su cuenta?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-md-center">
				Esta acción no se puede deshacer
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<a href="<?php echo base_url('index.php/usuarios/eliminar') ?>" class="btn btn-danger boton"><i class="fa fa-times" aria-hidden="true"></i> Eliminar cuenta</a>
			</div>
		</div>
	</div>
</div>