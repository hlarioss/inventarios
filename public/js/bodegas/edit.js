
var validator = $("#BodegaUpdateForm").validate({
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
			required: "Por favor, ingrese el nombre"
		},
		direccion:{
			required: "Por favor, ingrese la direccion"
		}
	}
});

$('#modalUpdateBodega').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre = button.data('nombre');
	var direccion = button.data('direccion');

	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre']").val(nombre);
	modal.find(".modal-body input[name='direccion']").val(direccion);

 }); 

function BorrarFormularioUpdate() {
    $("#BodegaUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonBodegaModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#BodegaUpdateForm').valid()) {
		
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	var formData = $("#BodegaUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenBodegaEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			BorrarFormularioUpdate();
			$('#modalUpdateBodega').modal("hide");
			Bodega_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Bodega Editada con Éxito!!');
		},
		error: function(errors) {
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#BodegaUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
       {
         $('#modalUpdateBodega').modal('show');
       }
    
       $('#modalUpdateBodega').on('hide.bs.modal', function(){
          window.location.hash = '#';
		  $("label.error").remove();
		  BorrarFormularioUpdate();
       });
    
       $('#modalUpdateBodega').on('shown.bs.modal', function(){
          window.location.hash = '#edit';
    
	   }); 
	   




