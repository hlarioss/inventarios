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


$(document).on("keypress", '#ButtonDetalle', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

function changeService() {
    var empleado_id = $("#empleado_id").val();
    var url = "/empleados/get/?data=" + empleado_id ;
    if (empleado_id != "") {
        $.getJSON( url , function ( result ) {
            $("input[name='nombre'] ").val(result[0].nombre);
            $("input[name='apellido'] ").val(result[0].apellido);
            $("input[name='sueldo'] ").val(result[0].sueldo);
            var igss = $("input[name='sueldo'] ").val() *4.83/100;
            $("input[name='igss'] ").val(igss);	
        });
    }

    else{
            $("input[name='nombre'] ").val("");
            $("input[name='apellido'] ").val("");
            $("input[name='sueldo'] ").val("");
            $("input[name='igss'] ").val("");
    }
}

$("#empleado_id").change(function () {
    changeService();
});


$('body').on('click', '#addDetalle', function(e) {

    var detalle = new Object();
    var sueldo = $("input[name='sueldo'] ").val();
    var horas_extra = $("input[name='horas_extra'] ").val();
    var id = $("#empleado_id").val();
    var igss = $("input[name='igss'] ").val();
    var bono_incentivo = 250;
    var monto_hora_extra = horas_extra * ((sueldo/30)/8*1.5); 
    var subtotal = parseFloat(sueldo) + parseFloat(monto_hora_extra) + parseFloat(bono_incentivo) - parseFloat(igss);

    if (sueldo != ""  && id != "")
    {
        $("input[name='subtotal'] ").val(subtotal);
        $("input[name='monto_hora_extra'] ").val(monto_hora_extra);
        detalle.sueldo = $("input[name='sueldo'] ").val();
        detalle.igss = $("input[name='igss'] ").val();
        detalle.monto_hora_extra = $("input[name='monto_hora_extra'] ").val();
        detalle.bono_incentivo = 250;
        detalle.subtotal_planilla = $("input[name='subtotal'] ").val();
        detalle.empleado_id  = $("#empleado_id").val();
        detalle.nombre = $("input[name='nombre'] ").val();
        detalle.apellido = $("input[name='apellido'] ").val();
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
        $('#empleado_id').val('');
        $('#empleado_id').change();
        $("input[name='nombre'] ").val("");
        $("input[name='horas_extra'] ").val("");
        $("input[name='apellido'] ").val("");
        $("input[name='monto_hora_extra'] ").val("");
        $("input[name='igss'] ").val("");
        $("input[name='sueldo'] ").val("");
        $("input[name='subtotal'] ").val("");
        $("#planilla-grid .jsgrid-search-button").trigger("click");    
    }
    else 
    {
        alert("Verifique que el nombre del empleado no este en blanco");
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
            var subtotal = parseFloat(deletingLink.subtotal_planilla);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.links.splice(linkIndex, 1);
        }

    };
    window.db = db;
    db.links = [];

    function saveDetalle(button) {
        var total = $("input[name='total'] ").val();
        var fecha = $("#fecha").val();
        if ( fecha != '') 
        {
            var formData = {total: total, fecha: fecha} 
                $.ajax({
                    type: "GET",
                    url: "/planillas/save/",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        var detalle = data;
                        $.ajax({
                            url: "/planillas-detalle/" + detalle.id,
                            type: "POST",
                            contentType: "application/json",
                            data: JSON.stringify(db.links),
                            success: function(addressResponse) {
                                if (addressResponse.result == "ok") {
                            window.location = "/planillas"
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
            else
            {
                alert ('Especifique la fecha de la planilla');
            }

        }

        $("#ButtonDetalle").click(function(event) {
            saveDetalle();
        });


        $(document).ready(function () {

            $("#planilla-grid").jsGrid({
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
                deleteConfirm: "Esta seguro de borrar",
                controller: db,
                fields: [
                { title: "Nombre", name: "nombre", type: "text"},
                { title: "Apellido", name: "apellido", type: "text"},
                { title: "Codigo", name: "empleado_id", type: "text", visible:false},
                { title: "Bono", name: "bono_incentivo", type: "number"},
                { title: "Sueldo", name: "sueldo", type: "number"},
                { title: "Horas Extra", name: "monto_hora_extra", type: "number"},
                { title: "IGSS", name: "igss", type: "number"},
                { title: "Subtotal", name: "subtotal_planilla", type: "number"},
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