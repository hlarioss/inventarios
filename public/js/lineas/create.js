$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});

});

$.validator.addMethod("lineaUnica", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: "/lineas/lineaDisponible",
		data: "linea=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El nombre de esta marca ya está registrado en el sistema");

var validator = $("#LineaForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		linea: {
			required : true,
			lineaUnica : true
		},
		marca_id: {
			required : true
		},
	},
	messages: {
		linea: {
			required: "Por favor, ingrese el nombre de Linea"
		},
		marca_id: {
			required: "Por favor, seleccione la marca"
		},
		
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonLinea").click(function(event) {
	if ($('#LineaForm').valid()) {
		saveLinea();
	} else {
		validator.focusInvalid();
	}
});

function saveLinea(button) {
	$("#ButtonLinea").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonLinea"));
	l.start();
	var formData = $("#LineaForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenLinea').val()},
		url: "/lineas/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/lineas" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}

function cargarSelectLineaMarca(){
    $('#marca_id_linea').empty();
    $("#marca_id_linea").append('<option value="" selected>Seleccione Marca</option>');
    $.ajax({
        type: "GET",
        url: '/marcas/cargar', 
        dataType: "json",
        success: function(data){
          $.each(data,function(key, registro) {
            $("#marca_id_linea").append('<option value='+registro.id+'>'+registro.nombre+'</option>');
          });
            $('#marca_id_linea').addClass('selectpicker');
            $('#marca_id_linea').attr('data-live-search', 'true');
            $('#marca_id_linea').selectpicker('refresh');   
        },
        error: function(data) {
          alert('error');
        }
      });
}

function BorrarFormularioLinea() {
    $("#LineaForm :input").each(function () {
        $(this).val('');
	});
	$('#marca_id_linea').val('');
	$('#marca_id_linea').change();
}

$("#ButtonLineaModal").click(function(event) {
	if ($('#LineaForm').valid()) {
		saveModalLinea();
	} else {
		validator.focusInvalid();
	}
});

function saveModalLinea(button) {
	var l = Ladda.create(document.querySelector("#ButtonLineaModal"));
	l.start();
	var formData = $("#LineaForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenLinea').val()},
		url: "/lineas/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			changeLinea();
			BorrarFormularioLinea();
			l.stop();
			$('#lineaModal').modal("hide");
			
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}