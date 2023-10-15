<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Cliente;
use App\producto;

use App\user;

use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;

use App\OrdenDeTrabajo;
use App\Venta;

class PdfController extends Controller
{
    public function rpt_orden_trabajo(OrdenDeTrabajo $orden_de_trabajo)
    {
        $id = $orden_de_trabajo->id;

        $data = $this->getDataOrdenTrabajo($id);

        $query = "SELECT ot.id, s.nombre, s.precio, ots.mano_obra, (s.precio + ots.mano_obra)as subtotal  
        FROM orden_trabajo_servicio ots 
        INNER JOIN ordenes_de_trabajo ot on ot.id = ots.orden_de_trabajo_id
        INNER JOIN servicios s on s.id = ots.servicio_id
        WHERE ot.id =".$id.'';
        $detalles = DB::select($query);

        $query2 = "SELECT * from componentes_accesorios WHERE orden_id =".$id.'';
        $componentes = DB::select($query2);

        $query3 = "SELECT * from golpes WHERE orden_id =".$id.'';
        $golpes = DB::select($query3);

        $query4 = "SELECT * from rayones WHERE orden_id =".$id.'';
        $rayones = DB::select($query4);
    
        $pdf = PDF::loadView('pdf.rpt_orden_trabajo', compact('data', 'detalles','componentes', 'golpes', 'rayones'));
        return $pdf->stream('Orden de Trabajo.pdf');

       
    }


    public function rpt_factura(Venta $venta)
    {
        $id = $venta->id;

        $query = "SELECT S.serie as serie ,  F.numero as numero, F.total as total
        from facturas F
        inner join series S on S.id = F.serie_id
        where F.venta_id =".$id.'';
        $facturas = DB::select($query);

        $query2 = "SELECT vd.venta_id as No_Venta, vd.id, 	
        IF(vd.producto_id>0,pr.nombre, if(vd.servicio_id>0,sr.nombre, vd.detalle_mano_obra)) as nombre, 
        vd.cantidad as cantidad, vd.subtotal as subtotal
        FROM ventas_detalle vd
        LEFT JOIN productos pr ON vd.producto_id=pr.id
        LEFT JOIN servicios sr ON vd.servicio_id=sr.id
        where venta_id=".$id.'';
        $detalle = DB::select($query2);

        $query3 = "SELECT concat(C.nombres ,' ' ,C.apellidos) as nombres, C.nit, C.direccion 
        FROM clientes C
        inner join ventas_maestro V on V.cliente_id = C.id
        where V.id=".$id.'';
        $cliente = DB::select($query3);
       

    
        $pdf = PDF::loadView('pdf.rpt_facturas', compact('facturas','detalle', 'cliente'));
        return $pdf->stream('Factura.pdf');

     
    }
    public function rpt_salida(Venta $venta)
    {
        $id = $venta->id;

        $query2 = "SELECT ifnull( pr.codigo_barra,'N/A') as codigo ,vd.venta_id as No_Venta, vd.id, 	
        IF(vd.producto_id>0,pr.nombre, if(vd.servicio_id>0,sr.nombre, vd.detalle_mano_obra)) as nombre, ifnull (l.nombre,'N/A') as localidad,
        vd.cantidad as cantidad, vd.subtotal as total
        FROM ventas_detalle vd
        LEFT JOIN productos pr ON vd.producto_id=pr.id
        LEFT JOIN servicios sr ON vd.servicio_id=sr.id
        LEFT JOIN localidades l on pr.localidad_id=l.id
        where venta_id=".$id.'';
        $detalle = DB::select($query2);

        $query3 = "SELECT concat(C.nombres ,' ' ,C.apellidos) as nombres, C.nit, C.direccion 
        FROM clientes C
        inner join ventas_maestro V on V.cliente_id = C.id
        where V.id=".$id.'';
        $cliente = DB::select($query3);
       

    
        $pdf = PDF::loadView('pdf.rpt_salidas', compact('detalle', 'cliente','venta'));
        $pdf->setPaper(array(0, 0, 300, 350), 'portrait');
        return $pdf->stream('Vale_Salida.pdf');

     
    }

    public function getDataOrdenTrabajo($id) 
    {
        $query = "SELECT ot.id, ot.resp_recepcion, ot.fecha_hora, ot.fecha_prometida, ot.total, CONCAT(c.nombres,' ', c.apellidos) as nombrecliente, 
        l.linea , col.color, v.anio as año, v.no_motor as chasis, v.placa, v.kilometraje, m.nombre as marca, d.tipo_direccion,
        t.transmision, tra.traccion, v.diferenciales, tc.tipo_caja, v.aceite_caja_fabrica, v.aceite_caja, v.cantidad_aceite_caja,
        v.viscosidad_caja, com.combustible, v.ccs, v.cilindros, v.aceite_motor_fabrica, v.aceite_motor, v.cantidad_aceite_motor,
        v.viscosidad_motor,v.vin, v.fecha_ultimo_servicio, tv.nombre as tipo_vehiculo, c.email, c.nit, c.telefonos  
        FROM ordenes_de_trabajo ot 
        INNER JOIN clientes c on c.id = ot.cliente_id
        INNER JOIN vehiculos v on v.id = ot.vehiculo_id
        INNER JOIN marcas m on m.id = v.marca_id
        INNER JOIN linea l on l.id = v.linea_id
        INNER JOIN colores col on col.id = v.color_id
        INNER JOIN direccion d on d.id = v.direccion_id
        INNER JOIN transmision t on t.id = v.transmision_id
        INNER JOIN  tracciones tra on tra.id = v.traccion_id
        INNER JOIN tipos_caja tc on tc.id = v.tipo_caja_id
        INNER JOIN combustible com on com.id = v.combustible_id
        INNER JOIN tipos_vehiculo tv on tv.id = v.tipo_vehiculo_id
        WHERE ot.id =".$id.'';
        $data = DB::select($query);
        return $data;
    }

}
