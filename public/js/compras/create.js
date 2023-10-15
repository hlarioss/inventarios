$(document).ready(function() {

	cargarSelectProveedor();

	$("#cantidad_ingreso").keypress(function(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode < 48 || charCode > 57)  return false;
		return true;
	});

	$("input[name='codigo_barra']").focusout(function() {
		var codigo = $("input[name='codigo_barra'] ").val();
		var url = "/productos/get/?data=" + codigo;
		$.getJSON( url , function ( result ) {
			if (result == 0 ) {
				$("input[name='nombre'] ").val("");
				$("input[name='producto_id'] ").val("");
			}
			else {
				$("input[name='nombre'] ").val(result[0].nombre);
				$("input[name='producto_id'] ").val(result[0].prod_id);
			}
		});
	});

	$("input[name='codigo_maquina']").focusout(function() {
		var codigo = $("input[name='codigo_maquina'] ").val();
		var url = "/maquinarias_equipo/get/?data=" + codigo;
		$.getJSON( url , function ( result ) {
			if (result == 0 ) {
				$("input[name='nombre_maquina'] ").val("");
				$("input[name='maquinaria_equipo_id'] ").val("");
			}
			else {
				$("input[name='nombre_maquina'] ").val(result[0].nombre_maquina);
				$("input[name='maquinaria_equipo_id'] ").val(result[0].maquina_id);
			}
		});
	});


	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});

	var validator = $("#submit-ingresoproducto").validate({
		ignore: [],
		onkeyup:false,
		rules: {
			fecha_ingreso: {
				required : true
			},
			serie_factura : {
				required : true
			},
			num_factura : {
				required : true
			},
			fecha_factura : {
				required : true
			},
			proveedor_id : {
				required : true,
			},
			tipo_pago_id : {
				required : true,
			}

		},
		messages: {
			fecha_ingreso : {
				required : "Por favor, seleccione la fecha de ingreso"
			},
			serie_factura : {
				required : "Por favor, ingrese la serie de la factura"
			},
			num_factura : {
				required : "Por favor, ingrese el numero de la factura"
			},
			fecha_factura : {
				required : "Por favor, seleccione la fecha de la factura"
			},
			proveedor_id : {
				required : "Por favor, seleccione al proveedor de la factura",
			},
			tipo_pago_id : {
				required : "Por favor, seleccione tipo de pago",
			}
		}
	});

});

//Funcion para cargar Proveedores asincronos
function cargarSelectProveedor(){
	$('#proveedor_id').empty();
	$("#proveedor_id").append('<option value="" selected>Seleccione Proveedor</option>');
	$.ajax({
		type: "GET",
		url: '/proveedores/cargar', 
		dataType: "json",
		success: function(data){
		  $.each(data,function(key, registro) {
			$("#proveedor_id").append('<option value='+registro.id+'>'+registro.nombre+'</option>');
		  });
		  	$('#proveedor_id').addClass('selectpicker');
            $('#proveedor_id').attr('data-live-search', 'true');
            $('#proveedor_id').selectpicker('refresh');    
		},
		error: function(data) {
		  alert('error');
		}
	  });
}