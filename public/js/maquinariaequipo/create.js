$.validator.addMethod("codigoUnico", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: "/codigo-disponible-maquina",
		data: "codigo_maquina=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El codigo ya está asignado a otra maquinaria registrada en el sistema");

var validator = $("#MaquinariaEquipoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre_maquina: {
			required : true
		},
		codigo_maquina:{
			required : true,
			codigoUnico: true
		},
		marca: {
			required : true
		},
		descripcion:{
			required : true
		}

	},
	messages: {
		nombre_maquina: {
			required: "Por favor, ingrese el nombre del Equipo"
		},
		marca: {
			required: "Por favor, Seleccione La marca del Equipo"
		},
		descripcion :{
			required :"Por favor ingrese la Descripcion del equipo"
		},
		codigo_maquina:{
			required:"Debe Ingresar un codigo de maquinaria"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonMaquinariaEquipo").click(function(event) {
	if ($('#MaquinariaEquipoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonMaquinariaEquipo").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonMaquinariaEquipo"));
	l.start();
	var formData = $("#MaquinariaEquipoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/maquinarias_equipo/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/maquinarias_equipo" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}