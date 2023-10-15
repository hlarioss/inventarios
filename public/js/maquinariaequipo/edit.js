var validator = $("#MaquinariaEquipoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre_maquina: {
			required : true
		},
		codigo_maquina:{
			required : true
		},
		marca: {
			required : true
		},
		descripcion:{
			required : true
		},
		

	},
	messages: {
		nombre_maquina: {
			required: "Por favor, ingrese el nombre del Equipo"
		},
		
		descripcion :{
			required :"Por favor ingrese la Descripcion del equipo"
		},
		
		codigo_maquina:{
			required:"Debe Ingresar un codigo de maquinaria"
		}
	}
});
