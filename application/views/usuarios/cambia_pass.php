<div class="container">
	<div class="card col-md-6 offset-md-3">
		<div class="card-block">
			<form method="post">
				<label>Introduzca la nueva contraseña:</label><br>
				<input type="password" name="pass" class="form-control">
				<?php echo form_error('pass') ?><br>
				<button type="submit" class="btn btn-primary btn-block">Cambiar contraseña</button>
			</form>
		</div>
	</div>
</div>