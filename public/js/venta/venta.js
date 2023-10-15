var venta_table = $('#venta-table').DataTable({
    "ajax": "venta/getJson",
    "dom": 'Bfrtip',
    "buttons": [
    {
        extend: 'pdfHtml5',
        exportOptions: {
            columns: [ 0, 1, 2, 3]
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
    "order": [0, 'desc'],
    "columns": [
        {
            "title": "# Orden",
            "data": "id",
            "width" : "25%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return CustomDatatableRenders.fitTextHTML(data);
            },
        }, 
        {
            "title": "Fecha",
            "data": "fecha",
            "width" : "25%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return CustomDatatableRenders.fitTextHTML(data);
            },
        }, 
        
        {
        "title": "Total",
        "data": "total_venta",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    },
    {
        "title": "Tipo de Pago",
        "data": "tipo_pago",
        "width" : "25%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, 
    
    {
        "title": "Usuario",
        "data": "name",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Acciones",
        "orderable": false,
        "data": "tipo_venta_id",
        "render": function(data, type, full, meta) {
            if(data == 1){
            return "<div class='float-right col-lg-0'>" +
            "</div>"+"<div class='float-left col-lg-2'>" + 
            "<a href='#' class='remove-venta'>" + 
            "<i class='fa fa-btn fa-trash' title='Delete'></i>" + 
            "</a>" + "</div>" + 
            "<div class='float-right col-lg-3'>" + 
            "<a href='#' class='detalle-venta'>" + 
            "<i class='fa fa-btn fa-desktop' title='detalle'></i>" + 
            "</a>"+"</div>" + 
            "<div class='float-right col-lg-3'>" + 
            "<a  href='/rpt_factura/"+ full.id +" 'target='_blank' class='pdf-factura' >" + 
            "<i class='fa fa-file-pdf-o' title='PDF'></i>" + 
            "</a>" + "</div>"+
            "<div class='float-right col-lg-2'>" + 
            "<a href='/ventas/edit/"+ full.id +"' class='edit-venta'>" + 
            "<i class='fa fa-btn fa-edit' title='Editar Venta'></i>" + 
            "</a>" + "</div>"+
            "<div class='float-right col-lg-2'>" + 
            "<a  href='/rpt_salida/"+ full.id +" 'target='_blank' class='pdf-salida' >" + 
            "<i class='fa fa-file' title='VALE SALIDA'></i>" + 
            "</a>" + "</div>" ;
        }
        else{
            return "<div class='float-right col-lg-0'>" +"</div>"+ 
            "<div class='float-left col-lg-3'>" + 
            "<a href='#' class='remove-venta'>" + 
            "<i class='fa fa-btn fa-trash' title='Delete'></i>" + 
            "</a>" + "</div>" + 
            "<div class='float-right col-lg-3'>" + 
            "<a href='#' class='detalle-venta'>" + 
            "<i class='fa fa-btn fa-desktop' title='detalle'></i>" + 
            "</a>"+"</div>"+
            "<div class='float-right col-lg-3'>" + 
            "<a href='/ventas/edit/"+ full.id +"' class='edit-venta'>" + 
            "<i class='fa fa-btn fa-edit' title='Editar Venta'></i>" + 
            "</a>" + "</div>" +
            "<div class='float-right col-lg-3'>" + 
            "<a  href='/rpt_salida/"+ full.id +" 'target='_blank' class='pdf-salida' >" + 
            "<i class='fa fa-file' title='VALE SALIDA'></i>" + 
            "</a>" + "</div>";

        }
        },
        


        "responsivePriority": 3
    }],
    "createdRow": function(row, data, rowIndex) {
        $.each($('td', row), function(colIndex) {
            if (colIndex == 4) $(this).attr('id', data.id);
        });
    },
    "fnPreDrawCallback": function( oSettings ) {
    }
});

var detalle = $('#detalle').text();

var venta_detalle = $('#ventadetalle-table').DataTable({
    "ajax": "/ventadetalle/"+detalle +"/getJson",
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
    "order": [0, 'desc'],
    "columns": [ {
        "title": "No Venta",
        "data": "No_Venta",
        "width" : "25%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
        
    }, {
        "title": "Producto",
        "data": "nombre",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Cantidad",
        "data": "cantidad",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Subtotal",
        "data": "subtotal",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
           return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));

       },
   },{
    "title": "Acciones",
    "orderable": false,
    "render": function(data, type, full, meta) {
        return "<div id='" + full.id + "' class=' col-lg-6 text-center'>" + 
        "<div class='float-right one-columns'>" + 
        "<a href='#' class='remove-ventadetalle'>" + 
        "<i class='fa fa-btn fa-trash' title='Delete'></i>" + 
        "</a>" + "</div>" +"</div>" + 
        "<div class='float-left col-lg-6'>" + 
        "<a href='/detallesventas/edit/"+full.id+"'class='edit-detalle'>" + 
        "<i class='fa fa-btn fa-edit' title='Editar detalle'></i>" + 
        "</a>" + "</div>";
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