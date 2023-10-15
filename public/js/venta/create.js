$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
    });

});

function cargarSelectCliente(){
    $('#cliente_id').empty();
    $("#cliente_id").append('<option value="" selected>Seleccione Cliente</option>');
    $.ajax({
        type: "GET",
        url: '/clientes/cargar', 
        dataType: "json",
        success: function(data){
          $.each(data,function(key, registro) {
            $("#cliente_id").append('<option value='+registro.id+'>'+registro.nombres+' '+registro.apellidos+'</option>');
          });
            $('#cliente_id').addClass('selectpicker');
            $('#cliente_id').attr('data-live-search', 'true');
            $('#cliente_id').selectpicker('refresh');   
        },
        error: function(data) {
          alert('error');
        }
      });
}
 

$("#codigo_barra").change(function() {
    var codigo = $("#codigo_barra ").val();
     var url = "/../venta/get/?data=" + codigo;
        $.getJSON( url , function ( result ) {
            if (result == 0 ) {
                $("input[name='descripcion'] ").val("");
                $("input[name='precio_venta'] ").val("");
                $("input[name='precio_compra'] ").val("");
                $("input[name='cantidad'] ").val(1);
                $("#total_existencia").text("El producto no existe, está agotado, en existencia mínima o desactivado");
            }
            else {
                $("input[name='descripcion'] ").val(result[0].nombre);
                $("input[name='precio_venta'] ").val((result[0].precio_venta));
                $("input[name='precio_compra'] ").val((result[0].precio_compra));
                $("input[name='existencias'] ").val(result[0].existencias);
                $("input[name='cantidad'] ").val(1);
                $("input[name='precio_id'] ").val(result[0].precio_id);
                $("input[name='cantidadu'] ").val(result[0].cantidadu);
                $("input[name='producto_id'] ").val(result[0].prod_id);
                $("input[name='movimiento_id'] ").val(result[0].producto_id);
                $("#total_existencia").text("La existencia del producto con el precio Q." + result[0].precio_venta + " es de:" + result[0].existencias);
            }
        });
    });


$("input[name='efectivo']").focusout(function() {
    var total = $("input[name='total'] ").val();
    var efectivo = $("input[name='efectivo']").val();
    var cambio = (efectivo - total).toFixed(2); 
    $("input[name='cambio'] ").val("Q."+ cambio);
});

$("input[name='cantidad']").focusout(function() {
    var cantidad = $("input[name='cantidad'] ").val();
    var precio_venta = $("input[name='precio_venta'] ").val();

    var subtotal = (cantidad * precio_venta).toFixed(2);
    if (cantidad != 0 ) {
        $("input[name='subtotal'] ").val(subtotal);
    }
    else 
        $("input[name='subtotal'] ").val("0");
    return false;
})

$('body').on('click', '#addDetalle', function(e) 
{
    var l = Ladda.create( document.querySelector( '#addDetalle' ) );
    l.start();
    l.setProgress( 0.5 );
    if($("input[name='venta_maestro']").val() == "") 
    {
        var total_venta = $("input[name='total'] ").val();
        var tipo_pago_id = $("#tipo_pago").val();
        var cliente_id = $("#cliente_id").val();
        var formData = {total_venta: total_venta, tipo_pago_id : tipo_pago_id,cliente_id : cliente_id}  
        $.ajax({
            type: "GET",
            url: "/venta/save/",
            data: formData,
            async:false,
            dataType: 'json',
            success: function(data) {
                var detalle = data;
                $("input[name='venta_maestro'] ").val(data.id);
            },
            error: function() {
                alert("Something went wrong, please try again!");
            }
        });
    }
   
    if (parseInt($("input[name='existencias'] ").val()) >= parseInt($("input[name='cantidad'] ").val()))
    {

        if ($("input[name='descripcion'] ").val() != "" && $("input[name='cantidad'] ").val() != "")
        {

            var detalle = new Object();
            var cantidad = $("input[name='cantidad'] ").val();
            var precio_venta = $("input[name='precio_venta'] ").val();
            var subtotal = (cantidad * precio_venta).toFixed(2);
            $("input[name='subtotal'] ").val(subtotal);
            detalle.cantidad = $("input[name='cantidad'] ").val();
            detalle.precio_venta = $("input[name='precio_venta'] ").val();
            detalle.subtotal_venta = $("input[name='subtotal'] ").val();
            detalle.producto_id  = $("input[name='producto_id'] ").val();
            detalle.precio_id  = $("input[name='precio_id'] ").val();
            detalle.cantidadu  = $("input[name='cantidadu'] ").val();
            detalle.movimiento_id  = $("input[name='movimiento_id'] ").val();
            detalle.codigoballa = $("input[name='codigo_barra'] ").val();
            detalle.nombre = $("input[name='descripcion'] ").val();
            detalle.precio_compra = $("input[name='precio_compra'] ").val();
            var total2 = $("input[name='total'] ").val();
            if (total2 != "") {
                var total2 =parseFloat(total2);
                var subtotal = parseFloat(subtotal);
                var total = (total2 + subtotal).toFixed(2);
                var total3 = $("input[name='total'] ").val(total);
            }
            else {
                var subtotal = parseFloat(subtotal);
                var total3 = $("input[name='total'] ").val(subtotal.toFixed(2));
            }

            dbs.detalles.push(detalle);
            $("input[name='producto_id'] ").val("");
            $("input[name='codigo_barra'] ").val("");
            $("input[name='descripcion'] ").val("");
            $("input[name='precio_venta'] ").val("");
            $("input[name='precio_id'] ").val("");
            $("input[name='precio_compra'] ").val("");
            $("input[name='cantidad'] ").val(1);
            var cantidad = $("input[name='cantidad'] ").val();
            var precio_venta = $("input[name='precio_venta'] ").val();
            var subtotal = (cantidad * precio_venta).toFixed(2);
            $("input[name='subtotal'] ").val(subtotal);
            var venta_maestro = $("input[name='venta_maestro'] ").val();
            if($("input[name='venta_maestro']").val() != "") {       
                $.ajax({
                    url: "/venta-detalle/" + venta_maestro,
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(dbs.detalles),
                    success: function(addressResponse) {
                        detalle.venta_detalle = addressResponse.id
                        db.links.push(detalle);
                        $("#detalle-grid .jsgrid-search-button").trigger("click");
                        dbs.detalles = "";
                        window.dbs = dbs;
                        dbs.detalles = [];
                    },
                    always: function() {
                    }
                });
            }
            $("#detalle-grid .jsgrid-search-button").trigger("click");
        }
        else {
            alert("Especifique un producto valido o cantidad");
        }
    }
    else {
        alert("No se puede realizar la venta, revise las existencias del producto");
    }
    l.stop();
});
//obtener nit y direccion de cliente
function changeCliente() {
    var cliente_id = $("#cliente_id").val();
    
    var url = "/cliente/datos/" + cliente_id ;
    if (cliente_id != "") {
        $.getJSON( url , function ( result ) {
            $("input[name='nit_c'] ").val(result.nit);
            $("input[name='direccion']").val(result.direccion);			
        });
    }
    else{
        $("input[name='nit_c'] ").val("");
        $("input[name='direccion']").val("");		
    }
}
    

$("#cliente_id").change(function () {
    changeCliente();
});

$("#tipo_pago").change(function () {
    $("#tipo_pago_id").val($("#tipo_pago").val())
});

// agregar servicio a modificar
function changeService() {
    var servicio_id = $("#servicio_id").val();
    var cantidad = $("input[name='cantidad_s").val();
    var url = "/servicio/precio/" + servicio_id ;
    if (servicio_id != "") {
        $.getJSON( url , function ( result ) {
            $("input[name='precio'] ").val(result.precio);
            $("input[name='subtotal_s']").val(result.precio * cantidad);			
        });
    }
}
 
$("input[name='cantidad_s").change(function () {

    var cantidad = $("input[name='cantidad_s").val();
    var precio = $("input[name='precio").val();
    $("input[name='subtotal_s']").val(precio * cantidad);
});

$("#servicio_id").change(function () {
    changeService();
});


// funcion para agregar la mano de obra a base de datos
$('body').on('click', '#addManoObra', function(e) 
{
    var l = Ladda.create( document.querySelector( '#addManoObra' ) );
    l.start();
    l.setProgress(0.5);
    if($("input[name='venta_maestro']").val() == "") 
    {
        var total_venta = $("input[name='total'] ").val();
        var tipo_pago_id = $("#tipo_pago").val();
        var cliente_id = $("#cliente_id").val();
        var formData = {total_venta: total_venta, tipo_pago_id : tipo_pago_id,cliente_id : cliente_id} 
       
        $.ajax({
            type: "GET",
            url: "/venta/save/",
            data: formData,
            async:false,
            dataType: 'json',
            success: function(data) {
                var detalle = data;
                $("input[name='venta_maestro'] ").val(data.id);
            },
            error: function() {
                alert("Something went wrong, please try again!");
            }
        });
    }
    
        
    if ($("input[name='precio_m'] ").val() != "" && $("input[name='descripcion_m'] ").val() != "")
    {
        var detalle = new Object();
        var cantidad = 1;
        var precio_venta =$("input[name='precio_m'] ").val(); ;
        var precio_compra = 0;
        var id =  $("#servicio_id").val();
        var subtotal = precio_venta; 
        detalle.cantidad = 1;
        detalle.precio_venta = $("input[name='precio_m'] ").val();;
        detalle.precio_compra = 0;
        detalle.subtotal_venta = $("input[name='precio_m'] ").val();
        detalle.nombre = $("input[name='descripcion_m'] ").val();
        var total2 = $("input[name='total'] ").val();
        if (total2 != "") {
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(subtotal);
            var total = (total2 + subtotal).toFixed(2);
            var total3 = $("input[name='total'] ").val(total);
        }
        else {
            var subtotal = parseFloat(subtotal);
            var total3 = $("input[name='total'] ").val(subtotal.toFixed(2));
        }

        dbs.detalles.push(detalle);
        $("input[name='precio_m'] ").val("");
        $("input[name='descripcion_m'] ").val([""]);
        var precio_compra = 0;
        var subtotal = cantidad * precio_venta;
        var venta_maestro = $("input[name='venta_maestro'] ").val();
        if($("input[name='venta_maestro']").val() != "") {       
            $.ajax({
                /*url: "/pos_v2/venta-detalle/" + venta_maestro,*/
                url: "/venta-detalle/" + venta_maestro,
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(dbs.detalles),
                success: function(addressResponse) {
                    detalle.venta_detalle = addressResponse.id
                    db.links.push(detalle);
                    $("#detalle-grid .jsgrid-search-button").trigger("click");
                    dbs.detalles = "";
                    window.dbs = dbs;
                    dbs.detalles = [];
                },
                always: function() {
                },
            });
        }$("#detalle-grid .jsgrid-search-button").trigger("click");
            
    }
    else {
    bootbox.alert("Debe ingresar una descripcion y un precio de mano de obra");
    }
    l.stop();
});


//funcion para agregar el detalle de servicios a base de datos

$('body').on('click', '#addDetalleServicio', function(e) 
{
    var l = Ladda.create( document.querySelector( '#addDetalleServicio' ) );
    l.start();
    l.setProgress( 0.5 );
    if($("input[name='venta_maestro']").val() == "") 
    {
        var total_venta = $("input[name='total'] ").val();
        var tipo_pago_id = $("#tipo_pago").val();
        var cliente_id = $("#cliente_id").val();
        var formData = {total_venta: total_venta, tipo_pago_id : tipo_pago_id,cliente_id : cliente_id} 
       
        $.ajax({
            type: "GET",
            url: "/venta/save/",
            data: formData,
            async:false,
            dataType: 'json',
            success: function(data) {
                var detalle = data;
                $("input[name='venta_maestro'] ").val(data.id);
            },
            error: function() {
                alert("Something went wrong, please try again!");
            }
        });
    }
    
        
    if ($("input[name='precio'] ").val() != "" && $("input[name='cantidad_s'] ").val() != "")
    {
        var detalle = new Object();
        var cantidad = $("input[name='cantidad_s'] ").val();
        var precio_venta =$("input[name='precio'] ").val(); ;
        var precio_compra = 0;
        var id =  $("#servicio_id").val();
        var subtotal = (cantidad * precio_venta).toFixed(2); 
        $("input[name='subtotal_s'] ").val(subtotal);
        detalle.cantidad = $("input[name='cantidad_s'] ").val();
        detalle.precio_venta = $("input[name='precio'] ").val();;
        detalle.precio_compra = 0;
        detalle.subtotal_venta = $("input[name='subtotal_s'] ").val();
        detalle.servicio_id  = $("#servicio_id").val();
        detalle.nombre = $("#servicio_id").find("option:selected").text();
        var total2 = $("input[name='total'] ").val();
        if (total2 != "") {
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(subtotal);
            var total = (total2 + subtotal).toFixed(2);
            var total3 = $("input[name='total'] ").val(total);
        }
        else {
            var subtotal = parseFloat(subtotal);
            var total3 = $("input[name='total'] ").val(subtotal.toFixed(2));
        }

        dbs.detalles.push(detalle);
        $("#servicio_id").val("");
        $("#servicio_id").selectpicker(0, '');
        $('#servicio_id').selectpicker('render');
        $("input[name='nombre'] ").val("");
        $("input[name='precio'] ").val("");
        $("input[name='precio_compra'] ").val("");
        $("input[name='cantidad_s'] ").val([""]);
        var cantidad = $("input[name='cantidad_s'] ").val();
        var precio_compra = 0;
        var subtotal = (cantidad * precio_venta).toFixed(2);
        var venta_maestro = $("input[name='venta_maestro'] ").val();
        if($("input[name='venta_maestro']").val() != "") {       
            $.ajax({
                url: "/venta-detalle/" + venta_maestro,
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(dbs.detalles),
                success: function(addressResponse) {
                    detalle.venta_detalle = addressResponse.id
                    db.links.push(detalle);
                    $("#detalle-grid .jsgrid-search-button").trigger("click");
                    dbs.detalles = "";
                    window.dbs = dbs;
                    dbs.detalles = [];
                },
                always: function() {
                    l.stop();
                },
            });
        }$("#detalle-grid .jsgrid-search-button").trigger("click");
            
    }
    else {
    bootbox.alert("Debe de seleccionar un Servicio");
    }
    l.stop();
});



//funcion indefinida
(function() {

    var db = {

        loadData: function(filter) {
            return $.grep(this.links, function(link) {
                return (!filter.name || link.name.indexOf(filter.name) > -1)
                && (!filter.url || link.url.indexOf(filter.url) > -1);
            });
        },

        insertItem: function(insertingLink) {
            this.links.push(insertingLink);
            console.log(insertingLink);
        },

        updateItem: function(updatingLink) {
 
            if(updatingLink.movimiento_id>0){
                var codigo = updatingLink.venta_detalle;
                /*var url = "../pos_v2/venta/get/?data=" + codigo;*/
                var existencias;
                var cantidadant;
                var url = "/../venta/get2/?data=" + codigo;
                    $.getJSON( url , function ( result ) {
                        existencias=result[0].existencia;
                        cantidadant=result[0].cantidad;
                        var diferencia=updatingLink.cantidad-cantidadant;
                        if (existencias >= diferencia )
                        {
                            $.ajax({
                                method: "PATCH",
                                url: "/ventadetalle2/update/"+ updatingLink.venta_detalle+ "/" + updatingLink.movimiento_id,
                                data: updatingLink,
                                dataType: "json",
                                success: function(data) {
                                    var detalle = data;
                                },
                                error: function() {
                                    alert("Something went wrong, please try again!");
                                }
                            }); 
                            var subtotal_nuevo = updatingLink.cantidad * updatingLink.precio_venta;
                            var total2 = $("input[name='total'] ").val();
                            var total2 =parseFloat(total2);
                            var subtotal = updatingLink.subtotal_venta;
                            $("input[name='subtotal_venta'] ").val(subtotal_nuevo);        
                            var total = (total2 - subtotal) + (subtotal_nuevo);
                            $("input[name='total'] ").val(total);
                            updatingLink.subtotal_venta = subtotal_nuevo;
                        }
                        else{
                            updatingLink.cantidad=cantidadant;
                            //$("#detalle-grid").jsGrid("cancelEdit");
                            alert("No se puede realizar la venta, revise las existencias del producto");
                        } 
                    });
                    
            }
            else{
                $.ajax({
                    method: "PATCH",
                    url: "/ventadetalle3/update/"+ updatingLink.venta_detalle,
                    data: updatingLink,
                    dataType: "json",
                    success: function(data) {
                        var detalle = data;
                    },
                    error: function() {
                        alert("Something went wrong, please try again!");
                    }
                }); 
                var subtotal_nuevo = updatingLink.cantidad * updatingLink.precio_venta;
                var total2 = $("input[name='total'] ").val();
                var total2 =parseFloat(total2);
                var subtotal = updatingLink.subtotal_venta;
                $("input[name='subtotal_venta'] ").val(subtotal_nuevo);        
                var total = (total2 - subtotal) + (subtotal_nuevo);
                $("input[name='total'] ").val(total);
                updatingLink.subtotal_venta = subtotal_nuevo;
            }
           

        },

        deleteItem: function(deletingLink) {
            if(deletingLink.movimiento_id>0){
                $.ajax({
                    type: "DELETE",
                    url: "/ventadetalle2/destroy/"+ deletingLink.venta_detalle+ "/" + deletingLink.movimiento_id,
                    data: deletingLink,
                    dataType: "json",
                    success: function(data) {
                        var detalle = data;
                    },
                    error: function() {
                        alert("Something went wrong, please try again!");
                    }
                }); 
            }else{
                console.log(deletingLink);
                $.ajax({
                    type: "DELETE",
                    url: "/ventadetalle3/destroy/"+ deletingLink.venta_detalle,
                    data: deletingLink,
                    dataType: "json",
                    success: function(data) {
                        var detalle = data;
                    },
                    error: function() {
                        alert("Something went wrong, please try again!");
                    }
                }); 

            }
            var linkIndex = $.inArray(deletingLink, this.links);
            var total2 = $("input[name='total'] ").val();
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(deletingLink.subtotal_venta);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.links.splice(linkIndex, 1);
        }

    };

    var dbs = {

        loadData: function(filter) {
            return $.grep(this.links, function(link) {
                return (!filter.name || link.name.indexOf(filter.name) > -1)
                && (!filter.url || link.url.indexOf(filter.url) > -1);
            });
        },

        insertItem: function(insertingLink) {
            this.detalles.push(insertingLink);
            console.log(insertingLink);
        },

        updateItem: function(updatingLink) {
            console.log(updatingLink);
        },

        deleteItem: function(deletingLink) {
            var linkIndex = $.inArray(deletingLink, this.links);
            var total2 = $("input[name='total'] ").val();
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(deletingLink.subtotal_venta);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.detalles.splice(linkIndex, 1);
        }

    };

    window.db = db;
    window.dbs = dbs;
    db.links = [];
    dbs.detalles = [];

    function saveDetalle(button) {
        var total_venta = $("input[name='total'] ").val();
        var tipo_pago_id = $("#tipo_pago").val();      
        var venta_maestro = $("input[name='venta_maestro'] ").val();
        var cliente_id = $("#cliente_id").val();
        var formData = {total_venta: total_venta, tipo_pago_id : tipo_pago_id, cliente_id : cliente_id} 
        var factura=$("#factura").val();
        window.open(APP_URL+'/rpt_salida/'+venta_maestro,'_blank'); 

        if(tipo_pago_id==3){
            var fecha_venta= $("input[name='fecha_venta'] ").val();
            formData = {total_venta: total_venta, tipo_pago_id : tipo_pago_id, cliente_id : cliente_id,venta_maestro_id: venta_maestro,fecha_venta: fecha_venta}
            $.ajax({
                type: "GET",
                url: "/venta/savecpc/",
                data: formData,
                async:false,
                dataType: 'json',
                success: function(data) {
                    var detalle = data;
                    $("input[name='venta_maestro'] ").val(data.id);
                },
                error: function() {
                    alert("Something went wrong, please try again!");
                }
            });
        }
       
    
        $.ajax({
            type: "PATCH",
            url: "/venta/update-total/"+ venta_maestro+ "/",
            data: formData,
            dataType: "json",
            success: function(data) {
                var detalle = data;
                window.location = "/ventas/new"
            },
            error: function() {
                alert("falla de guardado");
            }
        });
        
    }




    //popup confirmar factura
    $("#ButtonDetalle").click(function(event) {
        bootbox.dialog({
            message: "Generar Factura",
            title: "¿Desea generar Factura?",
            buttons: {
              success: {
                label: "SI",
                className: "btn-success",
                callback: function() {
                    $("#venta_id").val($("input[name='venta_maestro'] ").val());
                    $("#tipo_pago_id").val($("#tipo_pago").val());
                    $('#facturaModal').modal('show');
                }
              },
              danger: {
                label: "NO",
                className: "btn-success",
                callback: function() {
                    saveDetalle();
                }
              }
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


// script para guardar facturas

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
		
		numero:{
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
		
		numero:{
			required: "Debe ingresar el numero de factura"
		},
		
	

	}
});


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


    var serie_id = $('#serie_id').val();
    var tipo_pago_id = $('#tipo_pago_id').val();
    var numero = $("input[name='numero").val();
    var fecha = $('#fecha').val();
    var total = $("input[name='total").val();
    var venta_id = $("#venta_id").val();
    
    var formData = {fecha:fecha, serie_id:serie_id, tipo_pago_id: tipo_pago_id, numero:numero, total:total, venta_id:venta_id} 
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/factura/save2",
		data: formData,
		dataType: "json",
		success: function(data) {
            saveDetalle();
            
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}


    
    $(document).ready(function () {

        $("#detalle-grid").jsGrid({
            width: "",
            filtering: false,
            editing: true,
            sorting: true,
            paging: true,
            autoload: true,
            inserting: false,
            pageSize: 20,
            pagerFormat: "Pages: {prev} {pages} {next} | {pageIndex} of {pageCount} |",
            pageNextText: '>',
            pagePrevText: '<',
            deleteConfirm: "Esta seguro de borrar el producto",
            controller: db,
            fields: [
                { title: "Producto", name: "nombre", type: "text"},
                { title: "Código", name: "producto_id", type: "text", visible:false},
                { title: "Código2", name: "servicio_id", type: "text", visible:false},
                { title: "Precio2", name: "precio_compra", type: "text", visible:false},
                { title: "venta_detalle", name: "venta_detalle", type: "text", visible:false},
                { title: "movimiento", name: "movimiento_id", type: "text", visible:false},
                { title: "Cantidad", name: "cantidad", type: "text"},
                { title: "Precio", name: "precio_venta", type: "text"},
                { title: "Subtotal", name: "subtotal_venta", type: "text", editing:false},
                { type: "control" }
                ],
                onItemInserting: function (args) {
                },
                onItemUpdating: function (object) {
                },
                onRefreshed : function () {
                    $('tbody').children('.jsgrid-insert-row').children('td').children('input').first().focus();
                }
            });
    });
}());

