$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#TipoProveedorForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de un tipo de proveedor"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonTipoProveedor").click(function(event) {
	if ($('#TipoProveedorForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonTipoProveedor").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonTipoProveedor"));
	l.start();
	var formData = $("#TipoProveedorForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/tipos_proveedor/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/tipos_proveedor" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}