$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});



var validator = $("#ManttoEquipoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		descripcion: {
			required : true,
			
		},
		maquinaria_id: {
			required : true,
			
		},
		proveedor_id: {
			required:true,
		},
		fecha_servicio:{
			required:true,
		}

	},
	messages: {
		descripcion: {
			required: "Por favor, ingrese la descripcion del mantenimiento"
		},
		maquinaria_id: {
			required: "Por favor, Seleccione la maquinaria a la que se le realizo el mantenimiento"
		},
		proveedor_id: {
			required:" Seleccione el Proveedor encargado de el mantenimiento",
		},
		fecha_servicio:{
			required: "Debe ingresar una Fecha",
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonManttoEquipo").click(function(event) {
	if ($('#ManttoEquipoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonManttoEquipo").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonManttoEquipo"));
	l.start();
	var formData = $("#ManttoEquipoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/mantto_equipo/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/mantto_equipo" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}