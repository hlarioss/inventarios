var compras_table = $('#compras-table').DataTable({

    "ajax": "/compras/getJson",
   
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
    "columns": [ {
        "title": "Cod",
        "data": "id",
        "width" : "5%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Fecha Factura",
        "data": "fecha_factura",
        "width" : "20%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },
    {
        "title": "Serie",
        "data": "serie_factura",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },
    {
        "title": "No.Factura",
        "data": "num_factura",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },
    {
        "title": "Proveedor",
        "data": "nombre",
        "width" : "20%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },
    {
        "title": "Total Factura",
        "data": "total",
        "orderable": false,
        "width" : "20%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML("Q. " + parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    }, {
        "title": "Acciones",
        "orderable": false,
        "data": "vendido",
        "width" : "20%",
        "render": function(data, type, full, meta) {
            if(data ==0){
            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-left col-lg-4'>" + 
            "<a href='/compras/edit/"+full.id+"'class='edit-compra'>" + 
            "<i class='fa fa-btn fa-edit' title='Editar compra'></i>" + 
            "</a>" + "</div>" + 
            "<div class='float-right col-lg-4'>" + 
            "<a href='#' class='remove-compra'>" + 
            "<i class='fa fa-btn fa-trash' title='Eliminar compra'></i>" + 
            "</a>" + "</div>"+
            "<div class='float-right col-lg-4'>" + 
            "<a href='#' class='detalle-compra'>" + 
            "<i class='fa fa-btn fa-desktop' title='Detalles'></i>" + 
            "</a>" + "</div>";}

            else{
                return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-left col-lg-4'>" + 
            "<a href='/compras/edit/"+full.id+"'class='edit-compra'>" + 
            "<i class='fa fa-btn fa-edit' title='Editar compra'></i>" + 
            "</a>" + "</div>" + 
            "<div class='float-right col-lg-4'>" + 
            "<a href='#' class='detalle-compra'>" + 
            "<i class='fa fa-btn fa-desktop' title='Detalles'></i>" + 
            "</a>" + "</div>";
            }
        },
        "responsivePriority": 2
    }],
    "createdRow": function(row, data, rowIndex) {
        $.each($('td', row), function(colIndex) {
            if (colIndex == 4) $(this).attr('id', data.id);
        });
    },
    "fnPreDrawCallback": function( oSettings ) {
    }
});

var detalle = $('#detallecompra').text();

var compra_detalle = $('#detallecompra-table').DataTable({

    "ajax": "/detallescompras/"+ detalle +"/getJson",
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
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
    "columns": [ {
        "title": "No de Compra",
        "data": "compra_id",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Codigo Barra",
        "data": "codigo_barra",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
        "title": "Producto",
        "data": "nombre",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, 
    {
        "title": "Codigo Maquina",
        "data": "codigo_maquina",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
        "title": "Maquina",
        "data": "nombre_maquina",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },
    {
        "title": "Cantidad",
        "data": "existencias",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Precio de Compra",
        "data": "precio_compra",
        "orderable": false,
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    }, {
        "title": "Precio de Venta",
        "data": "precio_venta",
        "orderable": false,
        "width" : "15%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
           return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));

       },
   },
   {
    "title": "Acciones",
    "width" : "10%",
    "orderable": false,
    "data": "vendido",
    "render": function(data, type, full, meta) {
        if(data ==0){
        return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-center col-lg-6'>" + 
            "<a href='#' class='remove-detallecompra'>" + 
            "<i class='fa fa-btn fa-trash' title='Delete'></i>" + 
            "</a>" + "</div>" + "</div>"+
            "<div class='float-left col-lg-6'>" + 
            "<a href='/detallescompras/edit/"+full.id+"'class='edit-detalle'>" + 
            "<i class='fa fa-btn fa-edit' title='Editar detalle'></i>" + 
            "</a>" + "</div>";
        }
        else{
            return "<div id='" + full.id + "' class='text-center'>";
        }
    },
    "responsivePriority": 2
}],
"createdRow": function(row, data, rowIndex) {
    $.each($('td', row), function(colIndex) {
        if (colIndex == 4) $(this).attr('id', data.id);
    });
},
"fnPreDrawCallback": function( oSettings ) {
}
});