$("#cantidad").keypress(function(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode < 48 || charCode > 57)  return false;
	return true;
});

$(document).on("keypress", 'form', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});


$(document).on("keypress", '#addDetalle', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});


$(document).on("keypress", '#ButtonGuardar', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    } 
});


$("input[name='codigo_barra']").focusout(function() {
    var codigo = $("input[name='codigo_barra'] ").val();
    var url = "/productos/get/?data=" + codigo;    
        $.getJSON( url , function ( result ) {
            if (result == 0 ) {
                $("input[name='nombre'] ").val("");
                $("input[name='producto_id'] ").val("");
                $("input[name='unidad_de_medida'] ").val("");
                $("input[name='cantidad_medida'] ").val("");
            }
            else {
                var cantidad_medida_sale =  $("input[name='cantidad_medida_sale'] ").val();
                var cantidad_sale = $("input[name='cantidad_sale'] ").val();

                $("input[name='nombre'] ").val(result[0].nombre);
                $("input[name='producto_id'] ").val(result[0].prod_id);
                $("input[name='unidad_de_medida'] ").val(result[0].medida);
                $("input[name='cantidad_medida'] ").val(result[0].cantidadu);
                if( cantidad_medida_sale >= result[0].cantidadu)
                {
                    $("input[name='cantidad_ingreso'] ").val(cantidad_medida_sale * cantidad_sale * result[0].cantidadu);
                    var precio=parseFloat($("input[name='precio_sale'] ").val());
                    var costo=parseFloat(precio/cantidad_medida_sale);
                    var num3 = costo.toFixed(2);            
                    $("input[name='precio_compra'] ").val(num3);
                }

                else
                {
                    $("input[name='cantidad_ingreso'] ").val((cantidad_medida_sale * cantidad_sale) / result[0].cantidadu);
                    var precio=parseFloat($("input[name='precio_sale'] ").val());
                    var costo=parseFloat(precio*cantidad_sale);
                    var num3 = costo.toFixed(2);            
                    $("input[name='precio_compra'] ").val(num3);
                }

                
            }
        });
    });

$("input[name='codigo_barra_sale']").focusout(function() {
    var codigo = $("input[name='codigo_barra_sale'] ").val();
    var url = "/productos/get/?data=" + codigo;    
        $.getJSON( url , function ( result ) {
            if (result == 0 ) {
                $("input[name='nombre_sale'] ").val("");
                $("input[name='producto_id_sale'] ").val("");
                $("input[name='unidad_de_medida_sale'] ").val("");
                $("input[name='cantidad_medida_sale'] ").val("");
                
            }
            else {
                $("input[name='precio_sale'] ").val(result[0].precio_compra);
                $("input[name='nombre_sale'] ").val(result[0].nombre);
                $("input[name='producto_id_sale'] ").val(result[0].prod_id);
                $("input[name='unidad_de_medida_sale'] ").val(result[0].medida);
                $("input[name='cantidad_medida_sale'] ").val(result[0].cantidadu);
            }
        });
    });


    $("input[name='cantidad_sale']").focusout(function() {
        var codigo = $("input[name='codigo_barra_sale'] ").val();
        var cantidad_sale = $("input[name='cantidad_sale'] ").val();
        var url = "/productos/get/?data=" + codigo;    
            $.getJSON( url , function ( result ) {
                var existencia=parseInt(result[0].existencias);
                console.log(existencia);
                if(existencia <= cantidad_sale ){
                    $("input[name='cantidad_sale'] ").after("<label class='error'>No hay existencia suficiente</label>");
                    $('#addDetalle').attr("disabled", true);
                }
    
                else{
                    $('#addDetalle').attr("disabled", false);
                    $(".error").remove();
                }
    
            });
        });

$('body').on('click', '#addDetalle', function(e) {

    var detalle = new Object();
    var cantidad_sale = $("input[name='cantidad_sale'] ").val();
    var cantidad_ingreso = $("input[name='cantidad_ingreso'] ").val();

    var precio_compra = $("input[name='precio_compra'] ").val();
    var id = $("input[name='producto_id'] ").val();
    var id_sale = $("input[name='producto_id'] ").val();  
    var subtotal = cantidad * precio_compra;

    if (cantidad_sale != "" && cantidad_ingreso != "" && precio_compra != "" && id != "" & id_sale != "")
    {
        $("input[name='subtotal'] ").val(subtotal);
        detalle.cantidad_ingreso = $("input[name='cantidad_ingreso'] ").val();
        detalle.cantidad_sale = $("input[name='cantidad_sale'] ").val();
        detalle.precio_compra = $("input[name='precio_compra'] ").val();
        detalle.subtotal_conversion = $("input[name='subtotal'] ").val();
        detalle.producto_id  = $("input[name='producto_id'] ").val();
        detalle.cantidadu_sale=$("input[name='cantidad_medida_sale'] ").val();
        detalle.cantidadu_in=$("input[name='cantidad_medida'] ").val();
        detalle.producto_id_sale  = $("input[name='producto_id_sale'] ").val();
        detalle.codigo_barra = $("input[name='codigo_barra'] ").val();
        detalle.codigo_barra_sale = $("input[name='codigo_barra_sale'] ").val();
        detalle.nombre = $("input[name='nombre'] ").val();
        detalle.nombre_sale = $("input[name='nombre_sale'] ").val();
        var total2 = $("input[name='total'] ").val();
        if (total2 != "") {
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(subtotal);
            var total = total2 + subtotal;
            var total3 = $("input[name='total'] ").val(total);
        }
        else {
            var subtotal = parseFloat(subtotal);
            var total3 = $("input[name='total'] ").val(subtotal);
        }

        db.links.push(detalle);
        $("input[name='producto_id'] ").val("");
        $("input[name='codigo_barra'] ").val("");
        $("input[name='nombre'] ").val("");
        $("input[name='precio_compra'] ").val("");
        $("input[name='cantidad_ingreso'] ").val([""]);

        $("input[name='producto_id_sale'] ").val("");
        $("input[name='codigo_barra_sale'] ").val("");
        $("input[name='nombre_sale'] ").val("");
        $("input[name='cantidad_sale'] ").val([""]);
        var cantidad = $("input[name='cantidad'] ").val();
        var subtotal = cantidad * precio_compra;
        $("input[name='subtotal'] ").val(subtotal);
        $("#detalle-grid .jsgrid-search-button").trigger("click");    
    }
    else 
    {
        alert("Verifique que el nombre del producto, la cantidad, el precio de compra y el precio de venta no esten vacios");
    }
    
});

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
            console.log(updatingLink);
        },

        deleteItem: function(deletingLink) {
            var linkIndex = $.inArray(deletingLink, this.links);
            var total2 = $("input[name='total'] ").val();
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(deletingLink.subtotal_conversion);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.links.splice(linkIndex, 1);
        }

    };
    window.db = db;
    db.links = [];

    function saveDetalle(button) {
		$.ajax({
			url: "/conversiones_productos/save",
			type: "POST",
			contentType: "application/json",
			data: JSON.stringify(db.links),
			success: function(addressResponse) {
				if (addressResponse.result == "ok") {
			window.location = "/conversiones_productos"
				}
			},
			error: function() {
				alert("Ocurrio un problema contacte al administrador!");
			},
			always: function() {
			}
		});
    }
    
        $("#ButtonGuardar").click(function(event) {
            saveDetalle();
        });


        $(document).ready(function () {

            $("#detalle-grid").jsGrid({
                width: "",
                filtering: false,
                editing: false,
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
                { title: "Producto Sale", name: "nombre_sale", type: "text"},
                { title: "Codigo", name: "producto_id", type: "text", visible:false},
                { title: "Codigo", name: "producto_id_sale", type: "text", visible:false},
                { title: "Cantidad de Salida", name: "cantidad_sale", type: "text"},


                { title: "Producto Ingresa", name: "nombre", type: "text"},
                { title: "Cantidad de Ingreso", name: "cantidad_ingreso", type: "text"},
                { title: "Precio Compra", name: "precio_compra", type: "text"},
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