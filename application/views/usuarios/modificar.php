<div class="container">
	<div class="card">
		<div class="card-block">
			<h1 class="text-md-center card-title">Modificar datos de mi cuenta</h1>
			<form method="post">
				<div class="row">
					<div class="form-group col-md-6">
						<label for="nombre">Nombre</label>
						<div class="input-group">
							<span class="input-group-addon" id="nombre"><i class="fa fa-user" aria-hidden="true"></i></span>
				 			<input type="text" class="form-control" name="nombre" aria-describedby="nombre" maxlength="45" value="<?php echo set_value('nombre', $datos['nombre']) ?>">
						</div>
						<?php echo form_error('nombre') ?>
					</div>
					<div class="form-group col-md-6">
						<label for="apellidos">Apellidos</label>
						<div class="input-group">
							<span class="input-group-addon" id="apellidos"><i class="fa fa-user" aria-hidden="true"></i></span>
				 			<input type="text" class="form-control" name="apellidos" aria-describedby="apellidos" maxlength="100" value="<?php echo set_value('apellidos', $datos['apellidos']) ?>">
						</div>
						<?php echo form_error('apellidos') ?>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="direccion">Dirección</label>
						<div class="input-group">
							<span class="input-group-addon" id="direccion"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
				 			<input type="text" class="form-control" name="direccion" aria-describedby="direccion" maxlength="200" value="<?php echo set_value('direccion', $datos['direccion']) ?>">
						</div>
						<?php echo form_error('direccion') ?>
					</div>
					<div class="form-group col-md-6">
						<label for="provincia">Provincia</label>
						<div class="input-group">
							<span class="input-group-addon" id="provincia"><i class="fa fa-globe" aria-hidden="true"></i></span>
							<?php echo form_dropdown('id_provincia', $provincias, set_value('id_provincia', $datos['id_provincia']), 'class="custom-select form-control"'); ?>
						</div>
						<?php echo form_error('id_provincia') ?>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="email">Correo electrónico</label>
						<div class="input-group">
							<span class="input-group-addon" id="email"><i class="fa fa-envelope" aria-hidden="true"></i></span>
				 			<input type="text" class="form-control" name="email" aria-describedby="email" maxlength="60" value="<?php echo set_value('email', $datos['email']) ?>">
						</div>
						<?php echo form_error('email') ?>
					</div>
					<div class="form-group col-md-6">
						<label for="cp">Código postal</label>
						<div class="input-group">
							<span class="input-group-addon" id="cp"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
				 			<input type="text" class="form-control" name="cp" aria-describedby="cp" maxlength="5" value="<?php echo set_value('cp', $datos['cp']) ?>">
						</div>
						<?php echo form_error('cp') ?>
					</div>
				</div>
				<div class="text-md-right">
					<a href="<?php echo base_url('index.php/usuarios/preferencias') ?>" class="btn btn-secondary boton">Cancelar</a>
					<button type="submit" class="btn btn-primary">Modificar</button>
				</div>
			</form>
		</div>
	</div>
</div>