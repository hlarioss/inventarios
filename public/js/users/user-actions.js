var mainUrl = "";
var editingItem = null;
var deletingItem = null;
$.ajaxSetup(
{
    headers:
    {
        'X-CSRF-Token': $('input[name="_token"]').val()
    }  
});

var user_table = $('#users-table').DataTable({
    "ajax": "user/getJson",
    "responsive": true,
    "processing": true,
    "serverSide": true,
    "info": true,
    "showNEntries": true,
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
    "columns": [ {
        "title": "Nombre",
        "data": "name",
        "width" : "25%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Email",
        "data": "email",
        "width" : "25%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Rol",
        "data": "role",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Fecha de Creación",
        "data": "date",
        "width" : "25%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.datetimeHTML(data);
        },
    }, {
        "title": "Actions",
        "width" : "10%",
        "orderable": false,
        "render": function(data, type, full, meta) {
            return getUserActions( full.id );
        },
        "responsivePriority": 2
    }],
    "createdRow": function(row, data, rowIndex) {
        $.each($('td', row), function(colIndex) {
            if (colIndex == 4) $(this).attr('id', data.id);
        });
    },
    "fnPreDrawCallback": function( oSettings ) {
        // setTimeout(function() { CustomDatatableRenders.fitTextInit(); }, 1);
        // if( selectedItems.length > 0 )
        // {
        //     $("#makeDataTableAction").removeClass( "delete-record" );
        //     $("#makeDataTableAction").removeClass( "new-record" );
        //     $("#makeDataTableAction").removeClass( "edit-record" );
        //     $("#makeDataTableAction").modal();
        //     return false;
        // }
    }
});

$('body').on('click', '.delete-records-btn', function( e ) {

    e.preventDefault();
    unsetPasswordErrors( "password_delete" );
    $("input[name='password_delete']").val("");
    $("input[name='password_delete']").parent().removeClass("has-error");

    if( selectedItems.length > 0 )
    {
        if( selectedItems.length == 1 )
        {
            $("#message").text("this User?");
            $(".entity").text("User");
        }
        else
        {
            $("#message").text("these Users?");
            $(".entity").text("Users");
        }

        var text = ""
        var url = "user/names";

        data = {selected_items: selectedItems};

        $.ajax({
            method: "POST",
            url: url,
            data: JSON.stringify(data),
            contentType: "application/json",
        }).done(function (data){

            for( var i = 0; i < data.length; i++ )
            {
                text += ( ( text == "" ) ? "* " : " - " )+data[i];
            }

            $(".variable").text( text );

        });

    }
    $("#userDeleteModal").modal();
    $( ".confirm-delete" , "#userDeleteModal").attr("field","multiple");
    $( ".confirm-delete" , "#userDeleteModal").attr("ajax","no");
});

$('body').on('click', '.continue-action-dt', function( e ) {

    selectedItems = [];

    var hasClass =  $("#makeDataTableAction").hasClass( "new-record" );
    if( hasClass )
    {
        $("#makeDataTableAction").modal( "hide" );
        $("#createUser").click();
        return false;
    }

    hasClass =  $("#makeDataTableAction").hasClass( "edit-record" );
    if( hasClass )
    {
        if( editingItem != null )
        {
            $("#makeDataTableAction").modal( "hide" );
            getEditModal( editingItem );
            return false;
        }
    }

    hasClass =  $("#makeDataTableAction").hasClass( "delete-record" );
    if( hasClass )
    {
        if( deletingItem != null )
        {
            $("#makeDataTableAction").modal( "hide" );
            getDeleteModal( deletingItem );
            return false;
        }
    }

    $('.mark-all-selected').prop('checked', false);
    user_table.draw( "page" );
    $("#makeDataTableAction").modal( "hide" );
    $(".delete-records-btn").fadeOut();

});

$('body').on('change', '.mark-all-selected', function( e ) {

    var rows        = user_table.rows().data();
    var check       = $('.mark-all-selected').is(':checked');
    selectedItems   = [];

    for( var i=0; i < rows.length; i++ )
    {
        var id = rows[i].id;
        if ( check )
        {
            selectedItems.push( id );
            $( ".row-to-select-"+id).parent().parent().addClass( "selected-row" );
            $('input[name="select-record-chk-'+id+'"]').prop('checked', true);
        }
        else
        {
            $( ".row-to-select-"+id).parent().parent().removeClass( "selected-row" );
            $('input[name="select-record-chk-'+id+'"]').prop('checked', false);
        }
    }
    verifyAndMarkHidden( selectedItems.length );
});


$('body').on('change', '.select-record-chk', function( e ) {

    var id  =  $(this).attr( "id" );

    var tr  = $(this).parent().parent().parent().parent().parent();

    var check       = $(this).is(':checked');

    if( check )
        selectedItems.push( id );
    else
    {
        for( var i=0; i < selectedItems.length; i++ )
        {
            if( selectedItems[i] == id )
            {
                selectedItems.splice( i, 1 );
            }
        }
    }

    if( selectedItems.length == 0 )
        $('.mark-all-selected').prop('checked', false);

    tr.toggleClass( "selected-row" );

    verifyAndMarkHidden( selectedItems.length );
});

function verifyAndMarkHidden( check )
{
    if( check > 0 )
        $(".delete-records-btn").fadeIn();
    else
        $(".delete-records-btn").fadeOut();
}

$("#edit-user-form").submit(function(e) {
    e.preventDefault();
    var id = $(this).data("id");
    var url = "user/" + id + "/update";
    var name = $("#edit-user-form input[name='name']").val();
    var email = $("#edit-user-form input[name='email']").val();
    var role = $("#roleUser").val();
    data = {
        name: name,
        email: email,
        role: role
    };
    $(".user-created-message").addClass("hidden");
    $.ajax({
        method: "PATCH",
        url: url,
        data: JSON.stringify(data),
        contentType: "application/json",
    }).done(function(data) {
        unsetFieldErrors("email");
        unsetFieldErrors("name");
        $(".user-created-message").removeClass("hidden");
        $(".user-created-message").addClass("alert-success");
        $(".user-created-message").fadeIn();
        $(".user-created-message > p").text("Usuario editado exitosamente!");
        $('#userEditModal').modal("hide");
    }).fail(function(errors) {
        var errors = JSON.parse(errors.responseText);
        if (errors.name != null) setFieldErrorsUpdate("name", errors.name[0]);
        else unsetFieldErrorsUpdate("name");
        if (errors.email != null) setFieldErrorsUpdate("email", errors.email[0]);
        else unsetFieldErrorsUpdate("email");
    });
    return false;
});
$('body').on('click', 'a.edit-user', function(e) {
    e.preventDefault();

    if( selectedItems.length > 0 )
    {
        $("#makeDataTableAction").addClass( "edit-record" );
        $("#makeDataTableAction").modal();
        editingItem     = this;
        return false;
    }

    getEditModal( this );

    return false;
});

function getEditModal( element )
{
    var td = $(element).parent().parent();
    var id = td.attr("id");
    var url= "user/name/"+id;
    $.getJSON( url , function ( data ) {
        $('#userEditModal').modal();
        $("#userEditModal").hide().show();
        $('#edit-user-form').data("id", id);
        $("#edit-user-form input[name='name']").val( data.name );
        $("#edit-user-form input[name='email']").val( data.email );
        var role = data.role;
        $('#roleUser option').each(function(option) {
            if (this.text == role) {
                $(this).parent().val( this.value );
                return false;
            }
        });
    });
    editingItem     = null;
}

function unsetFieldErrorsUpdate(input_name) {
    $("#edit-user-form #" + input_name + "-error").addClass("hidden");
    $("#edit-user-form #" + input_name + "-error").text("");
    $("#edit-user-form #" + input_name + "-error").parent().parent().removeClass("has-error");
}

function setFieldErrorsUpdate(input_name, text) {
    $("#edit-user-form #" + input_name + "-error").removeClass("hidden");
    $("#edit-user-form #" + input_name + "-error").text(text);
    $("#edit-user-form #" + input_name + "-error").parent().parent().addClass("has-error");
}

$('body').on('click', 'a.remove-user', function(e) {
    e.preventDefault();

    if( selectedItems.length > 0 )
    {
        $("#makeDataTableAction").modal();
        $("#makeDataTableAction").addClass( "delete-record" );
        deletingItem = this;
        return false;
    }

    getDeleteModal( this );

    return false;
});

function getDeleteModal( element )
{
    $( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
    var id = $(element).parent().parent().attr('id');
    unsetPasswordErrors("password_delete");
    $("input[name='password_delete']").val("");
    var user = [$(element).parent().parent().parent().parent().children().eq(1).text()];
    $("#userDeleteModal").hide().show();
    $("#userDeleteModal").modal();
    if (user.length = 1) {
        $("#message").text("this user?");
        $(".variable").text("");
        $(".entity").text("");
    } else {
        $("#message").text("these users");
        $(".variable").text("");
        $(".entity").text("");
    }
    $(".confirm-delete", "#userDeleteModal").attr("id", "delete-" + id);
}

$("#deleteRecord").click(function(e) {
    e.preventDefault();
    unsetPasswordErrors("password_delete");
    $("input[name='password_delete']").val("");
    $("input[name='password_confirmation']").val("");
});
$("#deleteRecord2").click(function(e) {
    e.preventDefault();
    unsetPasswordErrors("password_delete");
    $("input[name='password_delete']").val("");
    $("input[name='password_confirmation']").val("");
});

$('body').on('click', 'button.confirm-delete', function(e) {
    e.preventDefault();

    var attr = $( ".confirm-delete" , "#userDeleteModal").attr("field");
    var id;
    var url;

    if( attr == "multiple" )
    {
        id  = selectedItems;
        url = "user/multiple/destroy";
    }
    else
    {
        id = $(this).attr("id").replace("delete-", "");
        url = "user/destroy/" + id;
    }

    $("#confirm-delete").addClass("hidden");
    var td = $("#" + id);
    var password_delete = $("input[name='password_delete']").val().trim();
    $("#confirm-delete").addClass("hidden");
    $(".user-created-message").addClass("hidden");
    data = {
        password_delete : password_delete,
        id              : id
    };
    $.ajax({
        method: "DELETE",
        url: url,
        data: JSON.stringify(data),
        contentType: "application/json",
    }).done(function(data) {
        $(".user-created-message > p").text("El usuario ha sido eliminado!");
        if( attr == "multiple" )
            $(".user-created-message > p").text("El usuario ha sido eliminado!");
        selectedItems = [];
        $("input[name='password_delete']").val("");
        unsetPasswordErrors("password_delete");
        $(".user-created-message").removeClass("hidden");
        $(".user-created-message").addClass("alert-success");
        $(".user-created-message").fadeIn();
        $(this).attr("id", "");
        $("#userDeleteModal").modal("hide");
        user_table.ajax.reload();
        $(".delete-records-btn").fadeOut();
        $('.mark-all-selected').prop('checked', false);
    }).fail(function(errors) {
        var errors = JSON.parse(errors.responseText);
        if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
        else unsetPasswordErrors("password_delete");
    });
    return false;
});

function unsetPasswordErrors(input_name) {
    $("#" + input_name + "-error").addClass("hidden");
    $("#" + input_name + "-error").text("");
    $("#" + input_name + "-error").parent().parent().removeClass("has-error");
}

function setPassworddErrors(input_name, text) {
    $("#" + input_name + "-error").removeClass("hidden");
    $("#" + input_name + "-error").text(text);
    $("#" + input_name + "-error").parent().parent().addClass("has-error");
}
$("#closeEditUser").click(function(e) {
    e.preventDefault();
    unsetFieldErrorsUpdate("name");
    unsetFieldErrorsUpdate("email");
    $("#edit-user-form input[name='name']").val("");
    $("input[name='email']").val("")
});
$("#closeEditUser2").click(function(e) {
    e.preventDefault();
    unsetFieldErrorsUpdate("name");
    unsetFieldErrorsUpdate("email");
    $("#edit-user-form input[name='name']").val("");
    $("#edit-user-form input[name='email']").val("")
});
$('#userEditModal').on('hide.bs.modal', function(e) {
    clearInputs();
});

function clearInputs() {
    $('.edit-user').attr("id", "");
    $(".edit-user :input").each(function() {
        $(this).val('');
    });
}