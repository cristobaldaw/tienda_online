$(document).ready(function() {
	
	var base_url = "http://localhost/tienda/";

	$(".link-detalles").click(function(event) {
		event.preventDefault();
		var id_pedido = $(this).attr("id_pedido");
		var precio_pedido = 0;
		$("#table-modal").html("");
		$.ajax({
			type: "POST",
			url: base_url + "index.php/pedidos/lineas",
			data: { id_pedido: id_pedido },
			dataType: "json",
			success: function(linea) {
				console.log(linea);
				for (var i in linea) {
					$("#table-modal").append('\
						<tr>\
							<td class="row">\
								<div class="col-md-2"><a href="#"><img src="' + base_url + 'assets/img/' + linea[i].imagen + '.jpg" class="img-fluid"></a></div>\
								<div class="col-md-10"><h4><a href="#">' + linea[i].nombre + '</a></h4></div>\
							<td>\
							<td class="text-md-center">' + linea[i].precio + '</td>\
							<td class="text-md-center">' + linea[i].cantidad + '</td>\
							<td class="text-md-center">' + linea[i].precio_linea + '€</td>\
						</tr>');
					precio_pedido += parseFloat(linea[i].precio_linea);
				}
				$("#table-modal").append('\
					<tr class="text-md-center">\
						<td colspan="5" class="bg-info text-white"><strong>TOTAL: ' + precio_pedido + '€</strong></td>\
					</tr>');
				$('#modal').modal('show');
			}
		});
	});



	$(".link-cancelar").click(function(event) {
		event.preventDefault();
		var id_pedido = $(this).attr("id_pedido");
		$.ajax({
			url: base_url + "index.php/pedidos/cancelar/" + id_pedido
		}).done(function() {
			$("#cancelar" + id_pedido).hide();
			$("#estado" + id_pedido).html("Cancelado");
			FooterBajo();
		});
	});





	$(".btn-info").click(function() {
		$(this).next().slideToggle("slow", function() {
			var icono = $(this).prev().children(":first")
			icono.toggleClass('fa-plus fa-minus');
			if ($(this).is(":visible"))
				icono.parent().attr("title", "Ocultar información del producto");
			else
				icono.parent().attr("title", "Mostrar información del producto");
		});
	});

	$("#vaciar").click(Vaciar);

	$(".eliminar").click(function(event) {
		event.preventDefault();
		var id_prod = $(this).attr("id_prod");
		AjaxCarrito(function() {
			if ($(".fila_prod").length == 1) {
				// Si solo hay un producto se vacía el carrito
				Vaciar();
			} else {
				$("#fila" + id_prod).fadeOut("slow", function() {
					$.when($(this).remove()).then(function() {
						ActualizaCarrito();
						ActualizaTotal();
					});
					FooterBajo();
					AjaxCarrito("eliminar", id_prod);		
				});
			}
		}, "eliminar", id_prod);
	});

	$(".sube-cant").click(function(event) {
		event.preventDefault();
		var id_prod = $(this).attr("id_prod");
		AjaxCarrito(
			function () {
				var cantidad = parseInt($("#cantidad" + id_prod).html()) + 1;
				ActualizaLinea(id_prod, cantidad);
				ActualizaTotal();				
			}, "sube", id_prod);
	});

	$(".baja-cant").click(function(event) {
		event.preventDefault();
		var id_prod = $(this).attr("id_prod");
		var cantidad = parseInt($("#cantidad" + id_prod).html() - 1);
		if (cantidad > 0) {
			AjaxCarrito(function() {
				ActualizaLinea(id_prod, cantidad);
				ActualizaTotal();
			}, "baja", id_prod);
		}
	});

	function ActualizaLinea(id_prod, cantidad) {
		var precio = parseFloat($(".precio" + id_prod).html());
		$("#cantidad" + id_prod).html(cantidad);
		$("#subtotal" + id_prod).html(cantidad * precio);
		ActualizaCarrito();
	}

	function ActualizaTotal() {
		var total = 0;
		$(".subtotal").each(function() {
			total += parseFloat($(this).html());
		});
		$("#total").html(total);
	}

	function ActualizaCarrito() {
		var total = 0;
		$(".cantidad").each(function() {
			total += parseInt($(this).html());
		});
		$("#total_prods").html(total);
	}

	function Vaciar() {
		AjaxCarrito(function() {
			$("tbody, tfoot").fadeOut("slow", function() {
				$(this).remove();
				FooterBajo();
			});
			$("<tbody></tbody>").appendTo("table");
			$('<tr><td colspan="5" class="text-md-center">No hay productos en el carrito</td></tr>').appendTo("tbody");
			$("#total_prods").html(0);
		}, "vaciar");
	}

	function AjaxCarrito(js, funcion, id_prod = "") {
		$.ajax({
			url: base_url + "index.php/carrito/" + funcion + "/" + id_prod
		}).done(js);
	}

	function FooterBajo() {
		var docHeight = $(window).height();
		var footerHeight = $("#footer").height();
		var footerTop = $("#footer").position().top + footerHeight;
		if (footerTop < docHeight) {
			$("#footer").css("margin-top", 10+ (docHeight - footerTop) + "px");
		}
	}

});