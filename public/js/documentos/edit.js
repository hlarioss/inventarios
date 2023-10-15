var validator = $("#TipoClienteUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
		descuento: {
			required : true
		}
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de un tipo de cliente"
		},
		descuento: {
			required: "Por favor, ingrese el % de decuento del tipo de cliente"
		}
	}
});