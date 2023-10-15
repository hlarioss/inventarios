var db = {};

window.db = db;
db.detalle = [];

$("#ButtonOrdenDeTrabajo3").click(function(event) {
		
        updateGolpes();
        updateRayones();
	
});
//funcion guardar golpes
function updateGolpes(button) {
	$("#ButtonOrdenDeTrabajo3").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonOrdenDeTrabajo3"));
	l.start();
	var img1_1  = $('#1').prop('checked')? 1:0;
	var img1_2  = $('#2').prop('checked')? 1:0;
	var img1_3  = $('#3').prop('checked')? 1:0;
	var img1_4  = $('#4').prop('checked')? 1:0;
	var img1_5  = $('#5').prop('checked')? 1:0;
	var img1_6  = $('#6').prop('checked')? 1:0;
	var img1_7  = $('#7').prop('checked')? 1:0;
	var img1_8  = $('#8').prop('checked')? 1:0;
	var img1_9  = $('#9').prop('checked')? 1:0;
	var img1_10 = $('#10').prop('checked')? 1:0;
	var img1_11 = $('#11').prop('checked')? 1:0;
	var img1_12 = $('#12').prop('checked')? 1:0;
	var img2_1  = $('#13').prop('checked')? 1:0;
	var img2_2  = $('#14').prop('checked')? 1:0;
	var img2_3  = $('#15').prop('checked')? 1:0;
	var img2_4  = $('#16').prop('checked')? 1:0;
	var img2_5  = $('#17').prop('checked')? 1:0;
	var img2_6  = $('#18').prop('checked')? 1:0;
	var img3_1  = $('#19').prop('checked')? 1:0;
	var img3_2  = $('#20').prop('checked')? 1:0;
	var img3_3  = $('#21').prop('checked')? 1:0;
	var img3_4  = $('#22').prop('checked')? 1:0;
	var img3_5  = $('#23').prop('checked')? 1:0;
	var img3_6  = $('#24').prop('checked')? 1:0;
	var img4_1  = $('#25').prop('checked')? 1:0;
	var img4_2  = $('#26').prop('checked')? 1:0;
	var img4_3  = $('#27').prop('checked')? 1:0;
	var img4_4  = $('#28').prop('checked')? 1:0;
	var img4_5  = $('#29').prop('checked')? 1:0;
	var img4_6  = $('#30').prop('checked')? 1:0;


	var formData = {
		img1_1 :img1_1 ,
		img1_2 :img1_2 ,
		img1_3 :img1_3 ,
		img1_4 :img1_4 ,
		img1_5 :img1_5 ,
		img1_6 :img1_6 ,
		img1_7 :img1_7 ,
		img1_8 :img1_8 ,
		img1_9 :img1_9 ,
		img1_10:img1_10,
		img1_11:img1_11,
		img1_12:img1_12,
		img2_1 :img2_1 ,
		img2_2 :img2_2 ,
		img2_3 :img2_3 ,
		img2_4 :img2_4 ,
		img2_5 :img2_5 ,
		img2_6 :img2_6 ,
		img3_1 :img3_1 ,
		img3_2 :img3_2 ,
		img3_3 :img3_3 ,
		img3_4 :img3_4 ,
		img3_5 :img3_5 ,
		img3_6 :img3_6 ,
		img4_1 :img4_1 ,
		img4_2 :img4_2 ,
		img4_3 :img4_3 ,
		img4_4 :img4_4 ,
		img4_5 :img4_5 ,
		img4_6 :img4_6 ,
	}

	var id = $('#orden_id').val();
	$.ajax({
		type: "PATCH",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/ordenes_de_trabajo/"+id+"/update3",
		data: formData,
        dataType: "json",
        always: function() {
			l.stop();
		}	
	});
}

//funcion guardar rayones
function updateRayones(button) {
	$("#ButtonOrdenDeTrabajo3").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonOrdenDeTrabajo3"));
	l.start();
	var img1_1  = $('#31').prop('checked')? 1:0;
	var img1_2  = $('#32').prop('checked')? 1:0;
	var img1_3  = $('#33').prop('checked')? 1:0;
	var img1_4  = $('#34').prop('checked')? 1:0;
	var img1_5  = $('#35').prop('checked')? 1:0;
	var img1_6  = $('#36').prop('checked')? 1:0;
	var img1_7  = $('#37').prop('checked')? 1:0;
	var img1_8  = $('#38').prop('checked')? 1:0;
	var img1_9  = $('#39').prop('checked')? 1:0;
	var img1_10 = $('#40').prop('checked')? 1:0;
	var img1_11 = $('#41').prop('checked')? 1:0;
	var img1_12 = $('#42').prop('checked')? 1:0;
	var img2_1  = $('#43').prop('checked')? 1:0;
	var img2_2  = $('#44').prop('checked')? 1:0;
	var img2_3  = $('#45').prop('checked')? 1:0;
	var img2_4  = $('#46').prop('checked')? 1:0;
	var img2_5  = $('#47').prop('checked')? 1:0;
	var img2_6  = $('#48').prop('checked')? 1:0;
	var img3_1  = $('#49').prop('checked')? 1:0;
	var img3_2  = $('#50').prop('checked')? 1:0;
	var img3_3  = $('#51').prop('checked')? 1:0;
	var img3_4  = $('#52').prop('checked')? 1:0;
	var img3_5  = $('#53').prop('checked')? 1:0;
	var img3_6  = $('#54').prop('checked')? 1:0;
	var img4_1  = $('#55').prop('checked')? 1:0;
	var img4_2  = $('#56').prop('checked')? 1:0;
	var img4_3  = $('#57').prop('checked')? 1:0;
	var img4_4  = $('#58').prop('checked')? 1:0;
	var img4_5  = $('#59').prop('checked')? 1:0;
	var img4_6  = $('#60').prop('checked')? 1:0;

	var descripcion=   $("#descripcion").val();
	var formData = {
		img1_1 :img1_1 ,
		img1_2 :img1_2 ,
		img1_3 :img1_3 ,
		img1_4 :img1_4 ,
		img1_5 :img1_5 ,
		img1_6 :img1_6 ,
		img1_7 :img1_7 ,
		img1_8 :img1_8 ,
		img1_9 :img1_9 ,
		img1_10:img1_10,
		img1_11:img1_11,
		img1_12:img1_12,
		img2_1 :img2_1 ,
		img2_2 :img2_2 ,
		img2_3 :img2_3 ,
		img2_4 :img2_4 ,
		img2_5 :img2_5 ,
		img2_6 :img2_6 ,
		img3_1 :img3_1 ,
		img3_2 :img3_2 ,
		img3_3 :img3_3 ,
		img3_4 :img3_4 ,
		img3_5 :img3_5 ,
		img3_6 :img3_6 ,
		img4_1 :img4_1 ,
		img4_2 :img4_2 ,
		img4_3 :img4_3 ,
		img4_4 :img4_4 ,
		img4_5 :img4_5 ,
		img4_6 :img4_6 ,
		descripcion:descripcion,
	}

	var id = $('#orden_id').val();
	console.log(id);
	$.ajax({
		type: "PATCH",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/ordenes_de_trabajo/"+id+"/update4",
		data: formData,
        dataType: "json",
        success: function(data) {
			window.location = "/ordenes_de_trabajo/editcreate4/" +id 
		},
		always: function() {
			l.stop();
		},
	});
}