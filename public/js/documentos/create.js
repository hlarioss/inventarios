$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#DocumentoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		descripcion: {
			required : true
		}

	},
	messages: {
		descripcion: {
			required: "Por favor, ingrese descripcion de documento"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonDocumento").click(function(event) {
	if ($('#DocumentoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonDocumento").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonDocumento"));
	l.start();
	var formData = $("#DocumentoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/documentos/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/documentos" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}