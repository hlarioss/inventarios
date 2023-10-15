
var db = {};

window.db = db;
db.detalle = [];

$("#ButtonOrdenDeTrabajo3").click(function(event) {
		
        saveGolpes();
        saveRayones();
	
});
//funcion guardar golpes
function saveGolpes(button) {
	$("#ButtonOrdenDeTrabajo2").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonOrdenDeTrabajo3"));
	l.start();
	var formData = $("#OrdenDeTrabajoFormGolpe").serialize();
	var id = $('#orden_id').val();
	console.log(id);
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/ordenes_de_trabajo/{{id}}/golpes",
		data: formData,
        dataType: "json",
        always: function() {
			l.stop();
		}	
	});
}
//funcion guardar golpes
function saveRayones(button) {
	$("#ButtonOrdenDeTrabajo2").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonOrdenDeTrabajo3"));
	l.start();
	var formData = $("#OrdenDeTrabajoFormRayon").serialize();
	var id = $('#orden_id').val();
	console.log(id);
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/ordenes_de_trabajo/{{id}}/rayones",
		data: formData,
        dataType: "json",
        success: function(data) {
			window.location = "/ordenes_de_trabajo/createServicios/" +id 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}	
	});
}
