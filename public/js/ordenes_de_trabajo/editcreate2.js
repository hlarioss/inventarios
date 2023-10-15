var db = {};

window.db = db;
db.detalle = [];

$("#ButtonOrdenDeTrabajoupdate2").click(function(event) {
		
        updateComponentes();
        
	
});
//funcion guardar componentes
function updateComponentes(button) {
	$("#ButtonOrdenDeTrabajoupdate2").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonOrdenDeTrabajoupdate2"));
	l.start();   
	var emblemas           = $('#1').prop('checked')? 1:0;
	var encendedor         = $('#2').prop('checked')? 1:0;
	var espejos            = $('#3').prop('checked')? 1:0;
	var antena             = $('#4').prop('checked')? 1:0;
	var radio              = $('#5').prop('checked')? 1:0;
	var llavero            = $('#6').prop('checked')? 1:0;
	var placas             = $('#7').prop('checked')? 1:0;
	var platos             = $('#8').prop('checked')? 1:0;
	var tapon_combustible  = $('#9').prop('checked')? 1:0;
	var soporte_bateria    = $('#10').prop('checked')? 1:0;
	var papeles            = $('#11').prop('checked')? 1:0;
	var alfombras          = $('#12').prop('checked')? 1:0;
	var control_alarma     = $('#13').prop('checked')? 1:0;
	var extinguidor        = $('#14').prop('checked')? 1:0;
	var triangulos         = $('#15').prop('checked')? 1:0;
	var vidrios_electricos = $('#16').prop('checked')? 1:0;
	var conos              = $('#17').prop('checked')? 1:0;
	var neblineras         = $('#18').prop('checked')? 1:0;
	var luces              = $('#19').prop('checked')? 1:0;
	var llanta_repuesto    = $('#20').prop('checked')? 1:0;
	var llave_ruedas       = $('#21').prop('checked')? 1:0;
	var tricket            = $('#22').prop('checked')? 1:0;

	var combustible;
	for(i=0;i<=8;i++){
		if($('#c'+i).prop('checked') ){
			combustible=i;
		}
	}
	var descripcion=   $("#descripcion").val();
	formData = {
		emblemas : emblemas , 
		encendedor : encendedor , 
		espejos : espejos,
		antena : antena ,
		radio  : radio  ,
		llavero: llavero,
		placas : placas ,
		platos : platos ,
		tapon_combustible : tapon_combustible ,
		soporte_bateria : soporte_bateria,
		papeles : papeles,
		alfombras : alfombras,
		control_alarma : control_alarma ,
		extinguidor : extinguidor ,
		triangulos : triangulos , 
		vidrios_electricos : vidrios_electricos,
		conos : conos  ,
		neblineras : neblineras , 
		luces : luces  ,
		llanta_repuesto : llanta_repuesto,
		llave_ruedas : llave_ruedas,
		tricket : tricket,
		combustible:combustible,
		descripcion:descripcion,
	}
	var id = $('#orden_id').val();

	$.ajax({
		type: "PATCH",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/ordenes_de_trabajo/"+id+"/update2",
		data: formData,
        dataType: "json",
        success: function(data) {
			window.location = "/ordenes_de_trabajo/editcreate3/" +id 
		},
		always: function() {
			l.stop();
		},
	});
}