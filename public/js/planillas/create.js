$(document).ready(function() {
	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});

	var validator = $("#submit-ingresoplanilla").validate({
		ignore: [],
		onkeyup:false,
		rules: {
			fecha: {
				required : true
			}
		},
		messages: {
			fecha : {
				required : "Por favor, seleccione la fecha de planilla"
			}
		}
	});

});