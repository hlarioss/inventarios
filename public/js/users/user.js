var mainUrl = "";
var selectedItems   = [];
$.ajaxSetup(
{
    headers:
    {
        'X-CSRF-Token': $('input[name="_token"]').val()
    }  
});

$('.user-created-message').on('close.bs.alert', function ( e ) {
    e.preventDefault();
    $(this).fadeOut();
    return false;
});

$("#makeDataTableAction").on( "hide.bs.modal" , function()
{
    $("#makeDataTableAction").removeClass( "delete-record" );
    $("#makeDataTableAction").removeClass( "new-record" );
    $("#makeDataTableAction").removeClass( "edit-record" );
});

$("#userModal").on( "hide.bs.modal" , function()
{
    user_table.ajax.reload();
    $('.mark-all-selected').prop('checked', false);
    $(".delete-records-btn").fadeOut();
});

$("#userEditModal").on( "hide.bs.modal" , function()
{
    user_table.ajax.reload();
    $('.mark-all-selected').prop('checked', false);
    $(".delete-records-btn").fadeOut()
});

$("#createUser").click( function(e){
    e.preventDefault();

    if( selectedItems.length > 0 )
    {
        $("#makeDataTableAction").addClass( "new-record" );
        $("#makeDataTableAction").modal();
        return false;
    }

    $("#userModal").modal();
    $("#userModal").hide().show();
    $('#role').val(2);

    return false;$("#user-name"+id).text()
});

$("#closeCreateUser").click( function(e){
    e.preventDefault();
    unsetFieldErrors( "name");
    unsetFieldErrors( "email");
    unsetFieldErrors( "password" );
    unsetFieldErrors( "password_confirmation" );
    $("input[name='name']").val("");
    $("input[name='email']").val("");
    $("input[name='password']").val("");
    $("input[name='password_confirmation']").val("");
});


$("#closeCreateUser2").click( function(e){
    e.preventDefault();
    unsetFieldErrors( "name");
    unsetFieldErrors( "email");
    unsetFieldErrors( "password" );
    unsetFieldErrors( "password_confirmation" );
    $("input[name='name']").val("");
    $("input[name='email']").val("");
    $("input[name='password']").val("");
    $("input[name='password_confirmation']").val("");
});

$("#add-new-user").submit( function(e){
    e.preventDefault();

    var url = mainUrl + "user/store";

    var name        = $("input[name='name']").val().trim();
    var email       = $("input[name='email']").val().trim();
    var role        = $("#role").val();
    var password    = $("input[name='password']").val().trim();
    var password2    = $("input[name='password_confirmation']").val().trim();


    $(".user-created-message").addClass("hidden");

    data = { name : name , email: email, role: role,  password: password, password_confirmation: password2};

    $.ajax({
        method: "POST",
        url: url,
        data: JSON.stringify(data),
        contentType: "application/json",
    }).done(function (data){

        clearAddUserInputs();
        $(".user-created-message").removeClass("hidden");
        $(".user-created-message").addClass("alert-success");
        $(".user-created-message").fadeIn();
        $(".user-created-message > p").text("Usuario creado exitosamente!");
        unsetFieldErrors( "name" );
        unsetFieldErrors( "email" );
        unsetFieldErrors( "password" );
        unsetFieldErrors( "password_confirmation" );
        $('#userModal').modal("hide");

    }).fail(function (errors){
        var errors = JSON.parse(errors.responseText);
        if( errors.name != null )
            setFieldErrors( "name" , errors.name[0] );
        else
            unsetFieldErrors( "name" );

        if( errors.email != null )
            setFieldErrors( "email" , errors.email[0] );
        else
            unsetFieldErrors( "email" );
        if( errors.password_confirmation != null )
            setFieldErrors( "password_confirmation" , errors.password_confirmation[0] );
        else
            unsetFieldErrors( "password_confirmation" );

        if( errors.password != null )
            if (errors.password[0] == "The password confirmation does not match"){
                unsetFieldErrors( "password" );
                setFieldErrors( "password_confirmation" , errors.password[0] );
            }
            else {
                setFieldErrors( "password" , errors.password[0] );
            }
            else
                unsetFieldErrors( "password" );

        });


    return false;
});

function getUserActions( id)
{
    return "<div id='"+id+"' class='text-center row'>" +
    "<div class='float-left col-lg-6'>" +
    "<a href='#' class='edit-user'>" +
    "<i class='fa fa-btn fa-edit' title='Edit'></i>" +
    "</a>" +
    "</div>" +
    "<div class='float-right col-lg-6'>" +
    "<a href='#' class='remove-user'>" +
    "<i class='fa fa-btn fa-trash' title='Delete'></i>" +
    "</a>" +
    "</div>" +
    "</div>";
}

function clearAddUserInputs() {
    $("#add-new-user :input").each(function () {
        $(this).val('');
    });
}

function unsetFieldErrors( input_name )
{
    $("#"+input_name+"-error").addClass("hidden");
    $("#"+input_name+"-error").text( "" );
    $("#"+input_name+"-error").parent().parent().removeClass("has-error");
}

function setFieldErrors( input_name , text )
{
    $("#"+input_name+"-error").removeClass("hidden");
    $("#"+input_name+"-error").text( text );
    $("#"+input_name+"-error").parent().parent().addClass("has-error");
}

function hasError( value , input_name )
{

    if( value == "" )
    {
        $("input[name='"+input_name+"']").parent().parent().addClass("has-error");
        return true;
    }
    else
    {
        $("input[name='"+input_name+"']").parent().parent().removeClass("has-error");
    }

}

function verifyPasswords( password, password2 , name , name2 )
{
    if( password != password2  )
    {
        $("input[name='"+name+"']").parent().parent().addClass("has-error");
        $("input[name='"+name2+"']").parent().parent().addClass("has-error");
        return true
    }
    else
    {
        $("input[name='"+name+"']").parent().parent().removeClass("has-error");
        $("input[name='"+name2+"']").parent().parent().removeClass("has-error");
    }
}


