var validator = $("#DetalleUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		costo: {
			required : true
		},
		cantidad: {
			required : true
		},
		producto_id:{
			required: true
		},
		maquinaria_equipo_id: {
			required : true
		}
	},
	messages: {
		costo: {
			required: "Por favor, ingrese el costo"
		},
		cantidad: {
			required: "Por favor, ingrese la cantidad"
		},
		producto_id: {
			required: "Por favor, seleccione producto"
		},
		maquinaria_equipo_id: {
			required: "Por favor, Seleccione maquinaria"
		}
	}
});

$("input[name='cantidad']").focusout(function() {
    var cantidad = $("input[name='cantidad']").val();
    var costo = $("input[name='costo']").val();

    if(cantidad == ""){
        cantidad = 0;
    }

    if(costo == ""){
        costo = 0;
    }

    $("input[name='subtotal']").val(costo * cantidad);

});

$("input[name='costo']").focusout(function() {
    var cantidad = $("input[name='cantidad']").val();
    var costo = $("input[name='costo']").val();

    if(cantidad == ""){
        cantidad = 0;
    }

    if(costo == ""){
        costo = 0;
    }

    $("input[name='subtotal']").val(costo * cantidad);

});