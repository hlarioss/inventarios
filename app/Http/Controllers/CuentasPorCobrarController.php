<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
Use App\CuentasPorCobrar;
Use App\sDetalle;
Use App\Venta;
Use App\Cliente;
use Barryvdh\DomPDF\Facade as PDF;
use App\CuentaPorCobrarDetalle;

class CuentasPorCobrarController extends Controller
{
    
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view ("cuentas_por_cobrar.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notacredito()
    {
        $clientes = DB::table('clientes')
        ->join('cuentas_por_cobrar', 'clientes.id', '=' ,'cuentas_por_cobrar.cliente_id')
        ->select('clientes.id', 'clientes.nombres', 'clientes.apellidos')
        ->get();
        
		return view("cuentas_por_cobrar.ncredito" , compact('clientes'));
    }

    public function notadebito()
    {
        $clientes = Cliente::All();
		return view("cuentas_por_cobrar.ndebito" , compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savenotacredito(Request $request)
	{
        $data = $request->all();

        $cuentasporcobrar = CuentasPorCobrar::where('cliente_id',$data["cliente_id"])->first();
        $cuenta_id=$cuentasporcobrar["id"];
        

        if($cuentasporcobrar)
        {
            $detalle = array(
            
                'num_factura' => 'Rec-'.$data['no_factura'],
                'cuentas_por_cobrar_id' => $cuenta_id,
                'fecha' =>  $data['fecha_documento'],
                'descripcion' => 'Nota de Credito',
                'cargos' => 0,	
                'abonos' => $data["total"],
                'saldo' => $cuentasporcobrar->total - $data["total"]
            );					
    
            $cuenta2 = new CuentaPorCobrarDetalle;
            $cuenta2->create($detalle);
            $newtotal = $detalle['saldo'];
            $cuentasporcobrar->update(['total' => $newtotal]);

            return Response::json($cuentasporcobrar);
        }
        else
        {
            return Response::json($cuentasporcobrar);
        }		

    }
    
    public function savenotadebito(Request $request)
	{
		$data = $request->all();

        $cuentasporcobrar = CuentasPorCobrar::where('cliente_id',$data["cliente_id"])->first();
        $cuenta_id=$cuentasporcobrar["id"];

        if($cuentasporcobrar)
        {
            $detalle = array(
                'num_factura' => 'Rec-'.$data['no_factura'],
                'cuentas_por_cobrar_id' => $cuenta_id,
                'fecha' => $data['fecha_documento'],
                'descripcion' => 'Nota de Debito',
                'cargos' => $data["total"],	
                'abonos' => 0,
                'saldo' => $cuentasporcobrar->total + $data["total"]
            );					
            $cuenta2 = new CuentaPorCobrarDetalle;
            $cuenta2->create($detalle);
            $newtotal = $detalle['saldo'];
            $cuentasporcobrar->update(['total' => $newtotal]);              
        }

        else
        {
            $detalle = array(
                'num_factura' => 'Rec-'.$data['no_factura'],
                'fecha' => $data['fecha_documento'],
                'descripcion' => 'Nota de Debito',
                'cargos' => $data["total"],	
                'abonos' => 0,
                'saldo' => $data["total"]
            );
            
            $cuentasporcobrar = new CuentasPorCobrar;
            $cuentasporcobrar->total = $data["total"];
            $cuentasporcobrar->cliente_id = $data["cliente_id"];
            $cuentasporcobrar->save();

            $cuentasporcobrar->cuentas_por_cobrar_detalle()->create($detalle);

        }

        return Response::json($cuentasporcobrar);
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CuentasPorCobrar $cuenta_por_cobrar)
    {
        return view('cuentas_por_cobrar.show')->with('cuenta_por_cobrar', $cuenta_por_cobrar);
    }

    public function getJson(Request $params)
    {
        $query = "SELECT cpc.id, cpc.cliente_id, cpc.total, concat( c.nombres,' ', c.apellidos) as nombre FROM cuentas_por_cobrar cpc 
        INNER JOIN clientes c on c.id = cpc.cliente_id";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }

    public function getJsonDetalle(Request $params, $detalle)
	{
		$query = 'SELECT dc.id, if(dc.venta_id is null, 0,dc.venta_id)as cventa_id, dc.num_factura, dc.fecha,dc.descripcion ,dc.cargos, dc.abonos, dc.saldo
		FROM cuentas_por_cobrar_detalle dc
		INNER JOIN cuentas_por_cobrar cpc on cpc.id = dc.cuentas_por_cobrar_id
		WHERE dc.cuentas_por_cobrar_id ='.$detalle.'';

		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
    }
    
    public function rpt_estado_cuenta_por_cobrar(Request $request)
    {
        $idCliente = $request['cliente_id'];
        $fecha_inicial = $request['fecha_inicial'];
        $fecha_final = $request['fecha_final'];

        $query = "SELECT dc.id, if(dc.venta_id is null, 0,dc.venta_id)as venta_id, dc.num_factura, DATE_FORMAT(dc.fecha, '%d-%m-%Y') as fecha, dc.descripcion, dc.cargos, dc.abonos, dc.saldo
		FROM cuentas_por_cobrar_detalle dc
		INNER JOIN cuentas_por_cobrar cpc on cpc.id = dc.cuentas_por_cobrar_id
		WHERE cpc.cliente_id = '".$idCliente."' AND dc.fecha BETWEEN '".$fecha_inicial."' AND '".$fecha_final." 23:59:59' ";
        $detalles = DB::select($query);

        $query2 = "SELECT c.nombres, c.apellidos FROM clientes c WHERE c.id = '".$idCliente."' ";
        $cliente = DB::select($query2);

        $fecha_inicial = Carbon::parse($fecha_inicial)->format('d/m/Y');
        $fecha_final = Carbon::parse($fecha_final)->format('d/m/Y');
    
        $pdf = PDF::loadView('pdf.rpt_estado_cuenta_por_cobrar', compact('detalles', 'fecha_inicial', 'fecha_final', 'cliente'));
        return $pdf->stream('Estado Cuenta por Cobrar.pdf');
    }
    
    public function rpt_generar()
    {
        $clientes = Cliente::all();
        return view("cuentas_por_cobrar.rptGenerar", compact('clientes'));
    }

    public function rpt_estado_cuenta_por_cobrarTotal(Request $request)
    {
        $fechacompleta = Carbon::now();
        $fecha = Carbon::parse($fechacompleta)->format('d/m/Y');

        $query = "SELECT cpc.id, cpc.cliente_id, cpc.total, concat(c.nombres,' ',c.apellidos) as nombres FROM cuentas_por_cobrar cpc 
        INNER JOIN clientes c on c.id = cpc.cliente_id ";
        $detalles = DB::select($query);

        $query2 = "SELECT sum(cpc.total) as total FROM cuentas_por_cobrar cpc ";
		$total_general = DB::select($query2);
    
        $pdf = PDF::loadView('pdf.rpt_estado_cuenta_por_cobrar_total', compact('detalles', 'fecha', 'total_general'));
        return $pdf->stream('Estado Cuenta por Cobrar.pdf');
    }
}
