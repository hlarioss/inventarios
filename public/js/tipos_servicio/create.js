$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#TipoServicioForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de un tipo de servicio"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonTipoServicio").click(function(event) {
	if ($('#TipoServicioForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonTipoServicio").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonTipoServicio"));
	l.start();
	var formData = $("#TipoServicioForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/tipos_servicio/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/tipos_servicio" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}