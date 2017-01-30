<div class="container">
	<div class="card col-md-6 offset-md-3 text-md-center">
		<div class="card-block">
			<form method="post">
				<div class="form-group">
					<label for="usuario">Introduzca su dirección de correo electrónico</label>
					<input type="text" name="email" class="form-control" value="<?php echo set_value('email') ?>">
					<?php echo form_error('email') ?><br><br>
					<button type="submit" class="btn btn-primary btn-block">Enviar</button>
				</div>
			</form>
		</div>
	</div>
</div>