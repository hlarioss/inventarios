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
Use App\User;
Use App\CorteCaja;


class CortesCajaController extends Controller
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
        return view ("cortes_caja.index");
    }
    public function index2()
    {
        return view ("cortes_caja.index2");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $user = Auth::user()->id;
       return view("cortes_caja.create" , compact( "user" ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       

        $data = $request->all();
        $corte_caja = CorteCaja::create($data);

        return Response::json($corte_caja);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CorteCaja $corte_caja)
    {
        $query = "SELECT * FROM cortes_caja WHERE id=".$corte_caja->id."";
        $fieldsArray = DB::select($query);

        return view('cortes_caja.edit', compact('corte_caja', 'fieldsArray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CorteCaja $corte_caja, Request $request)
    {
        $this->validate($request,['nit' => 'required|unique:cortes_caja,nit,'.$corte_caja->id
        ]);
        Response::json( $this->updateCorteCaja($corte_caja , $request->all()));
        return redirect('/cortes_caja');
    }

    public function updateCorteCaja(CorteCaja $corte_caja, array $data )
    {
        $id= $corte_caja->id;
        $corte_caja->nit = $data["nit"];
        $corte_caja->nombre = $data["nombre"];
        $corte_caja->telefonos = $data["telefonos"];
        $corte_caja->direccion = $data["direccion"];
        $corte_caja->save();

        return $corte_caja;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CorteCaja $corte_caja, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $corte_caja->id;
            $corte_caja->delete();
            
            $response["response"] = "El tipo corte_caja ha sido eliminado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }

    public function getEfectivo(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as efectivo FROM ventas_maestro v
            INNER JOIN facturas f on v.id = f.venta_id
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'
            AND v.tipo_pago_id = 1 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    
    public function getTarjeta(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as tarjeta FROM ventas_maestro v 
            INNER JOIN facturas f on v.id = f.venta_id
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'
            AND v.tipo_pago_id = 2 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getCredito(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as credito FROM ventas_maestro v 
            INNER JOIN facturas f on v.id = f.venta_id
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'
            AND v.tipo_pago_id = 3 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getTotal(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as total FROM ventas_maestro v 
            INNER JOIN facturas f on v.id = f.venta_id
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59' limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }

    public function getEfectivoSF(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as efectivo FROM ventas_maestro v
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'
            AND v.tipo_venta_id = 0
            AND v.tipo_pago_id = 1 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getTarjetaSF(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as tarjeta FROM ventas_maestro v 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'
            AND v.tipo_venta_id = 0
            AND v.tipo_pago_id = 2 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getCreditoSF(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as credito FROM ventas_maestro v 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'
            AND v.tipo_venta_id = 0
            AND v.tipo_pago_id = 3 limit 1";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getTotalSF(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as total FROM ventas_maestro v 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59' 
            AND v.tipo_venta_id = 0 limit 1";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }

    public function getTotalVenta(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as total FROM ventas_maestro v 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59' limit 1";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }

    public function getFacturas(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT MIN(f.numero) as factura_inicial, MAX(f.numero) as factura_final FROM ventas_maestro v 
            INNER JOIN facturas f on v.id = f.venta_id 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59' limit 1";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function corteUnico()
	{
		$dato = Input::get("fecha");
		$query = CorteCaja::where("fecha", $dato)->whereNull('user_id')->get();
		$contador = count($query);
		if ($contador == 0)
		{
			return 'false';
		}
		else
		{
			return 'true';
		}
    }
    
    public function getEfectivo2(Request $request)
	{
		$fecha = $request->fecha;
        $user_id= $request->user_id;
		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as efectivo FROM ventas_maestro v
            INNER JOIN facturas f on v.id = f.venta_id
            where (v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59') and v.user_id=".$user_id."
            AND v.tipo_pago_id = 1 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    public function getTarjeta2(Request $request)
	{
        $fecha = $request->fecha;
        $user_id= $request->user_id;
		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as tarjeta FROM ventas_maestro v 
            INNER JOIN facturas f on v.id = f.venta_id
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59' and v.user_id=".$user_id."
            AND v.tipo_pago_id = 2 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getCredito2(Request $request)
	{
		$fecha = $request->fecha;
        $user_id= $request->user_id;

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as credito FROM ventas_maestro v 
            INNER JOIN facturas f on v.id = f.venta_id
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59' and v.user_id=".$user_id."
            AND v.tipo_pago_id = 3 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getTotal2(Request $request)
	{
		$fecha = $request->fecha;
        $user_id= $request->user_id;

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as total FROM ventas_maestro v 
            INNER JOIN facturas f on v.id = f.venta_id
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'  and v.user_id=".$user_id." limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }

    public function getEfectivoSF2(Request $request)
	{
        $fecha = $request->fecha;
        $user_id= $request->user_id;

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as efectivo FROM ventas_maestro v
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'  and v.user_id=".$user_id."
            AND v.tipo_venta_id = 0
            AND v.tipo_pago_id = 1 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getTarjetaSF2(Request $request)
	{
		$fecha = $request->fecha;
        $user_id= $request->user_id;

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as tarjeta FROM ventas_maestro v 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'  and v.user_id=".$user_id."
            AND v.tipo_venta_id = 0
            AND v.tipo_pago_id = 2 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getCreditoSF2(Request $request)
	{
        $fecha = $request->fecha;
        $user_id= $request->user_id;

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as credito FROM ventas_maestro v 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59' and v.user_id=".$user_id."
            AND v.tipo_venta_id = 0
            AND v.tipo_pago_id = 3 limit 1";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getTotalSF2(Request $request)
	{
        $fecha = $request->fecha;
        $user_id= $request->user_id;

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as total FROM ventas_maestro v 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59' and v.user_id=".$user_id." 
            AND v.tipo_venta_id = 0 limit 1";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }

    public function getTotalVenta2(Request $request)
	{
		$fecha = $request->fecha;
        $user_id= $request->user_id;

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as total FROM ventas_maestro v 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59' and v.user_id=".$user_id." limit 1";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }

    public function getFacturas2(Request $request)
	{
		$fecha = $request->fecha;
        $user_id= $request->user_id;

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT MIN(f.numero) as factura_inicial, MAX(f.numero) as factura_final FROM ventas_maestro v 
            INNER JOIN facturas f on v.id = f.venta_id 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59' and v.user_id=".$user_id." limit 1";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }

    public function getJson(Request $params)
    {
        $query = "SELECT * FROM cortes_caja where user_id is null";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
    public function getJson2(Request $params)
    {
        $query = "SELECT c.id,c.fecha,c.factura_inicial,c.factura_final,c.total,c.efectivo,c.credito,c.voucher,c.totalSF,c.efectivoSF,
        c.creditoSF,c.voucherSF,c.total_venta, u.name FROM cortes_caja c
        inner join users u on c.user_id = u.id
        where user_id is not null";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
    public function rpt_generar_corte()
    {
        $query = "SELECT u.name,u.id
        FROM ventas_maestro v
        inner join users u on u.id=v.user_id
        group by u.name,u.id";

        $empleados = DB::select($query);
        return view("cortes_caja.rptGenerarcortediario",compact('empleados'));
    }
    //funcion para obtener datos del corte diario y generar pdf
    public function rpt_corte(Request $request)
    {
        $fecha_inicial = $request['fecha_inicial'];
        dd($request->empleado_id);
        $fecha_final = $request['fecha_final'];

        $query = "SELECT l.nombre as ubicacion, k.id, DATE_FORMAT(k.fecha, '%d-%m-%Y') as fecha , p.codigo_barra, p.nombre, k.transaccion, k.ingreso, k.salida, k.existencia_anterior, k.saldo
		FROM kardex k
		INNER JOIN productos p on p.id = k.producto_id
		LEFT JOIN localidades l on p.localidad_id = l.id
		WHERE k.fecha BETWEEN '".$fecha_inicial."' AND '".$fecha_final." 23:59:59' ";
        $detalles = DB::select($query);

        $fecha_inicial = Carbon::parse($fecha_inicial)->format('d/m/Y');
        $fecha_final = Carbon::parse($fecha_final)->format('d/m/Y');
    
        $pdf = PDF::loadView('pdf.rpt_kardex_prod_total', compact('detalles', 'fecha_inicial', 'fecha_final'));
        return $pdf->stream('Kardex de Producto.pdf');
    }

    public function index3()
    {
        return view ("cortes_caja.rptReporteVenta");
    }
    public function getJson3($inicial,$final)
    {
            $query = "SELECT  sum(c.total) total,sum(c.efectivo) efectivo,sum(c.credito) credito,sum(c.voucher) voucher,sum(c.totalSF) totalSF,sum(c.efectivoSF) efectivoSF,
            sum(c.creditoSF) creditoSF,sum(c.voucherSF) voucherSF,sum(c.total_venta) total_venta FROM cortes_caja c
            where c.fecha BETWEEN '".$inicial."' AND '".$final." 23:59:59' ";
    
            $result = DB::select($query);
            $api_Result['data'] = $result;
    
            return Response::json( $api_Result );
    }
    
}
