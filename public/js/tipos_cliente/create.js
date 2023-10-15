$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#TipoClienteForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
		descuento: {
			required : true
		},
		monto_mensual: {
			required: true

		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de un tipo de cliente"
		},
		descuento: {
			required: "Por favor, ingrese el % de decuento del tipo de cliente"
		},
		monto_mensual: {
			required: "Por favor, ingrese el monto mensual del tipo de cliente"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonTipoCliente").click(function(event) {
	if ($('#TipoClienteForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonTipoCliente").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonTipoCliente"));
	l.start();
	var formData = $("#TipoClienteForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/tipos_cliente/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/tipos_cliente" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}