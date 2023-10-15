$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

var validator = $("#IngresoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		precio_venta: {
			required : true
		},
		precio_compra: {
			required : true
		},
		cantidad: {
			required : true
		}
	},
	messages: {
		precio_venta: {
			required: "Por favor, ingrese precio de venta"
		},
		precio_compra: {
			required : "Por favor, ingrese precio de compra"
		},
		cantidad: {
			required: "Por favor, ingrese cantidad"
		}
	}
});