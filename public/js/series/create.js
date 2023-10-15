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

    $.ajax({
        type: "GET",
        async: false,
        url: "/series/rangoDisponible",
        data: {"serie" : serie, "inicio" : inicio, "fin" : fin}, 
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

$("input[name='serie'] ").focusout(function () {
	$("#inicio").attr("disabled", false);
});

$("input[name='inicio'] ").focusout(function () {
	if ($('.error').text() == "")
	{
		$("input[name='fin']").attr("disabled", false);
	}

	else
	{
		$("input[name='fin']").attr("disabled", true);
	}
	
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

var validator = $("#SerieForm").validate({
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
			finMayor : true
		},
		fecha_resolucion:{
			required: true
		},
		fecha_vencimiento:{
			required: true
		}

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
		}
	

	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonSerie").click(function(event) {
	if ($('#SerieForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonSerie").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonSerie"));
	l.start();
	var formData = $("#SerieForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/series/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/series" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}