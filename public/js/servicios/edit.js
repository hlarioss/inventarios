var validator = $("#ServicioUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
		precio: {
			required : true
		},
		precio_costo: {
			required : true
		},
		tipo_servicio_id:{
			required: true
		},
		codigo: {
			required : true
		}
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de un servicio"
		},
		precio: {
			required: "Por favor, ingrese el precio venta sin mano de obra"
		},
		precio_costo: {
			required: "Por favor, ingrese el precio costo sin mano de obra"
		},
		tipo_servicio_id: {
			required: "Por favor, seleccione tipo de servicio"
		},
		codigo: {
			required: "Por favor, ingrese codigo"
		}
	}
});