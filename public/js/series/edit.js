$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

function ComprobarDatos() {
    var serie = $("input[name='serie'] ").val();
	var inicio = $("input[name='inicio'] ").val();
	var fin = $("input[name='fin']").val();
	var serie_id = $("input[name='serie_id']").val();

    $.ajax({
        type: "GET",
        async: false,
        url: "/series/rangoDisponible-edit",
        data: {"serie" : serie, "inicio" : inicio, "fin" : fin, "serie_id" : serie_id}, 
        dataType: "json",
        success: function(result) {
            if (result == true){
                $("input[name='inicio'] ").after("<label class='error'>El rango ingresado es menor al de la ultima resolucion</label>");
				$('#ButtonSerie').attr("disabled", true);
            }
            else{
                $('#ButtonSerie').attr("disabled", false);
                $(".error").remove();
            }
        }
    });
}

$("#inicio").focusout(function () {
    ComprobarDatos();
});

$.validator.addMethod("finMayor", function(value, element) {
	var valid = false;
	var inicio = $("input[name='inicio'] ").val();

	if (value > inicio )
	{
		valid = true;
		return valid;
	}

	else{
		return valid;
	}
	
}, "El numero ingresado debe ser mayor al de inicio");

var validator = $("#SerieUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		resolucion:{
			required: true,
		},
		serie: {
			required : true
		},
		documento_id: {
			required : true
		},
		inicio:{
			required: true
		},
		fin:{
			required : true,
			finMayor: true
		},
		fecha_resolucion:{
			required: true
		},
		fecha_vencimiento:{
			required: true
		},
		estado_id:{
			required:true
		},

	},
	messages: {
		resolucion:{
			required: "Debe ingresar El Número de Resolución",
		},

		serie: {
			required : "Debe Ingresar La Serie"
		},

		documento_id: {
			required : "Seleccione Un Documento"
		},
		inicio:{
			required: "Debe Ingresar un número de Inicio"
		},
		fin:{
			required : "Debe Ingresar un número de Fin"
		},
		fecha_resolucion:{
			required: "ingrese La Fecha de Autorizacion de Resolucion"
		},
		fecha_vencimiento:{
			required: "Seleccione La Fecha de Vencimiento"
		},
		estado_id:{
			required:"Debe seleccionar el estado"
		},
	

	}
});

