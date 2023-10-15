var mainUlr = "";
$.ajaxSetup(
{
    headers:
    {
        'X-CSRF-Token': $('input[name="_token"]').val()
    }  
});

$(".edit-my-user").click( function(e){
    e.preventDefault();
    $("#userUpdateModal").modal();
    $("#userUpdateModal").hide().show();
    $("#password-changed").addClass("hidden");
    return false;
});


$('#password-changed').on('close.bs.alert', function ( e ) {
    e.preventDefault();
    $(this).fadeOut();
    return false;
});

$("#closePassword").click( function(e){
    e.preventDefault();
    unsetPasswordErrors( "new-password");
    unsetPasswordErrors( "old-password");
    unsetPasswordErrors( "old-verify");
    $("input[name='new-password']").val("");
    $("input[name='old-password']").val("");
    $("input[name='old-verify']").val("");
});

$("#closePassword2").click( function(e){
    e.preventDefault();
    unsetPasswordErrors( "new-password");
    unsetPasswordErrors( "old-password");
    unsetPasswordErrors( "old-verify");
    $("input[name='new-password']").val("");
    $("input[name='old-password']").val("");
    $("input[name='old-verify']").val("");
});

$(".update-user").submit( function(e){

    e.preventDefault();

    var id = $(this).attr("id");
    var url = mainUlr + "user/"+id+"/change";
    var password     = $("input[name='new-password']").val().trim();
    var old_password = $("input[name='old-password']").val().trim();
    var old_verify = $("input[name='old-verify']").val().trim();


            data = { new_password : password , old_password: old_password, old_verify :old_verify};

            $.ajax({
                method: "PATCH",
                url: url,
                data: JSON.stringify(data),
                contentType: "application/json",
            }).done(function (data){

                unsetPasswordErrors( "old-password" );
                unsetPasswordErrors( "new-password" );
                unsetPasswordErrors( "old-verify");
                $("input[name='new-password']").val("");
                $("input[name='old-password']").val("");
                $("input[name='old-verify']").val("");
                $("#password-changed").removeClass("hidden");
                $("#password-changed").fadeIn();

            }).fail(function (errors){
                var errors = JSON.parse(errors.responseText);

                if( errors.old_password != null )
                    setPassworddErrors( "old-password" , errors.old_password );
                else
                    unsetPasswordErrors( "old-password" );

                if( errors.old_verify != null )
                    setPassworddErrors( "old-verify" , errors.old_verify);
                else
                    unsetPasswordErrors( "old-verify" );

                if( errors.new_password != null )
                    setPassworddErrors( "new-password" , errors.new_password );
                else
                    unsetPasswordErrors( "new-password" );

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





