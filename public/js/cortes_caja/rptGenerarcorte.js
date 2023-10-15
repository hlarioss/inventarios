var validator = $("#ReporteForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		empleado_id: {
			required : true
        },
        fecha_final: {
			required : true
		}
	},
	messages: {
		empleado_id: {
			required: "Por favor, Seleccione un empleado"
        },
        fecha_final: {
			required: "Por favor, Seleccione la fecha Fecha"
        }
	}
});
