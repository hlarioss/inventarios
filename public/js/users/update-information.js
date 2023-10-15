var mainUlr = "";
$.ajaxSetup(
{
    headers:
    {
        'X-CSRF-Token': $('input[name="_token"]').val()
    }  
});

$(".edit-my-account").click( function(e){
    e.preventDefault();
    $("#userUpdate2Modal").modal();
    $("#userUpdate2Modal").hide().show();
    $("#password-changed2").addClass("hidden");
    var url = mainUlr + "user/show/";
    $.getJSON( url, function(response){
        $( "input[name='old-name']").val(response.name);
        $( "input[name='old-email']").val(response.email);
    });
    return false;
});


$('#password-changed2').on('close.bs.alert', function ( e ) {
    e.preventDefault();
    $(this).fadeOut();
    return false;
});


$("#closeProfile").click( function(e){
    e.preventDefault();
    unsetPasswordErrors( "old-name");
    unsetPasswordErrors( "old-email");
    $("input[name='old-name']").val("");
    $("input[name='old-email']").val("");
});

$("#closeProfile2").click( function(e){
    e.preventDefault();
    unsetPasswordErrors( "old-name");
    unsetPasswordErrors( "old-email");
    $("input[name='old-name']").val("");
    $("input[name='old-email']").val("");
});

$(".update-userInfo").submit( function(e){

    e.preventDefault();

    var id = $(this).attr("id");
    var url = mainUlr + "user/"+id+"/changeInfo";
    var old_name    = $("input[name='old-name']").val().trim();
    var old_email = $("input[name='old-email']").val().trim();

    data = { old_name : old_name , old_email: old_email};

    $.ajax({
        method: "PATCH",
        url: url,
        data: JSON.stringify(data),
        contentType: "application/json",
    }).done(function (data){
        $(".dropdown-toggle").text( $("input[name='old-name']").val());
        $(".dropdown-toggle").append( "<span class='caret'></span>");
        unsetPasswordErrors( "old-name" );
        unsetPasswordErrors( "old-email" );
        $("#password-changed2").removeClass("hidden");
        $("#password-changed2").fadeIn();
    }).fail(function (errors){
        var errors = JSON.parse(errors.responseText);

        if( errors.old_name != null )
            setPassworddErrors( "old-name" , errors.old_name);
        else
            unsetPasswordErrors( "old-name" );

        if( errors.old_email != null )
            setPassworddErrors( "old-email" , errors.old_email);
        else
            unsetPasswordErrors( "old-email" );
    });
    return false;
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