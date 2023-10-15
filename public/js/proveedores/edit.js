function ValidaNIT(txtN) {
	txtN = txtN.toUpperCase();
	var nit = txtN;
	var pos = nit.indexOf("-");

		if (pos < 0)
		{
			var correlativo = txtN.substr(0, txtN.length - 1);
			correlativo = correlativo + "-";

			var pos2 = correlativo.length - 2;
			var digito = txtN.substr(pos2 + 1);
			nit = correlativo + digito;
			pos = nit.indexOf("-");
			txtN = nit;
		}

		var Correlativo = nit.substr(0, pos);
		var DigitoVerificador = nit.substr(pos + 1);
		var Factor = Correlativo.length + 1;
		var Suma = 0;
		var Valor = 0;
		for (x = 0; x <= (pos - 1); x++) {
			Valor = eval(nit.substr(x, 1));
			var Multiplicacion = eval(Valor * Factor);
			Suma = eval(Suma + Multiplicacion);
			Factor = Factor - 1;
		}
		var xMOd11 = 0;
		xMOd11 = (11 - (Suma % 11)) % 11;
		var s = xMOd11;
		if ((xMOd11 == 10 && DigitoVerificador == "K") || (s == DigitoVerificador)) {
			return true;
		}
		else
		{
			return false; 
		}
}

$.validator.addMethod("nit", function(value, element) {
	var valor = value;
	if (ValidaNIT(valor) == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}, "El NIT ingresado es incorrecto o inválido, reviselo y vuelva a ingresarlo");


var validator = $("#ProveedorUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nit: {
			required : true,
			nit : true

		},
		nombre: {
			required : true
		},
		direccion: {
			required : true
		},
		telefonos: {
			required : true
		},
		tipo_proveedor_id: {
			required: true
		}
	},
	messages: {
		nit: {
			required: "Por favor, ingrese el NIT del proveedor"
		},
		nombre: {
			required : "Por favor, ingrese un nombre del proveedor"
		},
		direccion: {
			required : "Por favor, ingrese un apellido del proveedor"
		},
		telefonos: {
			required : "Por favor, ingrese un teléfono del proveedor"
		},
		tipo_proveedor_id: {
			required: "Por favor, seleccione el tipo de proveedor"
		}
	}
});
