<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/estilos.css') ?>">
	<script src="<?php echo base_url('assets/js/script.js') ?>"></script>
	<title><?php echo $title ?></title>
	<script> // Necesario para colocar el footer al final de la página
		$(document).ready(function() {
			var docHeight = $(window).height();
			var footerHeight = $('#footer').height();
			var footerTop = $('#footer').position().top + footerHeight;
			if (footerTop < docHeight) {
				$('#footer').css('margin-top', 10+ (docHeight - footerTop) + 'px');
			}
		});
	</script>
</head>
<body>
	<nav class="navbar navbar-toggleable-md sticky-top navbar-inverse bg-inverse">
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="<?php echo base_url() ?>">SmartShop</a>
		<div class="collapse navbar-collapse" id="navbarColor02">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categorías</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<?php foreach ($categorias as $cat): ?>
							<a class="dropdown-item" href="<?php echo base_url("index.php/productos/categoria/$cat[id]") ?>"><?php echo $cat['nombre'] ?></a>
						<?php endforeach ?>
					</div>
				</li>
			</ul>
			<ul class="navbar-nav float-md-right">
				<?php if ($this->session->has_userdata('usuario')): ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Bienvenido, <?php echo $this->session->userdata('usuario'); ?></a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="<?php echo base_url('index.php/usuarios/preferencias') ?>">Preferencias de mi cuenta</a>
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logout">Cerrar sesión</a>
						</div>
					</li>
				<?php else: ?>
					<li class="nav-item"><a href="<?php echo base_url('index.php/usuarios/registro') ?>" class="nav-link">Registrarse</a></li>
					<li class="nav-item"><a href="<?php echo base_url('index.php/usuarios/login') ?>" class="nav-link">Iniciar sesión</a></li>					
				<?php endif ?>
				<li class="nav-item"><a href="<?php echo base_url('index.php/carrito') ?>" class="nav-link"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Mi carrito (<span id="total_prods"><?php echo $this->lib_carrito->total_prods() ?></span>)</a></li>
			</ul>
		</div>
	</nav>

	<?php if ($this->session->has_userdata('usuario')): ?>
		<!-- Modal -->
		<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header text-md-center">
						<h4 class="modal-title" id="exampleModalLabel">¿Está seguro de que desea cerrar sesión?</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-footer">
						<a href="<?php echo base_url('index.php/usuarios/logout') ?>" class="btn btn-primary">Cerrar sesión</a>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
	<?php endif ?>