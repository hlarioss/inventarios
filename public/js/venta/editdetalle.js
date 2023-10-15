var validator = $("#DetalleUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		cantidad: {
			required : true
		},
		precio_venta: {
			required : true
		}
	},
	messages: {
		cantidad: {
			required: "Por favor, ingrese la cantidad"
		},
		precio_venta: {
			required: "Por favor, Ingrese precio de venta"
		}
	}
});

$("input[name='cantidad']").focusout(function() {
    var cantidad = $("input[name='cantidad']").val();
    existencia=$("input[name='existencias']").val();
    if( existencia==undefined ){
        var precio_venta = $("input[name='precio_venta']").val();

        if(cantidad == ""){
            cantidad = 0;
        }

        if(precio_venta == ""){
            precio_venta = 0;
        }

        $("input[name='subtotal_venta']").val(precio_venta * cantidad);
    }
    else{
        var cantidads = $("input[name='cantidad_ant']").val();
        diferencia=cantidad-cantidads;
        if (parseInt($("input[name='existencias'] ").val()) >=diferencia )
        {
            var precio_venta = $("input[name='precio_venta']").val();

            if(cantidad == ""){
                cantidad = 0;
            }

            if(precio_venta == ""){
                precio_venta = 0;
            }

            $("input[name='subtotal_venta']").val(precio_venta * cantidad);
            $('#ButtonUpdateDetalle').prop('disabled',false);
        }
        else{
            $('#ButtonUpdateDetalle').prop('disabled',true);
            alert("No se puede realizar la venta, revise las existencias del producto");
        }
    }
});

$("input[name='precio_venta']").focusout(function() {
    var cantidad = $("input[name='cantidad']").val();
    var precio_venta = $("input[name='precio_venta']").val();

    if(cantidad == ""){
        cantidad = 0;
    }

    if(precio_venta == ""){
        precio_venta = 0;
    }

    $("input[name='subtotal_venta']").val(precio_venta * cantidad);

});