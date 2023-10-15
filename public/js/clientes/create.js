$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

//funcion para comprobar si el  CUI  es valido
function cuiIsValid(cui) {
    var console = window.console;
    if (!cui) {
        console.log("CUI vacío");
        return true;
    }

    var cuiRegExp = /^[0-9]{4}\s?[0-9]{5}\s?[0-9]{4}$/;

    if (!cuiRegExp.test(cui)) {
        console.log("CUI con formato inválido");
        return false;
    }

    cui = cui.replace(/\s/, '');
    var depto = parseInt(cui.substring(9, 11), 10);
    var muni = parseInt(cui.substring(11, 13));
    var numero = cui.substring(0, 8);
    var verificador = parseInt(cui.substring(8, 9));
    
    // Se asume que la codificación de Municipios y 
    // departamentos es la misma que esta publicada en 
    // http://goo.gl/EsxN1a

    // Listado de municipios actualizado segun:
    // http://goo.gl/QLNglm

    // Este listado contiene la cantidad de municipios
    // existentes en cada departamento para poder 
    // determinar el código máximo aceptado por cada 
    // uno de los departamentos.
    var munisPorDepto = [ 
        /* 01 - Guatemala tiene:      */ 17 /* municipios. */, 
        /* 02 - El Progreso tiene:    */  8 /* municipios. */, 
        /* 03 - Sacatepéquez tiene:   */ 16 /* municipios. */, 
        /* 04 - Chimaltenango tiene:  */ 16 /* municipios. */, 
        /* 05 - Escuintla tiene:      */ 13 /* municipios. */, 
        /* 06 - Santa Rosa tiene:     */ 14 /* municipios. */, 
        /* 07 - Sololá tiene:         */ 19 /* municipios. */, 
        /* 08 - Totonicapán tiene:    */  8 /* municipios. */, 
        /* 09 - Quetzaltenango tiene: */ 24 /* municipios. */, 
        /* 10 - Suchitepéquez tiene:  */ 21 /* municipios. */, 
        /* 11 - Retalhuleu tiene:     */  9 /* municipios. */, 
        /* 12 - San Marcos tiene:     */ 30 /* municipios. */, 
        /* 13 - Huehuetenango tiene:  */ 32 /* municipios. */, 
        /* 14 - Quiché tiene:         */ 21 /* municipios. */, 
        /* 15 - Baja Verapaz tiene:   */  8 /* municipios. */, 
        /* 16 - Alta Verapaz tiene:   */ 17 /* municipios. */, 
        /* 17 - Petén tiene:          */ 14 /* municipios. */, 
        /* 18 - Izabal tiene:         */  5 /* municipios. */, 
        /* 19 - Zacapa tiene:         */ 11 /* municipios. */, 
        /* 20 - Chiquimula tiene:     */ 11 /* municipios. */, 
        /* 21 - Jalapa tiene:         */  7 /* municipios. */, 
        /* 22 - Jutiapa tiene:        */ 17 /* municipios. */ 
    ];
    
    if (depto === 0 || muni === 0)
    {
        console.log("CUI con código de municipio o departamento inválido.");
        return false;
    }
    
    if (depto > munisPorDepto.length)
    {
        console.log("CUI con código de departamento inválido.");
        return false;
    }
    
    if (muni > munisPorDepto[depto -1])
    {
        console.log("CUI con código de municipio inválido.");
        return false;
    }
    
    // Se verifica el correlativo con base 
    // en el algoritmo del complemento 11.
    var total = 0;
    
    for (var i = 0; i < numero.length; i++)
    {
        total += numero[i] * (i + 2);
    }
    
    var modulo = (total % 11);
    
    console.log("CUI con módulo: " + modulo);
    return modulo === verificador;
}


$.validator.addMethod("dpi", function(value, element) {
		var valor = value;
		if (cuiIsValid(valor) == true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}, "El CUI/DPI ingresado está incorrecto");


$.validator.addMethod("cuiUnico", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: "/clientes/dpiDisponible",
		data: "dpi=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El DPI ya está asignado a otro cliente registrado en el sistema");

// funcion para comprobar si el NIT es valido
function ValidaNIT(txtN) {
	txtN = txtN.toUpperCase();
	var nit = txtN;
	var pos = nit.indexOf("-");

		if (pos < 0)
		{
			var correlativo = txtN.substr(0, txtN.length - 1);
			correlativo = correlativo + "-";

			var pos2 = correlativo.length - 2;
			var digito = txtN.substr(pos2 + 1);
			nit = correlativo + digito;
			pos = nit.indexOf("-");
			txtN = nit;
		}

		var Correlativo = nit.substr(0, pos);
		var DigitoVerificador = nit.substr(pos + 1);
		var Factor = Correlativo.length + 1;
		var Suma = 0;
		var Valor = 0;
		for (x = 0; x <= (pos - 1); x++) {
			Valor = eval(nit.substr(x, 1));
			var Multiplicacion = eval(Valor * Factor);
			Suma = eval(Suma + Multiplicacion);
			Factor = Factor - 1;
		}
		var xMOd11 = 0;
		xMOd11 = (11 - (Suma % 11)) % 11;
		var s = xMOd11;
		if ((xMOd11 == 10 && DigitoVerificador == "K") || (s == DigitoVerificador)) {
			return true;
		}
		else
		{
			return false; 
		}
}


$.validator.addMethod("nit", function(value, element){
	var valor = value;

	if(ValidaNIT(valor)==true)
	{
		return true;
	}

	else
	{
		return false;
	}
}, "El NIT ingresado es incorrecto o inválido, reviselo y vuelva a ingresarlo");

$.validator.addMethod("nitUnico", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: "/clientes/nitDisponible",
		data: "nit=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El nit ya está registrado en el sistema");

var validator = $("#ClienteForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nit:{
			required: true,
			nit:true,
			nitUnico: true
		},
		dpi:{
			required: true,
			cuiUnico : true,
			dpi : true
		},
		nombres: {
			required : true
		},

		apellidos: {
			required : true
		},
		tipo_cliente_id: {
			required : true
		},
		clasificacion_cliente_id: {
			required : true
		}

	},
	messages: {
		nit: {
			required: "Por favor, ingrese el NIT del cliente"
		},
		dpi: {
			required: "Por favor, ingrese dpi del cliente"
		},
		nombres: {
			required: "Por favor, ingrese nombres del cliente"
		},

		apellidos: {
			required: "Por favor, ingrese apellidos del cliente"
		},
		tipo_cliente_id: {
			required: "Por favor, seleccione el tipo de cliente"
		},
		clasificacion_cliente_id: {
			required: "Por favor, seleccione clasificacion"
		}

	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonCliente").click(function(event) {
	if ($('#ClienteForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});


function saveContact(button) {
	$("#ButtonCliente").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonCliente"));
	l.start();
	var formData = $("#ClienteForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenCliente').val()},
		url: "/clientes/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/clientes" 
			
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}

function BorrarFormularioCliente() {
    $("#ClienteForm :input").each(function () {
        $(this).val('');
	});
	$('#tipo_cliente_id').val('');
	$('#clasificacion_cliente_id').val('');
	$('#tipo_cliente_id').change();
	$('#clasificacion_cliente_id').change();
}

$("#ButtonClienteModal").click(function(event) {
	if ($('#ClienteForm').valid()) {
		saveModalCliente();
	} else {
		validator.focusInvalid();
	}
});

function saveModalCliente(button) {
	var l = Ladda.create(document.querySelector("#ButtonClienteModal"));
	l.start();
	var formData = $("#ClienteForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenCliente').val()},
		url: "/clientes/save/modal",
		data: formData,
		dataType: "json",
		success: function(data) {
			cargarSelectCliente();
			var url = window.location.pathname;
			if (url == '/ordenes_de_trabajo/new')
			{
				cargarSelectClienteVehiculo();
			}

			if (url.indexOf('/ordenes_de_trabajo/edit') != -1)
			{
				cargarSelectClienteVehiculo();
			}

			
			
			BorrarFormularioCliente();
			l.stop();
			$('#myModal').modal("hide");
			
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}