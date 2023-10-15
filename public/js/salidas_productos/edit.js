$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

var validator = $("#SalidaUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		tipo_salida_id: {
			required : true
		},
		cantidad_salida: {
			required : true
		}
	},
	messages: {
		tipo_salida_id: {
			required : "Por favor, seleccione tipo de salida"
		},
		cantidad_salida: {
			required: "Por favor, ingrese cantidad de salida"
		}
	}
});