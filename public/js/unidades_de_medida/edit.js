var validator = $("#TipoVehiculoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
		cantidad: {
			required : true
		},
		equivalente: {
			required : true
		},
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de un tipo de vehiculo"
		},
		cantidad: {
			required: "Por favor, ingrese la cantidad"
		},
		equivalente: {
			required: "Por favor, ingrese unidad de medida equivalente"
		},
	}
});