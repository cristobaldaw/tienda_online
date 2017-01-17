$(document).ready(function() {
	$(".btn-info").click(function() {
		$(this).next().slideToggle("slow", function() {
			var icono = $(this).prev().children(":first")
			if ($(this).is(":visible")) {
				icono.removeClass("fa-plus");
				icono.addClass("fa-minus");
				icono.parent().attr("title", "Ocultar información del producto");
			} else {
				icono.removeClass('fa-minus');
				icono.addClass('fa-plus');
				icono.parent().attr("title", "Mostrar información del producto");
			}
		});
	});
});