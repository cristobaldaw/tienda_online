<div class="container">
	<div class="card col-md-6 offset-md-3 text-md-center">
		<div class="card-block">
		<?php if (isset($error)): ?>
			<div class="alert alert-danger alert-dismissible fade show">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="text-md-center">Usuario/contraseña incorrectos</div>
			</div>
		<?php endif ?>
			<form method="post">
				<div class="form-group">
					<label for="usuario">Usuario</label>
					<input type="text" name="usuario" class="form-control" value="<?php echo set_value('usuario') ?>">
				</div>
				<div class="form-group">
					<label for="pass">Contraseña</label>
					<input type="password" name="pass" class="form-control">
				</div>
				<a href="<?php echo base_url('index.php/usuarios/pide_correo') ?>">¿Ha olvidado su contraseña?</a><br><br>
				<button type="submit" class="btn btn-primary btn-block">Entrar</button>
			</form>
		</div>
	</div>
</div>