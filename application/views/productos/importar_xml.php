<div class="container">
	<div class="card col-md-6 offset-md-3 text-md-center">
		<div class="card-block">
			<form method="post" action="<?php echo base_url('index.php/xml/importacion') ?>" enctype="multipart/form-data">
				<input type="file" name="xml"><br><br>
				<button type="submit" class="btn btn-primary">Importar</button>
			</form>
		</div>
	</div>
</div>