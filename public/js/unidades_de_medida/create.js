$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#UnidadDeMedidaForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		descripcion: {
			required : true
		},
		cantidad: {
			required : true
		},
		equivalente: {
			required : true
		}
	},
	messages: {
		descripcion: {
			required: "Por favor, ingrese la descripcion de la unidad de medida"
		},
		cantidad: {
			required: "Por favor, ingrese la cantidad de la unidad de medida"
		},
		equivalente: {
			required: "Por favor, ingrese unidad de medida equivalente"
		},
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonUnidadDeMedida").click(function(event) {
	if ($('#UnidadDeMedidaForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonUnidadDeMedida").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonUnidadDeMedida"));
	l.start();
	var formData = $("#UnidadDeMedidaForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/unidades_de_medida/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/unidades_de_medida" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}