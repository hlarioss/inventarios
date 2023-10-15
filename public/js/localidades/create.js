var validator = $("#LocalidadForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		nombre:{
			required: true,
		},
		bodega_id:{
			required:true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el Nombre de la Localidad"
		},
		bodega_id:{
			required: "Por favor, seleccione la bodega"
		}
	}
});
function BorrarFormularioLocalidad() {
    $("#LocalidadForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonLocalidadModal").click(function(event) {
	event.preventDefault();
	if ($('#LocalidadForm').valid()) {
		
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').addClass('is-active');	
	var formData = $("#LocalidadForm").serialize();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenLocalidad').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			BorrarFormularioLocalidad();
			$('#modalLocalidad').modal("hide");
			Localidad_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Localidad Creada con Éxito!!');
			
		},
		error: function(errors) {
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#LocalidadForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalLocalidad').modal('show');
	}

	$('#modalLocalidad').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormularioLocalidad();
	});

	$('#modalLocalidad').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 