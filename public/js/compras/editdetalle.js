var validator = $("#DetalleUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		precio_compra: {
			required : true
		},
		existencias: {
			required : true
		},
		producto_id:{
			required: true
		},
		maquinaria_equipo_id: {
			required : true
		},

	},
	messages: {
		precio_compra: {
			required: "Por favor, ingrese el precio de compra"
		},
		existencias: {
			required: "Por favor, ingrese la existencias"
		},
		producto_id: {
			required: "Por favor, seleccione producto"
		},
		maquinaria_equipo_id: {
			required: "Por favor, Seleccione maquinaria"
		},
	}
});

$("input[name='existencias']").focusout(function() {
    var existencias = $("input[name='existencias']").val();
    var precio_compra = $("input[name='precio_compra']").val();

    if(existencias == ""){
        existencias = 0;
    }

    if(precio_compra == ""){
        precio_compra = 0;
    }

    $("input[name='subtotal']").val(precio_compra * existencias);

});

$("input[name='precio_compra']").focusout(function() {
    var existencias = $("input[name='existencias']").val();
    var precio_compra = $("input[name='precio_compra']").val();

    if(existencias == ""){
        existencias = 0;
    }

    if(precio_compra == ""){
        precio_compra = 0;
    }

    $("input[name='subtotal']").val(precio_compra * existencias);

});