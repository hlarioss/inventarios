$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


$.validator.addMethod("marcaUnica", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: "/marcas/marcaDisponible",
		data: "nombre=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El nombre de esta marca ya está registrado en el sistema");


var validator = $("#MarcaForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true,
			marcaUnica: true
		},
		tipo_marca_id: {
			required : true
		},
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de una Marca"
		},
		tipo_marca_id: {
			required: "Por favor, seleccione tipo de marca"
		},
		
	}
});


$("#ButtonMarca").click(function(event) {
	if ($('#MarcaForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonMarca").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonMarca"));
	l.start();
	var formData = $("#MarcaForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenMarca').val()},
		url: "/marcas/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/marcas" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}

function BorrarFormularioMarca() {
    $("#MarcaForm :input").each(function () {
        $(this).val('');
	});
	$('#tipo_marca_id').val('');
	$('#tipo_marca_id').change();
}

$("#ButtonMarcaModal").click(function(event) {
	if ($('#MarcaForm').valid()) {
		saveModalMarca();
	} else {
		validator.focusInvalid();
	}
});

function saveModalMarca(button) {
	var l = Ladda.create(document.querySelector("#ButtonMarcaModal"));
	l.start();
	var formData = $("#MarcaForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenMarca').val()},
		url: "/marcas/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			cargarSelectMarca();

			if (window.location.pathname == '/vehiculos/new')
			{
				cargarSelectLineaMarca();
			}
			
			BorrarFormularioMarca();
			l.stop();
			$('#marcaModal').modal("hide");
			
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}