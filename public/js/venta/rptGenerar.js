var validator = $("#ReporteForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		fecha_inicial: {
			required : true
        },
        fecha_final: {
			required : true
		}
	},
	messages: {
		fecha_inicial: {
			required: "Por favor, Seleccione Fecha inicial"
        },
        fecha_final: {
			required: "Por favor, Seleccione Fecha final"
        }
	}
});