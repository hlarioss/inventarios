$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

var validator = $("#ManttoEquipoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		descripcion: {
			required : true,
			
		},
		maquinaria_id: {
			required : true,
			
		},
		proveedor_id: {
			required:true,
		},
		fecha_servicio:{
			required:true,
		}

	},
	messages: {
		descripcion: {
			required: "Por favor, ingrese la descripcion del mantenimiento"
		},
		maquinaria_id: {
			required: "Por favor, Seleccione la maquinaria a la que se le realizo el mantenimiento"
		},
		proveedor_id: {
			required:" Seleccione el Proveedor encargado de el mantenimiento",
		},
		fecha_servicio:{
			required: "Debe ingresar una Fecha",
		}
	}
});
