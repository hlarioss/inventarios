var validator = $("#ProductoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		codigo_barra: {
			required : true
		},
		nombre: {
			required : true
		},
		minimo: {
			required : true
		},
		marca_id:{
			required : true
		},
		medida_id:{
			required : true
		},
		localidad_id:{
			required : true
		}
	},
	messages: {
		codigo_barra: {
			required: "Por favor, ingrese el codigo de barra del producto"
		},
		nombre: {
			required : "Por favor, ingrese el nombre del producto"
		},
		minimo: {
			required : "Por favor, ingrese el stock minimo del producto"
		},
		marca_id:{
			required : "debe seleccionar La Marca del Producto"
		},
		medida_id:{
			required : "Debe seleccionar una Unidad de medida del Producto"
		},
		localidad_id:{
			required : "Debe seleccionar una Ubicación del Producto"
		}
	}
});
