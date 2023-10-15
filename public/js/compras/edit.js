$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

var validator = $("#CompraUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		fecha_factura: {
			required : true
		},
		proveedor_id: {
			required : true
		},
		num_factura: {
			required : true
		},
		serie_factura: {
			required : true
		}
	},
	messages: {
		fecha_factura: {
			required: "Por favor, seleccione fecha"
		},
		proveedor_id: {
			required : "Por favor, seleccione proveedor"
		},
		num_factura: {
			required : "Por favor, ingrese numero de factura"
		},
		serie_factura: {
			required: "Por favor, ingrese serie"
		}
	}
});


$('body').on('click', 'a.detalle-compra', function(e) {
	e.preventDefault();
	var id = $(this).parent().parent().attr("id");
	window.location = "/detallescompras/"+ id;
	/*window.location = "/pos_v2/ingresodetalle/"+ id;*/
});


$("#edit-compra-form").submit(function(e) {
	e.preventDefault();
	var id = $(this).data("id");
	var url = "/compras/" + id + "/update";
	/*var url = "/pos_v2/compra/" + id + "/update";*/
	var serie_factura = $("#edit-compra-form input[name='serie_factura']").val();
	var num_factura = $("#edit-compra-form input[name='num_factura']").val();
	var fecha_factura = $("#edit-compra-form input[name='fecha_factura']").val();
	var proveedor_id = $("#edit-compra-form #proveedor_id").val();
	data = {
		serie_factura: serie_factura,
		num_factura: num_factura,
		fecha_factura: fecha_factura,
		proveedor_id: proveedor_id,
	};
	$(".user-created-message").addClass("hidden");
	$.ajax({
		method: "PATCH",
		url: url,
		data: JSON.stringify(data),
		contentType: "application/json",
	}).done(function(data) {
		$(".user-created-message").removeClass("hidden");
		$(".user-created-message").addClass("alert-success");
		$(".user-created-message").fadeIn();
		$(".user-created-message > p").text("Ingreso Maestro editado exitosamente!");
		$('#compraUpdateModal').modal("hide");
		compras_table.ajax.reload();
	}).fail(function(errors) {
	
	});
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


$('body').on('click', 'a.remove-compra', function(e) {
	$( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
	unsetPasswordErrors("password_delete");
	$("input[name='password_delete']").val("");
	var id = $(this).parent().parent().attr("id");
	var user = $(this).parent().parent().parent().parent().children().eq(0).text();
	$("#userDeleteModal").hide().show();
	$("#userDeleteModal").modal();
	if (user.length = 1) {
		$("#message").text("esta  compra?");
		$(".variable").text("");
		$(".entity").text("");
	} else {
		$("#message").text("estas compras");
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

	/*var url = "/pos_v2/compra/destroy/"+id;*/
	var url = "/compras/destroy/"+id;
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
		$(".user-created-message > p").text("Ingreso Maestro borrado exitosamente!");
		compras_table.ajax.reload();
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
