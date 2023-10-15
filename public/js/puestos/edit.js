var validator = $("#PuestoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
		sueldo: {
			required : true
		}
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de un Puesto"
		},
		sueldo: {
			required: "Por favor, ingrese el sueldo"
		}
	}
});