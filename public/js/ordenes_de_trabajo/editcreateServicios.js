$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

function changeService() {
    var servicio_id = $("#servicio_id").val();
    var url = "/servicio/precio/" + servicio_id ;
    if (servicio_id != "") {
        $.getJSON( url , function ( result ) {
            $("input[name='precio'] ").val(result.precio);
            $("input[name='subtotal']").val(result.precio);			
        });
    }
}

$("#servicio_id").change(function () {
    changeService();
});
    
$(document).ready(function () {
    agregar_detalle();
});


function agregar_detalle(){
    var orden = $("#orden_id").val();
    var url = "/ordenes_de_trabajo/getDatos/" + orden ;
    $.getJSON( url , function ( result ) {  
        result.forEach(element => {
        var detalle = new Object();
            detalle.orden_detalle=element.detalle_id,
            detalle.precio = element.precio,
            detalle.subtotal_venta = (element.mano_obra+element.precio),
            detalle.mano_obra = element.mano_obra,
            detalle.servicio_id = element.servicio_id,
            detalle.nombre = element.nombre,
            
            db.links.push(detalle);
            $("#serviciodetalle-grid .jsgrid-search-button").trigger("click"); 
         
        });        
    });
}

$(document).on("keypress", '#addDetalle', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});


$(document).on("keypress", '#ButtonOrdenDeTrabajo', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});


$('body').on('click', '#addDetalle', function(e) {

    var detalle = new Object();
    var precio = $("input[name='precio'] ").val();
    var mano_obra = $("input[name='mano_obra'] ").val();
    var subtotal = parseFloat(precio) + parseFloat(mano_obra);
    

    if (precio != "" && servicio_id != "")
    {
        $("input[name='subtotal'] ").val(subtotal);
        detalle.precio = $("input[name='precio'] ").val();
        detalle.subtotal_venta = $("input[name='subtotal'] ").val();
        detalle.mano_obra = $("input[name='mano_obra'] ").val();
        detalle.servicio_id  = $("#servicio_id").val();
        detalle.nombre =  $("#servicio_id").find("option:selected").text();
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
        
        dbs.detalles.push(detalle);
        var id=$('#orden_id').val();
        if(id!=""){
        $.ajax({
            url: "/ordenes_de_trabajo/saveServicios/" + id,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(dbs.detalles),
            success: function(addressResponse) {
                detalle.orden_de_trabajo_id=id;
                detalle.orden_detalle=addressResponse.id;
                db.links.push(detalle);
                $("#serviciodetalle-grid .jsgrid-search-button").trigger("click");
                dbs.detalles = "";
                window.dbs = dbs;
                dbs.detalles = [];
            },
            always: function() {
                l.stop();
            },
        });
    }$("#serviciodetalle-grid .jsgrid-search-button").trigger("click");

        //$("input[name='servicio_id'] ").val("");
        $("input[name='nombre'] ").val("");
        $("input[name='precio'] ").val("");
        $("input[name='mano_obra'] ").val("");
        $('#servicio_id').val('');
        $('#servicio_id').change();
        var precio = $("input[name='precio'] ").val();
        var subtotal = precio;
        $("input[name='subtotal'] ").val(subtotal);
        $("#serviciodetalle-grid .jsgrid-search-button").trigger("click");    
    }
    else 
    {
        alert("Verifique que este seleccionado almenos un servicio");
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
            var id=$('#orden_id').val();
            deletingLink.orden_de_trabajo_id=id;
            console.log(deletingLink);
                $.ajax({
                    type: "DELETE",
                    url: "/ordendetalle3/destroy/"+ deletingLink.orden_detalle,
                    data: deletingLink,
                    dataType: "json",
                    success: function(data) {
                        var detalle = data;
                    },
                    error: function() {
                        alert("Something went wrong, please try again!");
                    }
                }); 

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
        if(confirm('Desea Guardar la Venta')){
            window.location = "/ordenes_de_trabajo"
        };
        
        }

        $("#ButtonOrdenDeTrabajo").click(function(event) {
            saveDetalle();
        });


    $(document).ready(function () {

        $("#serviciodetalle-grid").jsGrid({
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
            { title: "orden_detalle", name: "orden_detalle", type: "text", visible:false},
            { title: "Cod. Servicio", name: "servicio_id", type: "text"},
            { title: "Nombre Servicio", name: "nombre", type: "text"},
            { title: "Precio", name: "precio", type: "text"},
            { title: "Mano de Obra", name: "mano_obra", type: "text"},
            { title: "Subtotal", name: "subtotal_venta", type: "text"},
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
