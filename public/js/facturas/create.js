$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

function ComprobarDatos() {
    var serie_id = $("#serie_id").val();
	var inicio, fin
	var numero=$("#numero_f").val();
    var url = "/serie/datos/" + serie_id ;
    if (serie_id != "") {
        $.getJSON( url , function ( result ) {
            inicio=result.inicio;
			fin=result.fin;
			if(numero<inicio || numero>fin){
                $("#error_n").text('El Numero de Factura esta Fuera de Rango de la Serie Seleccionada.');
                $('#ButtonFactura').attr("disabled", true);
			}
			else{
                $('#ButtonFactura').attr("disabled", false);
				$("#error_n").text('');
			}
        });
    }

    $.ajax({
        type: "GET",
        async: false,
        url: "/facturas/noDisponible",
        data: {"serie_id" : serie_id, "numero" : numero}, 
        dataType: "json",
        success: function(result) {
            if (result == true){
                $("input[name='numero'] ").after("<label class='error'>La serie y numero de factura ya existe</label>");
                $('#ButtonFactura').attr("disabled", true);
            }
            else{
                $('#ButtonFactura').attr("disabled", false);
                $(".error").remove();
            }
        }
    });


}

$("#numero_f").focusout(function () {
    ComprobarDatos();
});

var validator = $("#FacturaForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		serie_id: {
			required : true
		},

		total: {
			required : true
		},
		fecha:{
			required: true
		},
		numero:{
			required: true
		},
		tipo_pago_id:{
			required: true
		},
	

	},
	messages: {
		
		serie_id: {
			required : "Debe Seleccionar La Serie"
		},
		total:{
			required: "Debe Ingresar el total"
		},
		fecha:{
			required : "Debe Seleccionar Fecha"
		},
		numero:{
			required: "Debe ingresar el numero de factura"
		},
		tipo_pago_id:{
			required: "Seleccione el tipo de pago"
		},
	

	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonFactura").click(function(event) {
	if ($('#FacturaForm').valid()) {
		saveFactura();
	} else {
		validator.focusInvalid();
	}
});


function saveFactura(button) {
	$("#ButtonFactura").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonFactura"));
	l.start();
	var formData = $("#FacturaForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/factura/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/factura" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}