$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

$("input[name='codigo']").focusout(function() {
    var codigo = $("input[name='codigo'] ").val();
    var url = "/codigo-disponible-servicio/?data=" + codigo;

        $.getJSON( url , function ( result ) {
            if(result == 0 ){
                $('#ButtonServicio').attr("disabled", false);
                $(".error").remove();
            }

            else{
                $("input[name='codigo'] ").after("<label class='error'>El codigo ya se encuentra registrado en el sistema</label>");
                $('#ButtonServicio').attr("disabled", true);                
            }

        });
    });
	
function changeUnidad() {
    var unidad_de_medida_id = $("#unidad_de_medida_id").val();
    var url = "/unidad_de_medida/cantidad/" + unidad_de_medida_id ;
    if (unidad_de_medida_id != "") {
        $.getJSON( url , function ( result ) {
            $("input[name='unidad_cantidad'] ").val(result.cantidad);
			
        });
    }
}

$("#unidad_de_medida_id").change(function () {
    changeUnidad();
});

$(document).on("keypress", '#addProducto', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

$(document).on("keypress", '#addMaquinaria', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});


$(document).on("keypress", '#ButtonServicio', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

$('body').on('click', '#addMaquinaria', function(e) {

    var detalle = new Object();
    var costo_maquinaria = $("input[name='costo_maquinaria'] ").val();
    var maquinaria_equipo_id  = $("#maquinaria_equipo_id").val();
	var cantidad = $("input[name='cantidad_maquina'] ").val();
    var subtotal = parseFloat(cantidad) * parseFloat(costo_maquinaria);
    var unidad =  $("#unidad_de_medida_id2").val();

    if (cantidad != "" && maquinaria_equipo_id != "" && costo_maquinaria != "" && unidad != "")
    {
        $("input[name='subtotalmaquina'] ").val(subtotal);
        detalle.costo = $("input[name='costo_maquinaria'] ").val();
        detalle.subtotal_servicio = $("input[name='subtotalmaquina'] ").val();
		detalle.maquinaria_equipo_id  = $("#maquinaria_equipo_id").val();
		detalle.cantidad  = $("input[name='cantidad_maquina'] ").val();
		detalle.nombre =  $("#maquinaria_equipo_id").find("option:selected").text();
		detalle.unidad_de_medida =  $("#unidad_de_medida_id2").find("option:selected").text();
        var total2 = $("input[name='precio_costo'] ").val();
        if (total2 != "") {
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(subtotal);
            var total = total2 + subtotal;
            var total3 = $("input[name='precio_costo'] ").val(total);
        }
        else {
            var subtotal = parseFloat(subtotal);
            var total3 = $("input[name='precio_costo'] ").val(subtotal);
        }

        db.links.push(detalle);
        $('#maquinaria_equipo_id').val('');
        $('#maquinaria_equipo_id').change();
        $('#unidad_de_medida_id2').val('');
        $('#unidad_de_medida_id2').change();
		$("input[name='costo_maquinaria'] ").val("");
		$("input[name='cantidad_maquina'] ").val("");
        /*var precio = $("input[name='costo_maquinaria'] ").val();
        var subtotal = precio;
        $("input[name='subtotalmaquina'] ").val(subtotal);*/
        $("#servicio-grid .jsgrid-search-button").trigger("click");    
    }
    else 
    {
        alert("Verifique que este seleccionado almenos una maquinaria y/o equipo");
    }
    
});


$('body').on('click', '#addProducto', function(e) {

    var detalle = new Object();
	var costo_producto = $("input[name='costo_producto'] ").val();
    var cantidad = $("input[name='cantidad'] ").val();
    var producto_id  = $("#producto_id").val();
	var subtotal = parseFloat(cantidad) * parseFloat(costo_producto);
	var unidad = $("#unidad_de_medida_id").val();
    

    if (cantidad != "" && producto_id != "" && costo_producto != "" && unidad != "")
    {
        $("input[name='subtotal'] ").val(subtotal);
        detalle.costo = $("input[name='costo_producto'] ").val();
        detalle.subtotal_servicio = $("input[name='subtotal'] ").val();
		detalle.producto_id  = $("#producto_id").val();
		detalle.cantidad  = $("input[name='cantidad'] ").val();
		detalle.nombre =  $("#producto_id").find("option:selected").text();
		detalle.unidad_de_medida =  $("#unidad_de_medida_id").find("option:selected").text();
        var total2 = $("input[name='precio_costo'] ").val();
        if (total2 != "") {
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(subtotal);
            var total = total2 + subtotal;
            var total3 = $("input[name='precio_costo'] ").val(total);
        }
        else {
            var subtotal = parseFloat(subtotal);
            var total3 = $("input[name='precio_costo'] ").val(subtotal);
        }

        db.links.push(detalle);
        $('#producto_id').val('');
        $('#producto_id').change();
        $('#unidad_de_medida_id').val('');
        $('#unidad_de_medida_id').change();
		$("input[name='costo_producto'] ").val("");
		$("input[name='cantidad'] ").val("");
        $('#producto_id option').removeAttr('selected');
        /*var precio = $("input[name='costo_producto'] ").val();
        var subtotal = precio;
        $("input[name='subtotal'] ").val(subtotal);*/
        $("#servicio-grid .jsgrid-search-button").trigger("click");    
    }
    else 
    {
        alert("Verifique que este seleccionado almenos un producto");
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
            var subtotal_nuevo = updatingLink.cantidad * updatingLink.costo;

            var total2 = $("input[name='precio_costo'] ").val();
            var total2 =parseFloat(total2);

            if(updatingLink.maquinaria_equipo_id == undefined){
                var subtotal = $("input[name='subtotal'] ").val();
                var subtotal = parseFloat(subtotal);
                $("input[name='subtotal'] ").val(subtotal_nuevo);
            }
            else{
                var subtotal = $("input[name='subtotalmaquina'] ").val();
                var subtotal = parseFloat(subtotal);
                $("input[name='subtotalmaquina'] ").val(subtotal_nuevo);
            }
            
            console.log("El subtotal es "+subtotal);
            var total = total2 - subtotal + (subtotal_nuevo);
            $("input[name='precio_costo'] ").val(total);
            updatingLink.subtotal_servicio = subtotal_nuevo;
            console.log("Nuevo " +subtotal_nuevo);
        },

        deleteItem: function(deletingLink) {
            var linkIndex = $.inArray(deletingLink, this.links);
            var total2 = $("input[name='precio_costo'] ").val();
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(deletingLink.subtotal_servicio);
            var total = total2 - subtotal;
            var total3 = $("input[name='precio_costo'] ").val(total);
            this.links.splice(linkIndex, 1);
        }

    };
    window.db = db;
    db.links = [];
	
	function saveDetalle(button) {
		var total = $("input[name='precio_costo'] ").val();
		var codigo = $("input[name='codigo'] ").val();
		var precio = $("input[name='precio'] ").val();
		var precio_costo = $("input[name='precio_costo'] ").val();
		var nombre = $("input[name='nombre'] ").val();
        var tipo_servicio_id = $("#tipo_servicio_id").val();
        console.log(tipo_servicio_id);

			if(codigo !="" && precio !="" && precio_costo !="" && nombre != "" && tipo_servicio_id !=null)
			{
				
			var formData = {total: total,codigo:codigo, tipo_servicio_id : tipo_servicio_id, precio_costo:precio_costo, precio:precio, nombre:nombre } 
				$.ajax({
					type: "GET",
					url: "/servicios/save/",
					data: formData,
					dataType: "json",
					success: function(data) {
						var detalle = data;
						$.ajax({
							url: "/servicios-detalle/" + detalle.id,
							type: "POST",
							contentType: "application/json",
							data: JSON.stringify(db.links),
							success: function(addressResponse) {
								if (addressResponse.result == "ok") {
							window.location = "/servicios"
								}
							},
							always: function() {
							}
						});
					},
					error: function() {
						alert("Something went wrong, please try again!");
					}
				});
			}

			else{
				alert("Falta ingresar codigo, nombre, tipo de servicio");
			}
		}

		$("#ButtonServicio").click(function(event) {
            saveDetalle();
        });       


    $(document).ready(function () {

        $("#servicio-grid").jsGrid({
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
			{ title: "Cod. Producto", name: "producto_id", type: "text", visible: false},
			{ title: "Cod. Maquinaria", name: "maquinaria_equipo_id", type: "text", visible: false},
			{ title: "Cantidad", name: "cantidad", type: "text"},
			{ title: "Unidad de Medida", name: "unidad_de_medida", type: "text", editing: false},
            { title: "Descripcion", name: "nombre", type: "text", editing: false},
            { title: "Costo", name: "costo", type: "text"},
            { title: "Subtotal", name: "subtotal_servicio", type: "text", editing: false},
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
