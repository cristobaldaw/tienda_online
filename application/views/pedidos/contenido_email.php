<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<style>
		body {
			text-align: center;
		}
		table {
			margin: auto;
		}
		.header {
			background-color: #333;
			color: white;
		}
		.footer {
			background-color: blue;
			color: white;
		}
	</style>
</head>
<body>
	<h1>Información del pedido</h1>
	<p>Nombre completo: <?php echo $datos_usuario['nombre'] . ' ' . $datos_usuario['apellidos'] ?> </p>
	<p>Dirección: <?php echo $datos_usuario['direccion'] ?></p>
	<p>Provincia: <?php echo $provincia ?></p>
	<p>Fecha: <?php echo date('d/m/Y') ?></p>
	<table>
		<tr class="header">
			<th class="text-md-center">Nombre</th>
			<th class="text-md-center">Precio</th>
			<th class="text-md-center">Cantidad</th>
			<th class="text-md-center">Subtotal</th>
		</tr>
		<?php foreach ($datos_linea as $linea): ?>
			<tr>
				<td><?php echo $linea['nombre'] ?></td>
				<td><?php echo $linea['precio'] ?></td>
				<td><?php echo $linea['cantidad'] ?></td>
				<td><?php echo ($linea['precio'] * $linea['cantidad']) ?></td>
			</tr>
			<?php $precio_final += $linea['precio'] * $linea['cantidad'] ?>
		<?php endforeach ?>
		<tr class="footer">
			<th colspan="4">TOTAL: <?php echo $precio_final ?>€</th>
		</tr>
	</table>
</body>
</html>