$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});

});

function cargarSelectCliente(){
    $('#cliente_id').empty();
    $("#cliente_id").append('<option value="" selected>Seleccione Cliente</option>');
    $.ajax({
        type: "GET",
        url: '/clientes/cargar', 
        dataType: "json",
        success: function(data){
          $.each(data,function(key, registro) {
            $("#cliente_id").append('<option value='+registro.id+'>'+registro.nombres+' '+registro.apellidos+'</option>');
          });
            $('#cliente_id').addClass('selectpicker');
            $('#cliente_id').attr('data-live-search', 'true');
            $('#cliente_id').selectpicker('refresh');   
        },
        error: function(data) {
          alert('error');
        }
      });
}

function cargarSelectVehiculo(){
    $('#vehiculo_id').empty();
    $("#vehiculo_id").append('<option value="" selected>Seleccione Vehiculo</option>');
    $.ajax({
        type: "GET",
        url: '/vehiculos/cargar', 
        dataType: "json",
        success: function(data){
          $.each(data,function(key, registro) {
            $("#vehiculo_id").append('<option value='+registro.id+'>'+registro.placa+'</option>');
          });
            $('#vehiculo_id').addClass('selectpicker');
            $('#vehiculo_id').attr('data-live-search', 'true');
            $('#vehiculo_id').selectpicker('refresh');   
        },
        error: function(data) {
          alert('error');
        }
      });
}

function changevehiculo() {
	var cliente_id = $("#cliente_id").val();
	
	var url = "/vehiculo/obtener/" + cliente_id ;
	if (cliente_id != "") {
			$.getJSON( url , function ( result ) {
		
		var selector =''
		for (let index = 0; index < result.length; index++) {
			selector += '<option value="'+result[index].id+'">'+result[index].placa+'</option>';	
		}
		selector += ""
		
		$('#vehiculo_id').html(selector).fadeIn();
			});
	}
}
	

$("#cliente_id").change(function () {
	changevehiculo();
});

var validator = $("#OrdenDeTrabajoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		cliente_id: {
			required: true
		},
		vehiculo_id:{
			required: true
		},
		fecha_hora: {
			required : true
		},
		resp_recepcion: {
			required : true
		},

		fecha_prometida: {
			required : true
		}

	},
	messages: {
		cliente_id: {
			required: "Por favor, seleccione cliente"
		},
		vehiculo_id: {
			required: "Por favor, seleccione vehiculo"
		},
		fecha_hora: {
			required: "Por favor, ingrese fecha y hora"
		},
		resp_recepcion: {
			required: "Por favor, ingrese nombre responsable recepcion"
		},

		fecha_prometida: {
			required: "Por favor, ingrese fecha prometida"
		}
	}
});
