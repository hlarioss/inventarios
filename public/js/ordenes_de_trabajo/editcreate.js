$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

var validator = $("#CreateUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		cliente_id: {
			required: true
		},
		vehiculo_id:{
			required: true
		},
		fecha_hora: {
			required : true
		},
		resp_recepcion: {
			required : true
		},

		fecha_prometida: {
			required : true
		}

	},
	messages: {
		cliente_id: {
			required: "Por favor, seleccione cliente"
		},
		vehiculo_id: {
			required: "Por favor, seleccione vehiculo"
		},
		fecha_hora: {
			required: "Por favor, ingrese fecha y hora"
		},
		resp_recepcion: {
			required: "Por favor, ingrese nombre responsable recepcion"
		},

		fecha_prometida: {
			required: "Por favor, ingrese fecha prometida"
		}
	}
});
