<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use App\SalidaProducto;
use App\User;
use App\Producto;
use App\TipoSalida;
use App\MovimientoProducto;
use View;
Use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kodeine\Acl\Models\Eloquent\Role;
use Kodeine\Acl\Models\Eloquent\Permission;
use Carbon\Carbon;
use App\Events\ActualizacionProducto;

class SalidaProductoController extends Controller
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
        $productos = Producto::all();
        return view ("salidas_productos.index", compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$productos = Producto::all();
		$tipos_salida = TipoSalida::all();
		return view("salidas_productos.create" , compact("productos", 'tipos_salida') );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
	{
		try{
			DB::beginTransaction();

			$statsArray = $request->all();
			

			foreach($statsArray as $stat) {


			$salida_producto = new SalidaProducto();

			$salida_producto->fecha_salida = Carbon::now();
			$salida_producto->producto_id = $stat["producto_id"];
			$salida_producto->user_id = Auth::user()->id;
			$salida_producto->cantidad_salida = $stat["cantidad_salida"];
			$salida_producto->tipo_salida_id = $stat["tipo_salida_id"];

			$mp = MovimientoProducto::where('producto_id', $salida_producto->producto_id)->first();
			$existenciaanterior = $mp->existencias;

			$stat["existencias"] = $existenciaanterior - $salida_producto->cantidad_salida;
			$stat["fecha_salida"] = $salida_producto->fecha_salida;
			$stat["vendido"] = 1;

			//kardex
			$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $stat["producto_id"] )->sum( "existencias");
			if($existencia_anterior == null){
				$existencia_anterior = 0;
			};  
			$costo_ponderado=0;
				if ($existencia_anterior==0) {
					$costo_ponderado=$stat["precio_compra"];
				} else {
					$query = " SELECT k.saldo as saldo,k.costo_acumulado as acumulado
					FROM kardex k
					where k.producto_id=".$stat['producto_id']."  
					order by k.id desc
					limit 1";
					$datos = DB::select($query);
					$costo_ponderado=$datos[0]->acumulado/$datos[0]->saldo;
					
				}
				$costo_entrada=0*$stat["precio_compra"];
				$costo_salida=$costo_ponderado*($stat['cantidad_salida']);
				$costo_anterior=$costo_ponderado*$existencia_anterior;
				$costo_acumulado=$costo_entrada+$costo_anterior-$costo_salida;

			//event(new ActualizacionProducto($stat["producto_id"], 'Ajuste Salida', 0,$stat["cantidad_salida"], $existencia_anterior, $existencia_anterior - $stat["cantidad_salida"]));
			event(new ActualizacionProducto($stat["producto_id"], 'Ajuste Salida', 0,($stat["cantidad_salida"]), $existencia_anterior, $existencia_anterior - $stat["cantidad_salida"],$stat["precio_compra"],$costo_ponderado,$costo_entrada,$costo_salida,$costo_anterior,$costo_acumulado ));

			$mp->update($stat);
			$salida_producto->movimiento_producto_id = $mp->id;
			$salida_producto->save();			
		}

		DB::commit();
		return Response::json(['result' => 'ok']);
		
		}

		catch(Exception $e)
		{
            DB::rollBack();
		}
			
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(SalidaProducto $salida_producto)
	{
		$tipos_salida = TipoSalida::all();
		$query = "SELECT * FROM salidas_productos WHERE id=".$salida_producto->id."";
		$fieldsArray = DB::select($query);
		
        return view ("salidas_productos.edit", compact('salida_producto', 'fieldsArray', 'tipos_salida'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function update(SalidaProducto $salida_producto, Request $request )
	{
		Response::json($this->updateSalidaProducto($salida_producto , $request->all()));
        return redirect('/salidas_productos');
	}



	public function updateSalidaProducto(SalidaProducto $salida_producto, array $data )
	{
		$cantidad_anterior = $salida_producto->cantidad_salida;
		$salida_producto->cantidad_salida = $data["cantidad_salida"];
		$salida_producto->tipo_salida_id = $data["tipo_salida_id"];
		$salida_producto->save();


		$mp = MovimientoProducto::where('id', $salida_producto->movimiento_producto_id)->first();

		$nuevaexistencia = $mp->existencias + $cantidad_anterior - $data["cantidad_salida"];

			$mp->update(
				['existencias' => $nuevaexistencia]);

		return $salida_producto;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( SalidaProducto $salida_producto,  Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{

			$mp = MovimientoProducto::where('id',$salida_producto->movimiento_producto_id)->first();

			//kardex
			$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $mp->producto_id )->sum( "existencias");

			if($existencia_anterior == null){
				$existencia_anterior = 0;
			};

			$salida = $salida_producto->cantidad_salida;

			event(new ActualizacionProducto($mp->producto_id, 'Salida Borrada', $salida, 0, $existencia_anterior, $existencia_anterior + $salida));

			//Movimiento Producto
			$newExistencias = $mp->existencias + $salida_producto->cantidad_salida;
			$mp->update(['existencias' => $newExistencias]);

			$salida_producto->delete();
			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}

	public function getExistencia()
	{
		$dato = Input::get("cantidad_salida");
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
		
		$query = 'SELECT s.id, DATE_FORMAT(s.fecha_salida, "%d-%m-%Y") as fecha_salida, s.cantidad_salida, p.nombre, ts.tipo_salida 
		FROM salidas_productos s 
		INNER JOIN productos p on p.id = s.producto_id  
		INNER JOIN tipos_salida ts on ts.id = s.tipo_salida_id ';
		
		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}

}
