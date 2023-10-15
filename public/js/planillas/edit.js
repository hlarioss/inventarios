var validator = $("#PlanillaUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		fecha: {
			required : true
		}
	},
	messages: {
		fecha: {
			required: "Por favor, seleccione fecha"
		}
	}
});


$('body').on('click', 'a.detalle-planilla', function(e) {
	e.preventDefault();
	var id = $(this).parent().parent().attr("id");
	window.location = "/detallesplanillas/"+ id;
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


$('body').on('click', 'a.remove-planilla', function(e) {
	$( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
	unsetPasswordErrors("password_delete");
	$("input[name='password_delete']").val("");
	var id = $(this).parent().parent().attr("id");
	var user = $(this).parent().parent().parent().parent().children().eq(0).text();
	$("#userDeleteModal").hide().show();
	$("#userDeleteModal").modal();
	if (user.length = 1) {
		$("#message").text("esta  planilla?");
		$(".variable").text("");
		$(".entity").text("");
	} else {
		$("#message").text("estas planillas");
		$(".variable").text("");
		$(".entity").text("");
	}
	$(".confirm-delete", "#userDeleteModal").attr("id", "delete-" + id);
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
	var url = "/planillas/destroy/"+id;
	var password_delete = $("input[name='password_delete']").val().trim();
	data = {
		password_delete : password_delete
	};

	$("#user-created-message").addClass("hidden");

	$.ajax({
		method: "DELETE",
		url: url,
		data: JSON.stringify(data),
		contentType: "application/json",
	}).done(function (data){
		$(".user-created-message").removeClass("hidden");
		$(".user-created-message").addClass("alert-success");
		$(".user-created-message").fadeIn();
		$(".user-created-message > p").text("Planilla borrada exitosamente!");
		planillas_table.ajax.reload();
		$("#userDeleteModal").modal("hide");
	}).fail(function(errors) {
		var errors = JSON.parse(errors.responseText);
		if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
		else unsetPasswordErrors("password_delete");
	});
	return false;

});


$("#deleteRecord").click(function(e) {
	e.preventDefault();
	unsetPasswordErrors("password_delete");
	$("input[name='password_delete']").val("");
});
$("#deleteRecord2").click(function(e) {
	e.preventDefault();
	unsetPasswordErrors("password_delete");
	$("input[name='password_delete']").val("");
});
