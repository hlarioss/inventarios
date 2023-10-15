var existencias_table = $('#existencias-table').DataTable({
    "ajax": "/existencias/getJson",
    "responsive": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',
    "buttons": [
    {
        extend: 'pdfHtml5',
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5]
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
    //"order": [0, 'asc'],
    "columns": [ 
        {
            "title": "Codigo de Barra",
            "data": "codigo_barra",
            "width" : "3%",
            "responsivePriority": 2,
            "render": function( data, type, full, meta ) {
                return CustomDatatableRenders.fitTextHTML(data); },
        },
        {
        "title": "MARCA",
        "data": "id",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data); },
    },
    {
        "title": "Nombre Producto",
        "data": "nombre",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data); },
        },
        {
            "title": "Descripción",
            "data": "minimo",
            "width" : "35%",
            "responsivePriority": 2,
            "render": function( data, type, full, meta ) {
                return CustomDatatableRenders.fitTextHTML(data); },
        },
    
    
        {
        "title": "Existencia",
        "data": "existencias",
        "width" : "3%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data); },
    },
    {
        "title": "Ubicación",
        "data": "ubicacion",
        "width" : "3%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data); },
    },
    ],
});
