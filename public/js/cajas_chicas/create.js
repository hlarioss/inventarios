$(document).ready(function() {
	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

$.validator.addMethod("saldoDisponible", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: "/caja_chica/saldo",
		data: "total=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El monto ingresado es mayor que el saldo disponible");

//Egreso
var validator = $("#EgresoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		proveedor_id: {
			required : true
		},
		total: {
			required : true,
			saldoDisponible: true
		}
	},
	messages: {
		proveedor_id: {
			required: "Por favor, ingrese Proveedor"
		},
		total: {
			required: "Por favor, ingrese Total"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonEgreso").click(function(event) {
	if ($('#EgresoForm').valid()) {
		saveEgreso();
	} else {
		validator.focusInvalid();
	}
});

function saveEgreso(button) {
	$("#ButtonEgreso").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonEgreso"));
	l.start();
	var formData = $("#EgresoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenEgreso').val()},
		url: "/cajas_chicas/save/egreso",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/cajas_chicas" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}

//Ingreso
var validator = $("#IngresoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		descripcion: {
			required : true
		},
		total: {
			required : true
		},
		documento: {
			required : true
		}

	},
	messages: {
		descripcion: {
			required: "Por favor, ingrese descripcion"
		},
		total: {
			required: "Por favor, ingrese Total"
		},
		documento: {
			required: "Por favor, ingrese Documento"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonIngreso").click(function(event) {
	if ($('#IngresoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonIngreso").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonIngreso"));
	l.start();
	var formData = $("#IngresoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/cajas_chicas/save/ingreso",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/cajas_chicas" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}