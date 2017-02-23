<div class="container">
	<div class="card col-md-6 offset-md-3 text-md-center">
		<div class="card-block">
			<h1>IMPORTACIÓN EXCEL (PRODUCTOS)</h1>
			<form method="post" action="<?php echo base_url('index.php/excel/importacion_prods') ?>" enctype="multipart/form-data">
				<input type="file" name="excel"><br><br>
				<button type="submit" class="btn btn-primary">Importar productos</button>
			</form><br>
			<h1>IMPORTACIÓN EXCEL (CATEGORÍAS)</h1>
			<form method="post" action="<?php echo base_url('index.php/excel/importacion_cats') ?>" enctype="multipart/form-data">
				<input type="file" name="excel"><br><br>
				<button type="submit" class="btn btn-primary">Importar categorías</button>
			</form>
		</div>
	</div>
</div>