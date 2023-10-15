$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});

	cargarSelectMarca();
	cargarSelectClienteVehiculo();
});

function cargarSelectMarca(){
    $('#marca_id').empty();
    $("#marca_id").append('<option value="" selected>Seleccione Marca</option>');
    $.ajax({
        type: "GET",
        url: '/marcas/cargar', 
        dataType: "json",
        success: function(data){
          $.each(data,function(key, registro) {
            $("#marca_id").append('<option value='+registro.id+'>'+registro.nombre+'</option>');
          });
            $('#marca_id').addClass('selectpicker');
            $('#marca_id').attr('data-live-search', 'true');
            $('#marca_id').selectpicker('refresh');   
        },
        error: function(data) {
          alert('error');
        }
      });
}

function cargarSelectLinea(){
    $('#linea_id').empty();
    $("#linea_id").append('<option value="" selected>Seleccione Linea</option>');
    $.ajax({
        type: "GET",
        url: '/lineas/cargar', 
        dataType: "json",
        success: function(data){
          $.each(data,function(key, registro) {
            $("#linea_id").append('<option value='+registro.id+'>'+registro.linea+'</option>');
          });
            $('#linea_id').addClass('selectpicker');
            $('#linea_id').attr('data-live-search', 'true');
            $('#linea_id').selectpicker('refresh');   
        },
        error: function(data) {
          alert('error');
        }
      });
}

function cargarSelectClienteVehiculo(){
    $('#cliente_id_vehiculo').empty();
    $("#cliente_id_vehiculo").append('<option value="" selected>Seleccione Cliente</option>');
    $.ajax({
        type: "GET",
        url: '/clientes/cargar', 
        dataType: "json",
        success: function(data){
          $.each(data,function(key, registro) {
            $("#cliente_id_vehiculo").append('<option value='+registro.id+'>'+registro.nombres+' '+registro.apellidos+'</option>');
          });
            $('#cliente_id_vehiculo').addClass('selectpicker');
            $('#cliente_id_vehiculo').attr('data-live-search', 'true');
            $('#cliente_id_vehiculo').selectpicker('refresh');   
        },
        error: function(data) {
          alert('error');
        }
      });
}

function ValidaPlaca(valorPlaca){
  var digitos = valorPlaca.length;

  // Aqui esta el patron(expresion regular) a buscar en el input
  patronPlaca = /^(DIS|TE|P|A|C|U|TRC|M|TC|O|CD|CC|MI|0)+[A-Z0-9]{6}$/;
  
  if( patronPlaca.test(valorPlaca) )
  {
    return true;
  }
  else
  {
    return false;
  }
}


$.validator.addMethod("placa", function(value, element){
	var valor = value;

	if(ValidaPlaca(valor)==true)
	{
		return true;
	}

	else
	{
		return false;
	}
}, "Verfique, placa incorrecta o incompleta");

$.validator.addMethod("placaUnica", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: "/placa-disponible",
		data: "placa=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "La placa ya está asignada a otro vehiculo registrado en el sistema");

$.validator.addMethod("vinUnico", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: "/vin-disponible",
		data: "vin=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El VIN ya está asignado a otro vehiculo registrado en el sistema");


var validator = $("#VehiculoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		placa: {
			required : true,
			placa: true,
			placaUnica: true
		},
		aceite_caja: {
			required : true
		},
		aceite_motor: {
			required : true
		},
		tipo_vehiculo_id: {
			required : true
		},
		marca_id: {
			required : true
		},
		kilometraje: {
			required : true
		},
		color_id: {
			required : true
		},
		anio: {
			required : true
		},
		fecha_ultimo_servicio: {
			required : true
		},
		tipo_transmision_id: {
			required : true
		},
		linea_id: {
			required : true
		},
		cliente_id: {
			required : true
		},
		vin:{
			required:true,
			vinUnico: true
		},
		direccion_id:{
			required:true
		},
		traccion_id:{
			required:true
		},
		transmision_id:{
			required:true
		},
		tipo_caja_id:{
			required:true
		},
		aceite_caja_fabrica:{
			required:true
		},
		cantidad_aceite_caja:
		{
			required:true
		},
		combustible_id:
		{
			required:true
		},
		no_motor:{
			required:true
		},
		ccs:{
			required:true
		},
		cilindros:{
			required:true
		},
		aceite_motor_fabrica:
		{
			required:true
		},
		cantidad_aceite_motor:{
			required:true
		},
		viscosidad_motor:{
			required:true
		}
	},
	messages: {
		placa: {
			required: "Por favor, ingrese el numero de placa"
		},
		aceite_caja: {
			required : "Por favor, ingrese el aceite de caja que utiliza el vehiculo"
		},
		aceite_motor: {
			required : "Por favor, ingrese el aceite de motor que utiliza el vehiculo"
		},
		tipo_vehiculo_id: {
			required : "Por favor, seleccione el tipo de vehiculo"
		},
		marca_id: {
			required : "Por favor, seleccione el tipo de vehiculo"
		},
		kilometraje: {
			required : "Por favor, ingrese el ultimo kilometraje del vehiculo"
		},
		color: {
			required : "Por favor, ingrese el color del vehiculo"
		},
		anio: {
			required : "Por favor, ingrese el año del vehiculo"
		},
		fecha_ultimo_servicio: {
			required : "Por favor, ingrese la fecha del ultimo servicio"
		},
		tipo_transmision_id: {
			required : "Por favor, seleccione el tipo de transmision"
		},
		linea_id: {
			required : "Por favor, ingrese linea del vehiculo"
		},
		cliente_id: {
			required : "Por favor, seleccione cliente"
		},
		vin:{
			required: 'Por favor, ingrese el numero VIN del vehiculo'
		},
		direccion_id:{
			required: 'Por favor, seleccione el tipo de Direccion'
		},
		transmision_id:{
			required:'Por favor, seleccione el tipo de transmision'
		},
		tipo_caja_id:{
			required:'Por favor, seleccione el tipo de caja'
		},
		traccion_id:{
			required:'Por favor, seleccione el tipo de Traccion'
		},
		aceite_caja_fabrica:{
			required:'Por favor, ingrese  el aceite de caja que recomienda el fabricante'
		},
		cantidad_aceite_caja:
		{
			required:'Por favor, ingrese la cantidad de aceite de caja que utiliza el Vehiculo'
		},
	
		combustible_id:
		{
			required:'Por favor, seleccione el tipo de Combustible'
		},
		no_motor:{
			required:'Por favor, ingrese el numero de motor del Vehiculo'
		},
		ccs:{
			required:'Por favor, ingrese la cantidad de centimetros cúbicos del motor del  Vehiculo'
		},
		cilindros:{
			required:'Por favor, ingrese la cantidad de cilindros del motor del Vehiculo'
		},
		aceite_motor_fabrica:
		{
			required:'Por favor, ingrese  el aceite de motor que recomienda el fabricante'
		},
		cantidad_aceite_motor:{
			required:'Por favor, ingrese la cantidad de aceite de motor que utiliza el Vehiculo'
		},
		viscosidad_motor:{
			required:'Por favor, ingrese la cantidad de aceite de caja que utiliza el Vehiculo'
		}
		
	}
});

//funcion para cambiar las lineas referentes a las marcas del vehiculo
function changeLinea() {
    var marca_id = $("#marca_id").val();
    
    var url = "/linea/obtener/" + marca_id ;
    if (marca_id != "") {
        $.getJSON( url , function ( result ) {
			
			var selector =''
			for (let index = 0; index < result.length; index++) {
				selector += '<option value="'+result[index].id+'">'+result[index].linea+'</option>';	
			}
			selector += ""
			
			$('#linea_id').html(selector).fadeIn();
        });
    }
}
    

$("#marca_id").change(function () {
    changeLinea();
});

//funcion para inserter el numero de diferenciales referentes al tipo de traccion del vehiculo
function changediferencial() {
    var traccion_id = $("#traccion_id").val();

    if (traccion_id == 1 || traccion_id == 3) {
      			$('#diferenciales').val(1);
		}
	else{
		$('#diferenciales').val(2);
    }
}

$("#traccion_id").change(function () {
    changediferencial();
});

//funcion para cambiar el tipo de caja dependiendo del tipo de transmision seleccionado
function changeTipoCaja() {
	var transmision_id = $("#transmision_id").val();
	
    if (transmision_id == 1) {
      		$('#tipo_caja_id').html('<option></option> <option value= "1"> Secuencial</option>  <option value= "2"> CBT</option>');
		}
	else{
		$('#tipo_caja_id').html('<option></option> <option value= "3"> Mecanica</option>');
    }
}

$("#transmision_id").change(function () {
    changeTipoCaja();
});
//funciones para cambiar la viscosidad del aceite partiendo del tipo de caja y de traccion que se seleccione

function changeAceite() {
	var Tipo_caja_id = $("#tipo_caja_id").val();
	console.log(Tipo_caja_id);
    if (Tipo_caja_id == 1) {
      		$('#aceite_caja').val('ATF');
		}
	else if(Tipo_caja_id==2){
		$('#aceite_caja').val('CBT');
	}
	else{
		$('#aceite_caja').val('75W/90');
	}
}

$("#tipo_caja_id").change(function () {
    changeAceite();
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonVehiculo").click(function(event) {
	if ($('#VehiculoForm').valid()) {
		saveVehiculo();
	} else {
		validator.focusInvalid();
	}
});

function saveVehiculo(button) {
	$("#ButtonVehiculo").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonVehiculo"));
	l.start();
	var formData = $("#VehiculoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/vehiculos/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/vehiculos" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}

function BorrarFormularioVehiculo() {
    $("#VehiculoForm :input").each(function () {
        $(this).val('');
	});
	$('#tipo_vehiculo_id').val('');
	$('#tipo_vehiculo_id').change();
	$('#marca_id').val('');
	$('#marca_id').change();
	$('#linea_id').val('');
	$('#linea_id').change();
	$('#color_id').val('');
	$('#color_id').change();
	$('#direccion_id').val('');
	$('#direccion_id').change();
	$('#cliente_id_vehiculo').val('');
	$('#cliente_id_vehiculo').change();
	$('#transmision_id').val('');
	$('#transmision_id').change();
	$('#traccion_id').val('');
	$('#traccion_id').change();
	$('#tipo_caja_id').val('');
	$('#tipo_caja_id').change();
	$('#anio').val('');
	$('#anio').change();
	$('#tipo_caja_id').val('');
	$('#tipo_caja_id').change();
	$('#combustible_id').val('');
	$('#combustible_id').change();
	$('#aceite_caja').val('');
	$("input[name='diferenciales'] ").val("");
}

$("#ButtonVehiculoModal").click(function(event) {
	if ($('#VehiculoForm').valid()) {
		saveModalVehiculo();
	} else {
		validator.focusInvalid();
	}
});

function saveModalVehiculo(button) {
	var l = Ladda.create(document.querySelector("#ButtonVehiculoModal"));
	l.start();
	var formData = $("#VehiculoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenVehiculo').val()},
		url: "/vehiculos/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			//cargarSelectVehiculo();
			changevehiculo();
			BorrarFormularioVehiculo();
			l.stop();
			$('#ModalVehiculo').modal("hide");
			
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}