$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#TipoVehiculoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		}
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de un tipo de vehiculo"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonTipoVehiculo").click(function(event) {
	if ($('#TipoVehiculoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonTipoVehiculo").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonTipoVehiculo"));
	l.start();
	var formData = $("#TipoVehiculoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/tipos_vehiculo/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/tipos_vehiculo" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}