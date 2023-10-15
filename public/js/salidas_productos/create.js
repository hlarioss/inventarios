$("#cantidad_salida").keypress(function(evt) {
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
            }
            else {
                $("input[name='nombre'] ").val(result[0].nombre+" - "+result[0].medida );
                $("input[name='producto_id'] ").val(result[0].prod_id);
                $("input[name='precio_compra'] ").val(result[0].precio_compra);
            }
        });
    });

$("input[name='cantidad_salida']").focusout(function() {
    var codigo = $("input[name='codigo_barra'] ").val();
    var cantidad_salida = $("input[name='cantidad_salida'] ").val();
    var url = "/productos/get/?data=" + codigo;    
        $.getJSON( url , function ( result ) {

            if(result[0].existencias < cantidad_salida ){
                $("input[name='cantidad_salida'] ").after("<label class='error'>No hay existencia suficiente</label>");
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
    var cantidad_salida = $("input[name='cantidad_salida'] ").val();
    var precio_compra = $("input[name='precio_compra'] ").val();
    var id = $("input[name='producto_id'] ").val(); 
    var subtotal = cantidad_salida * precio_compra;
    var tipo_salida_id = $('#tipo_salida_id').val();
    

    if (cantidad_salida != "" && tipo_salida_id != "" && precio_compra != "" && id != "")
    {
        $("input[name='subtotal'] ").val(subtotal);
        detalle.cantidad_salida = $("input[name='cantidad_salida'] ").val();
        detalle.precio_compra = $("input[name='precio_compra'] ").val();
        detalle.subtotal_salida = $("input[name='subtotal'] ").val();
        detalle.producto_id  = $("input[name='producto_id'] ").val();
        detalle.tipo_salida_id = $('#tipo_salida_id').val();
        detalle.codigo_barra = $("input[name='codigo_barra'] ").val();
        detalle.nombre = $("input[name='nombre'] ").val();
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
        $("input[name='cantidad_salida'] ").val([""]);
        $('#tipo_salida_id').val('');
	    $('#tipo_salida_id').change();
        var cantidad_salida = $("input[name='cantidad_salida'] ").val();
        var subtotal = cantidad_salida * precio_compra;
        $("input[name='subtotal'] ").val(subtotal);
        $("#detalle-grid .jsgrid-search-button").trigger("click");    
    }

    else
    {
        alert("Verifique que el nombre del producto, la cantidad, el precio de compra y tipo salida no esten vacios");
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
            var subtotal = parseFloat(deletingLink.subtotal_salida);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.links.splice(linkIndex, 1);
        }

    };
    window.db = db;
    db.links = [];

    function saveDetalle(button) {
		$.ajax({
			url: "/salidas_productos/save",
			type: "POST",
			contentType: "application/json",
			data: JSON.stringify(db.links),
			success: function(addressResponse) {
				if (addressResponse.result == "ok") {
			window.location = "/salidas_productos"
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
                { title: "Producto", name: "nombre", type: "text"},
                { title: "Codigo", name: "producto_id", type: "text", visible:false},
                { title: "Cantidad", name: "cantidad_salida", type: "text"},
                { title: "Precio Compra", name: "precio_compra", type: "text"},
                { title: "Tipo de salida", name: "tipo_salida_id", type: "text"},
                { title: "Subtotal", name: "subtotal_salida", type: "text"},
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