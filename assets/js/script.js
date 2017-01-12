$(document).ready(function() {
	var icono = $(".fa-search-plus");
	$(".btn-info").click(function() {
		$(this).next().slideToggle("slow", function() {
			var icono = $(this).prev().children(":first")
			if ($(this).is(":visible")) {
				icono.removeClass("fa-search-plus");
				icono.addClass("fa-search-minus");
				icono.parent().attr("title", "Ocultar información del producto");
			} else {
				icono.removeClass('fa-search-minus');
				icono.addClass('fa-search-plus');
				icono.parent().attr("title", "Mostrar información del producto");
			}
		});
	});
});