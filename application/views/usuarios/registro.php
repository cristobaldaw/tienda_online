<div class="container">
	<div class="card">
		<div class="card-block">
			<h1 class="text-md-center card-title">Formulario de registro</h1>
			<form method="post">
				<div class="row">
					<div class="form-group col-md-6">
						<label for="nombre">Nombre</label>
						<div class="input-group">
							<span class="input-group-addon" id="nombre"><i class="fa fa-user" aria-hidden="true"></i></span>
				 			<input type="text" class="form-control" name="nombre" aria-describedby="nombre" maxlength="45" value="<?php echo set_value('nombre') ?>">
						</div>
						<?php echo form_error('nombre') ?>
					</div>
					<div class="form-group col-md-6">
						<label for="apellidos">Apellidos</label>
						<div class="input-group">
							<span class="input-group-addon" id="apellidos"><i class="fa fa-user" aria-hidden="true"></i></span>
				 			<input type="text" class="form-control" name="apellidos" aria-describedby="apellidos" maxlength="100" value="<?php echo set_value('apellidos') ?>">
						</div>
						<?php echo form_error('apellidos') ?>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="dni">DNI</label>
						<div class="input-group">
							<span class="input-group-addon" id="dni"><i class="fa fa-id-card" aria-hidden="true"></i></span>
				 			<input type="text" class="form-control" name="dni" aria-describedby="dni" maxlength="9" value="<?php echo set_value('dni') ?>">
						</div>
						<?php echo form_error('dni') ?>
					</div>
					<div class="form-group col-md-6">
						<label for="direccion">Dirección</label>
						<div class="input-group">
							<span class="input-group-addon" id="direccion"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
				 			<input type="text" class="form-control" name="direccion" aria-describedby="direccion" maxlength="200" value="<?php echo set_value('direccion') ?>">
						</div>
						<?php echo form_error('direccion') ?>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="provincia">Provincia</label>
						<div class="input-group">
							<span class="input-group-addon" id="provincia"><i class="fa fa-globe" aria-hidden="true"></i></span>
							<?php echo form_dropdown('id_provincia', $provincias, set_value('id_provincia'), 'class="custom-select form-control"'); ?>
						</div>
						<?php echo form_error('id_provincia') ?>
					</div>
					<div class="form-group col-md-6">
						<label for="cp">Código postal</label>
						<div class="input-group">
							<span class="input-group-addon" id="cp"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
				 			<input type="text" class="form-control" name="cp" aria-describedby="cp" maxlength="5" value="<?php echo set_value('cp') ?>">
						</div>
						<?php echo form_error('cp') ?>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="usuario">Nombre de usuario</label>
						<div class="input-group">
							<span class="input-group-addon" id="usuario"><i class="fa fa-users" aria-hidden="true"></i></span>
				 			<input type="text" class="form-control" name="usuario" aria-describedby="usuario" maxlength="15" value="<?php echo set_value('usuario') ?>">
						</div>
						<?php echo form_error('usuario') ?>
					</div>
					<div class="form-group col-md-6">
						<label for="email">Correo electrónico</label>
						<div class="input-group">
							<span class="input-group-addon" id="email"><i class="fa fa-envelope" aria-hidden="true"></i></span>
				 			<input type="text" class="form-control" name="email" aria-describedby="email" maxlength="60" value="<?php echo set_value('email') ?>">
						</div>
						<?php echo form_error('email') ?>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="pass">Contraseña</label>
						<div class="input-group">
							<span class="input-group-addon" id="pass"><i class="fa fa-lock" aria-hidden="true"></i></span>
				 			<input type="password" class="form-control" name="pass" aria-describedby="pass" maxlength="15">
						</div>
						<?php echo form_error('pass') ?>
					</div>
					<div class="form-group col-md-6">
						<label for="conf_pass">Confirmar contraseña</label>
						<div class="input-group">
							<span class="input-group-addon" id="conf_pass"><i class="fa fa-lock" aria-hidden="true"></i></span>
				 			<input type="password" class="form-control" name="conf_pass" aria-describedby="conf_pass" maxlength="15">
						</div>
						<?php echo form_error('conf_pass') ?>
					</div>
				</div>
				<button type="submit" class="btn btn-primary btn-block">Confirmar registro</button>
			</form>
		</div>
	</div>
</div>