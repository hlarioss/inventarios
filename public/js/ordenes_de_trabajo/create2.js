
var db = {};

window.db = db;
db.detalle = [];

$("#ButtonOrdenDeTrabajo2").click(function(event) {
		saveDescription();
		
	
});

//funcion guardar descripcion
function saveDescription(button) {
	$("#ButtonOrdenDeTrabajo2").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonOrdenDeTrabajo2"));
	l.start();
	var formData = $("#OrdenDeTrabajoForm2").serialize();
	var id = $('#orden_id').val();
	console.log(id);
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/ordenes_de_trabajo/save2",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/ordenes_de_trabajo/create3/" +id 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}