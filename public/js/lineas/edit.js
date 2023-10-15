var validator = $("#LineaUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		linea: {
			required : true
		},
		marca_id: {
			required : true
		},
		},
	messages: {
		linea: {
			required: "Por favor, ingrese una Linea de Vehiculo"
		},
		marca_id: {
			required: "Por favor, seleccione una Marca"
		},
	}
});