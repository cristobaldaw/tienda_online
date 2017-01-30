$(document).ready(function() {
	
	var base_url = "http://localhost/tienda/index.php/";

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
			url: base_url + "carrito/" + funcion + "/" + id_prod
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

	$("#prueba").click(function() {
		ActualizaTotal();
	});

});