var ordenes_table = $('#ordenes-table').DataTable({
    "ajax": "/ordenes_de_trabajo/getJson",
    "dom": 'Bfrtip',
    "buttons": [
    {
        extend: 'pdfHtml5',
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5,6]
        }
    },
    'excelHtml5',
    'csvHtml5'
    ],
    "paging": true,
    "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'asc'],
    "columns": [ 
    {
        "title": "No.",
        "data": "id",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data); },
    },
    {
        "title": "Cliente",
        "data": "cliente",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data); },
    },
    {
        "title": "Vehiculo",
        "data": "placa",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data); },
    }, 
    {
        "title": "Fecha y hora",
        "data": "fecha_hora",
        "width" : "20%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data); },
    },
    {
        "title": "Total",
        "data": "total",
        "width" : "20%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2)); },
    }, 
    {
        "title": "Estado",
        "data": "estado",
        "width" : "20%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data); },
    }, 
        
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "20%",
        "data": "estado_id",
        "render": function(data, type, full, meta) {
            if(data==1){
            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-right col-lg-3'>" + 
            "<a href='/rpt_orden_trabajo/"+ full.id +"' target='_blank' class='pdf-orden'>" + 
            "<i class='fa fa-file-pdf-o' title='PDF'></i>" + 
            "</a>" + "</div>"+
            "<div class='float-right col-lg-3'>" + 
            "<a href='/ordenes_de_trabajo/edit/"+ full.id +" class='edit-orden'>" + 
            "<i class='fa fa-btn fa-edit' title='Editar Orden'></i>" + 
            "</a>" + "</div>"+ 
            "<div class='float-right col-lg-3'>" + 
            "<a href='#' class='remove-orden'>" + 
            "<i class='fa fa-btn fa-trash' title='Eliminar Orden'></i>" + 
            "</a>" + "</div>" +
            "<div class='float-right col-lg-3'>" + 
            "<a href='#' class='finish-orden'>" + 
            "<i class='fa fa-flag-checkered' title='Finalizar Orden'></i>" + 
            "</a>" + "</div>"
            ;
        }
        else{
            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-right col-lg-3'>" + 
            "<a href='/rpt_orden_trabajo/"+ full.id +"' target='_blank' class='pdf-orden'>" + 
            "<i class='fa fa-file-pdf-o' title='PDF'></i>" + 
            "</a>" + "</div>"+ 
            "<div class='float-right col-lg-3'>" + 
            "<a href='#' class='remove-orden'>" + 
            "<i class='fa fa-btn fa-trash' title='Eliminar Orden'></i>" + 
            "</a>" + "</div>"
            ;  
        }
        },
        "responsivePriority": 1
    }],
    "createdRow": function(row, data, rowIndex) {
        $.each($('td', row), function(colIndex) {
            if (colIndex == 6) $(this).attr('id', data.id);
        });
    },
    "fnPreDrawCallback": function( oSettings ) {
    }
});


// funcion para eliminar el registro
$('body').on('click', 'a.remove-orden', function(e) {
    $( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
    var id = $(this).parent().parent().attr("id");
    $("input[name='password_delete']").val("");
    unsetPasswordErrors("password_delete");
    var user = $(this).parent().parent().parent().parent().children().eq(0).text();
    $("#userDeleteModal").hide().show();
    $("#userDeleteModal").modal();
    if (user.length = 1) {
        $("#message").text("esta Orden de trabajo?");
        $(".variable").text("");
        $(".entity").text("");
    } else {
        $("#message").text("esta Orden de trabajo");
        $(".variable").text("");
        $(".entity").text("");
    }
    $(".confirm-delete", "#userDeleteModal").attr("id", "delete-" + id);
});

//Funcion para Cambio de estado de orden
$('body').on('click', 'a.finish-orden', function(e) {
    var id = $(this).parent().parent().attr("id");
    bootbox.dialog({
        message: "Finalizar Orden de Trabajo",
        title: "¿Desea Finalizar esta Orden de trabajo?",
        buttons: {
          success: {
            label: "SI",
            className: "btn-success",
            callback: function() {
                data = {
                    estado_id : 3,
                    id:id,
                };
                var url = "/ordenes_de_trabajo/estado/"+id;
                $("#user-created-message").addClass("hidden");
                $.ajax({
                    method: "PATCH",
                    url: url,
                    data: JSON.stringify(data),
                    headers: {'X-CSRF-TOKEN': $('#token').val()},
                    contentType: "application/json",
                }).done(function (data){
                    $(".user-created-message").removeClass("hidden");
                    $(".user-created-message").addClass("alert-danger");
                    $(".user-created-message").fadeIn();
                    $(".user-created-message > p").text("Orden de trabajo Finalizada exitosamente!");
                    ordenes_table.ajax.reload();
                }); 
            
            }
            
          },
          danger: {
            label: "NO",
            className: "btn-success",
            callback: function() {
               
            }
          }
        }
      });
});


function unsetPasswordErrors( input_name )
{
    $("#"+input_name+"-error").addClass("hidden");
    $("#"+input_name+"-error").text( "" );
    $("#"+input_name+"-error").parent().parent().removeClass("has-error");
}

function setPassworddErrors( input_name , text )
{
    $("#"+input_name+"-error").removeClass("hidden");
    $("#"+input_name+"-error").text( text );
    $("#"+input_name+"-error").parent().parent().addClass("has-error");
}

$('body').on('click', 'button.confirm-delete', function( e ) {
    e.preventDefault();
    var id  = $(this).attr("id").replace("delete-", "");

    var td  = $("#"+id);

    var url = "/ordenes_de_trabajo/remove/"+id;
    var password_delete = $("input[name='password_delete']").val().trim();
    data = {
        password_delete : password_delete
    };

    $("#user-created-message").addClass("hidden");
    $.ajax({
        method: "DELETE",
        url: url,
        data: JSON.stringify(data),
        headers: {'X-CSRF-TOKEN': $('#token').val()},
        contentType: "application/json",
    }).done(function (data){
        $(".user-created-message").removeClass("hidden");
        $(".user-created-message").addClass("alert-danger");
        $(".user-created-message").fadeIn();
        $(".user-created-message > p").text("Orden de trabajo eliminada exitosamente!");
        ordenes_table.ajax.reload();
        $("#userDeleteModal").modal("hide");
    }).fail(function(errors) {
        var errors = JSON.parse(errors.responseText);
        console.log(errors);
        if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
        else unsetPasswordErrors("password_delete");
    });
    return false;
});