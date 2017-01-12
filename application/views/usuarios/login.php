<div class="container">
	<div class="card col-md-6 offset-md-3">
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
					<input type="text" name="usuario" class="form-control">
				</div>
				<div class="form-group">
					<label for="pass">Contraseña</label>
					<input type="password" name="pass" class="form-control">
				</div>
				<button type="submit" class="btn btn-primary btn-block">Entrar</button>
			</form>
		</div>
	</div>
</div>