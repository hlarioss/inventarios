<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\IngresoProducto;
use App\User;
use App\Producto;
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

class IngresosProductoController extends Controller
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
        return view ("ingresos_productos.index", compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$productos = Producto::all();
		return view("ingresos_productos.create" , compact("productos") );
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

			$ingreso_producto = new IngresoProducto();

			$ingreso_producto->fecha_ingreso = Carbon::now();
			$ingreso_producto->producto_id = $stat["producto_id"];
			$ingreso_producto->user_id = Auth::user()->id;
			$ingreso_producto->precio_compra = $stat["precio_compra"];
			$ingreso_producto->precio_venta = $stat["precio_venta"];
			$ingreso_producto->cantidad = $stat["cantidad"];

			$stat["existencias"] = $ingreso_producto->cantidad;
			$stat["fecha_ingreso"] = $ingreso_producto->fecha_ingreso;


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
			$costo_salida=$costo_ponderado*($stat['cantidad']);
			$costo_anterior=$costo_ponderado*$existencia_anterior;
			$costo_acumulado=$costo_entrada+$costo_anterior-$costo_salida;

		//event(new ActualizacionProducto($stat["producto_id"], 'Ajuste Salida', 0,$stat["cantidad_salida"], $existencia_anterior, $existencia_anterior - $stat["cantidad_salida"]));
		event(new ActualizacionProducto($stat["producto_id"], 'Ajuste Salida', 0,($stat["cantidad"]), $existencia_anterior, $existencia_anterior - $stat["cantidad"],$stat["precio_compra"],$costo_ponderado,$costo_entrada,$costo_salida,$costo_anterior,$costo_acumulado ));
		$detalle = MovimientoProducto::create($stat);
			$ingreso_producto->movimiento_producto_id = $detalle->id;
			$ingreso_producto->save();			
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
	public function edit(IngresoProducto $ingreso_producto)
	{
		$query = "SELECT * FROM ingresos_productos WHERE id=".$ingreso_producto->id."";
		$fieldsArray = DB::select($query);
		
        return view ("ingresos_productos.edit", compact('ingreso_producto', 'fieldsArray'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function update(IngresoProducto $ingreso_producto, Request $request )
	{
		Response::json($this->updateIngresoProducto($ingreso_producto , $request->all()));
        return redirect('/ingresos_productos');
	}



	public function updateIngresoProducto(IngresoProducto $ingreso_producto, array $data )
	{

		$ingreso_producto->precio_compra = $data["precio_compra"];
		$ingreso_producto->precio_venta = $data["precio_venta"];
		$ingreso_producto->cantidad = $data["cantidad"];
		

		//kardex
		$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $ingreso_producto->producto_id )->sum( "existencias");

		if($existencia_anterior == null){
			$existencia_anterior = 0;
		};

		$mIngreso = MovimientoProducto::where( "id" , "=" , $ingreso_producto->movimiento_producto_id)->first();
		$ingreso_anterior = $mIngreso->existencias;

		$diferencia = $ingreso_anterior - $data['cantidad'];

		if ($diferencia > 0 ){
			event(new ActualizacionProducto($ingreso_producto->producto_id, 'Ingreso Modificado -', 0,$diferencia, $existencia_anterior, $existencia_anterior - $diferencia));
		}
		else{
			$diferencia = $diferencia * -1;
			event(new ActualizacionProducto($ingreso_producto->producto_id, 'Ingreso Modificado +', $diferencia,0, $existencia_anterior, $existencia_anterior + $diferencia));
		}

		$ingreso_producto->save();
			$updateExistencia = MovimientoProducto::where('id', $ingreso_producto->movimiento_producto_id)
			->update(
				['existencias' => $data["cantidad"],
				 'precio_compra' => $data["precio_compra"],
				 'precio_venta' => $data["precio_venta"]
				]);

		return $ingreso_producto;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( IngresoProducto $ingreso_producto,  Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{

			$producto = MovimientoProducto::where('id', $ingreso_producto->movimiento_producto_id)->get()->first();

			//kardex
			$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $producto->producto_id )->sum( "existencias");

			if($existencia_anterior == null){
				$existencia_anterior = 0;
			};

			$salida = $ingreso_producto->cantidad;

			event(new ActualizacionProducto($producto->producto_id, 'Ingreso Borrado', 0,$salida, $existencia_anterior, $existencia_anterior - $salida));

			//Movimiento Producto
			$newExistencias = 0;
			$updateExistencia = MovimientoProducto::where('id', $ingreso_producto->movimiento_producto_id)
			->update(['existencias' => $newExistencias]);

			$ingreso_producto->delete();
			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}

	public function getJson(Request $params)

	{
		$query = 'SELECT i.id, DATE_FORMAT(i.fecha_ingreso, "%d-%m-%Y") as fecha_ingreso, i.precio_compra, i.precio_venta, i.cantidad, p.nombre, mp.vendido 
		FROM ingresos_productos i 
		INNER JOIN productos p on p.id = i.producto_id
		INNER JOIN movimientos_productos mp on mp.id = i.movimiento_producto_id ';

		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}
}
