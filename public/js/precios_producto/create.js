$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#PrecioProductoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		precio_venta:{
			required: true
		},

		producto_id: {
			required : true
		}

	},
	messages: {
		precio_venta: {
			required: "Por favor, ingrese Precio de venta"
		},

		producto_id: {
			required: "Por favor, seleccione producto"
		}

	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonPrecioProducto").click(function(event) {
	if ($('#PrecioProductoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonPrecioProducto").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonPrecioProducto"));
	l.start();
	var formData = $("#PrecioProductoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/precios_producto/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/precios_producto" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}