
var validator = $("#LocalidadUpdateForm").validate({
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
function cargarSelectBodegas(s_bodega_id){
	$('#bodega2_id').empty();
	$("#bodega2_id").append('<option value="" selected>Seleccione Bodega</option>');
	var bodega_id = s_bodega_id;
	$.ajax({
		type: "GET",
		url: "/bodegas/cargar", 
		dataType: "json",
		success: function(data){
			$.each(data,function(key, registro) {
				if(registro.id == bodega_id){
				$("#bodega2_id").append('<option value='+registro.id+' selected>'+registro.nombre+'</option>');
				
				}else{
				$("#bodega2_id").append('<option value='+registro.id+'>'+registro.nombre+'</option>');
				}		
			});
	
		},
		error: function(data) {
			alert('error');
		}
		});
	}

$('#modalUpdateLocalidad').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre = button.data('nombre');
	var bodega_id = button.data('bodega_id');


	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre']").val(nombre);
	modal.find(".modal-body input[name='bodega_id']").val(bodega_id);
	cargarSelectBodegas(bodega_id);

 }); 

function BorrarFormularioUpdate() {
    $("#LocalidadUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonLocalidadModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#LocalidadUpdateForm').valid()) {
		
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	var formData = $("#LocalidadUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenLocalidadEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			BorrarFormularioUpdate();
			$('#modalUpdateLocalidad').modal("hide");
			Localidad_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Localidad Editada con Éxito!!');
		},
		error: function(errors) {
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#LocalidadUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
       {
         $('#modalUpdateLocalidad').modal('show');
       }
    
       $('#modalUpdateLocalidad').on('hide.bs.modal', function(){
          window.location.hash = '#';
		  $("label.error").remove();
		  BorrarFormularioUpdate();
       });
    
       $('#modalUpdateLocalidad').on('shown.bs.modal', function(){
          window.location.hash = '#edit';
    
	   }); 
	   




