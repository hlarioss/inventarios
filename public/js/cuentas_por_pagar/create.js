$(document).ready(function() {
	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});
//Nota de CREDITO
var validator = $("#NotaCreditoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		proveedor_id: {
			required : true
		},
		total: {
			required : true
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

$("#ButtonNotaCredito").click(function(event) {
	if ($('#NotaCreditoForm').valid()) {
		saveCredito();
	} else {
		validator.focusInvalid();
	}
});

function saveCredito(button) {
	$("#ButtonNotaCredito").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonNotaCredito"));
	l.start();
	var formData = $("#NotaCreditoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenCredito').val()},
		url: "/cuentas_por_pagar/save/notacredito",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/cuentas_por_pagar"
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}

//Nota de DEBITO
var validator = $("#NotaDebitoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		proveedor_id: {
			required : true
		},
		total: {
			required : true
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

$("#ButtonNotaDebito").click(function(event) {
	if ($('#NotaDebitoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonNotaDebito").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonNotaDebito"));
	l.start();
	var formData = $("#NotaDebitoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/cuentas_por_pagar/save/notadebito",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/cuentas_por_pagar" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}