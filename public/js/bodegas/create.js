var validator = $("#BodegaForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		nombre:{
			required: true,
		},
		direccion:{
			required:true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el Nombre de la bodega"
		},
		direccion:{
			required: "Por favor, ingrese la direccion"
		}
	}
});
function BorrarFormularioBodega() {
    $("#BodegaForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonBodegaModal").click(function(event) {
	event.preventDefault();
	if ($('#BodegaForm').valid()) {
		
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').addClass('is-active');	
	var formData = $("#BodegaForm").serialize();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenBodega').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			BorrarFormularioBodega();
			$('#modalBodega').modal("hide");
			Bodega_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Bodega Creada con Éxito!!');
			
		},
		error: function(errors) {
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#BodegaForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalBodega').modal('show');
	}

	$('#modalBodega').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormularioBodega();
	});

	$('#modalBodega').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 