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
Use App\DetalleCajaChica;
Use App\CajaChica;
Use App\User;

class CajasChicasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view ("cajas_chicas.index");
    }

    public function newegreso()
    {
		return view("cajas_chicas.egreso");
    }

    public function newingreso()
    {
		return view("cajas_chicas.ingreso");
    }


    public function saveegreso(Request $request)
	{
        $data = $request->all();

        $caja_chica = CajaChica::where('id', 1)->first();

            $detalle = array(
                'documento' => $data["documento"],
                'fecha' => Carbon::now(),
                'descripcion' => $data["descripcion"],
                'ingreso' => 0,	
                'gasto' => $data["total"],
                'saldo' => $caja_chica->saldo - $data["total"],
                'user_id' => Auth::user()->id
            );					

            $caja_chica->detalles_cajas_chicas()->create($detalle);
            $newtotal = $detalle['saldo'];
            $caja_chica->update(['saldo' => $newtotal]);        

		return Response::json($caja_chica);
    }

    public function saveingreso(Request $request)
	{
		$data = $request->all();

        $caja_chica = CajaChica::where('id', 1)->first();

            $detalle = array(
                'documento' => $data["documento"],
                'fecha' => Carbon::now(),
                'descripcion' => $data["descripcion"],
                'ingreso' => $data["total"],	
                'gasto' => 0,
                'saldo' => $caja_chica->saldo + $data["total"],
                'user_id' => Auth::user()->id
            );					

            $caja_chica->detalles_cajas_chicas()->create($detalle);
            $newtotal = $detalle['saldo'];
            $caja_chica->update(['saldo' => $newtotal]);        

		return Response::json($caja_chica);
	}


    public function show(CajaChica $cuenta_por_pagar)
    {
        //return view('cajas_chicas.show')->with('cuenta_por_pagar', $cuenta_por_pagar);
    }

    public function getSaldo()
	{
		$dato = Input::get("total");
		$query = CajaChica::where("saldo", '<', $dato)->get();
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

    public function getJson(Request $params)
    {
        $id = 1;

        $query = 'SELECT dc.id, dc.documento, dc.fecha, dc.descripcion, dc.gasto, dc.ingreso, dc.saldo FROM detalles_cajas_chicas dc where dc.caja_chica_id ='.$id.' ';

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }

}
