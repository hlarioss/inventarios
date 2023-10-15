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

var validator = $("#ReporteProductoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		producto_id:{
			required: true
		},
		fecha_inicial: {
			required : true
        },
        fecha_final: {
			required : true
		}
	},
	messages: {
		producto_id: {
			required: "Por favor, Seleccione Producto"
        },
		fecha_inicial: {
			required: "Por favor, Seleccione Fecha inicial"
        },
        fecha_final: {
			required: "Por favor, Seleccione Fecha final"
        }
	}
});