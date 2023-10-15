var validator = $("#ReporteForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		fecha_inicial: {
			required : true
        },
        fecha_final: {
			required : true
		}
	},
	messages: {
		fecha_inicial: {
			required: "Por favor, Seleccione Fecha inicial"
        },
        fecha_final: {
			required: "Por favor, Seleccione Fecha final"
        }
	}
});

$("#ButtonReporte").click(function(event) {
	event.preventDefault();
	if ($('#ReporteForm').valid()) {
		generarreporte();
	} else {
		validator.focusInvalid();
	}
});

function generarreporte() {
	var inicial=$('#inicial').val();
	var final=$('#final').val();
	var cortes_caja_table = $('#Reporte-table').DataTable({
		"ajax": "/cortes_caja/getJson/"+inicial+'/'+final ,
		"responsive": true,
		"processing": true,
		"info": true,
		"showNEntries": true,
		"dom": 'Bfrtip',
		"buttons": [
		{
			extend: 'pdfHtml5',
			exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5,6, 7, 8]
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
			"title": "Efectivo",
			"data": "efectivo",
			"width" : "20%",
			"responsivePriority": 3,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2)); },
		}, 
	
		{
			"title": "Credito",
			"data": "credito",
			"width" : "20%",
			"responsivePriority": 3,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2)); },
		},
	
		{
			"title": "Tarjeta",
			"data": "voucher",
			"width" : "20%",
			"responsivePriority": 3,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2)); },
		},
	
		{
			"title": "Total",
			"data": "total",
			"width" : "20%",
			"responsivePriority": 2,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2)); },
		},
		{
			"title": "Efectivo S/F",
			"data": "efectivoSF",
			"width" : "20%",
			"responsivePriority": 3,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2)); },
		}, 
	
		{
			"title": "Credito S/F",
			"data": "creditoSF",
			"width" : "20%",
			"responsivePriority": 3,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2)); },
		},
	
		{
			"title": "Tarjeta S/F",
			"data": "voucherSF",
			"width" : "20%",
			"responsivePriority": 3,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2)); },
		},
	
		{
			"title": "Total S/F",
			"data": "totalSF",
			"width" : "20%",
			"responsivePriority": 2,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2)); },
		},
		{
			"title": "TOTAL VENTAS",
			"data": "total_venta",
			"width" : "10%",
			"responsivePriority": 2,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2)); },
		},
		   
		],
		"createdRow": function(row, data, rowIndex) {
			$.each($('td', row), function(colIndex) {
				if (colIndex == 6) $(this).attr('id', data.id);
			});
		},
		"fnPreDrawCallback": function( oSettings ) {
		}
	});


	
}