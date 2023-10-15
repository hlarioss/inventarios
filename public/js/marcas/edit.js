var validator = $("#MarcaUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
		tipo_marca_id: {
			required : true
		},
		},
	messages: {
		nombre: {
			required: "Por favor, ingrese una Marca de Vehiculo"
		},
		tipo_marca_id: {
			required: "Por favor, seleccione tipoo de marca"
		},
	}
});