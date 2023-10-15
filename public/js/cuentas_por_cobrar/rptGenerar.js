var validator = $("#ReporteForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		cliente_id: {
			required : true
		},
		fecha_inicial: {
			required : true
        },
        fecha_final: {
			required : true
		}
	},
	messages: {
		cliente_id: {
			required: "Por favor, Seleccione Cliente"
		},
		fecha_inicial: {
			required: "Por favor, Seleccione Fecha inicial"
        },
        fecha_final: {
			required: "Por favor, Seleccione Fecha final"
        }
	}
});