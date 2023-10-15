$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#PuestoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
		sueldo: {
			required : true
		}
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de un Puesto"
		},
		sueldo: {
			required: "Por favor, ingrese el Sueldo"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonPuesto").click(function(event) {
	if ($('#PuestoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonPuesto").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonPuesto"));
	l.start();
	var formData = $("#PuestoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/puestos/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/puestos"
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}