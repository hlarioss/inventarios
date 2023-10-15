<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Producto;
use App\TipoPago;
use App\Venta;
use App\VentaDetalle;
use App\Servicio;
use App\Cliente;
Use App\TipoCliente;
use App\ClasificacionCliente;
use App\CuentasPorCobrar;
use App\CuentaPorCobrarDetalle;
use App\MovimientoProducto;
Use App\Serie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;
use Barryvdh\DomPDF\Facade as PDF;
use App\Events\ActualizacionProducto;
class VentasController extends Controller
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
		$tipo_pagos = TipoPago::all();
		return view("venta.index", compact("tipo_pagos"));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$back = "producto";
		$today = date("Y/m/d");
		$tipo_pagos = TipoPago::all();
		$servicios = Servicio::all();
		$clientes=Cliente::all();
		$tipos_clientes = TipoCliente::all();
		$clasificaciones = ClasificacionCliente::all();
		$series = Serie::all();
		$productos = Producto::all();
		
		return view("venta.create" , compact( "productos","back", "tipo_pagos",'series',"today",'servicios','tipos_clientes', 'clasificaciones', 'clientes'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function save(Request $request)
	{
		$data = $request->all();
		if(empty ($data['cliente_id'])){
			$data["cliente_id"]=1;
		}
		$data["user_id"] = Auth::user()->id;
		$data["edo_venta_id"] = 1;
		$data["tipo_venta_id"] = 0;
		$maestro = Venta::create($data);
		
		return $maestro;
	}
	public function getInfo(Request $request)
	{
		$movimiento = $request["data"];
		$query = "SELECT VD.cantidad as cantidad , M.existencias as existencia
					from ventas_detalle VD
					left join movimientos_productos M on VD.movimiento_producto_id = M.id
					where VD.id= ".$movimiento."";
				$result = DB::select($query);
				return Response::json( $result);
	}

	public function ccobrar(Request $request){
		$data = $request->all();
		$maestro = $data["venta_maestro_id"];

		$existeCuentaCliente = CuentasPorCobrar::where('cliente_id',$request["cliente_id"])->first();
		
		$cuenta_id=$existeCuentaCliente["id"];
		
		if($existeCuentaCliente){

			$detalle1 = array(
				
				'venta_id' => $maestro,
				'cuentas_por_cobrar_id' => $cuenta_id,
				'num_factura' => 'Fac-'.$request["num_factura"],
				'fecha' => $request["fecha_venta"],
				'descripcion' => 'Venta',
				'cargos' => $request["total_venta"],	
				'abonos' => 0,
				'saldo' => $existeCuentaCliente->total + $request["total_venta"]
			);					
			$cuenta3 = new CuentaPorCobrarDetalle;	
			$cuenta3->create($detalle1);
			$newtotal = $detalle1['saldo'];
			$existeCuentaCliente->update(['total' => $newtotal]);
			return Response::json($detalle1);
		}

		else{
			$cuenta = new CuentasPorCobrar;
			$cuenta->total = $request["total_venta"];
			$cuenta->cliente_id = $request["cliente_id"];
			$cuenta->save();
			$cuenta_id=$cuenta["id"];
					
			$detalle = array(
				'venta_id'=>$maestro,
				'cuentas_por_cobrar_id'=>$cuenta_id,
				'num_factura'=> 'Fac-'.$data["num_factura"],
				'fecha'=>$request["fecha_venta"],
				'descripcion'=> 'Venta',
				'cargos'=>$request["total_venta"],	
				'abonos'=> 0,
				'saldo'=>$request["total_venta"]
			);							
			$cuenta2 = new CuentaPorCobrarDetalle;
			$cuenta2->create($detalle);
			return Response::json($cuenta2);
		}	
	}

	public function saveDetalle(Request $request, Venta $venta_maestro)
	{
		$statsArray = $request->all();
		foreach($statsArray as $stat) {
			if(empty ($stat['producto_id']) && empty ($stat['servicio_id']) ){
				
				$stat["cantidad"] = 1;
				$stat["precio_compra"] = 0;
				$stat["precio_venta"] = $stat["precio_venta"];
				$stat["subtotal"] = $stat["precio_venta"];
				$stat["detalle_mano_obra"] = $stat["nombre"];
								
				$result = $venta_maestro->ventadetalle()->create($stat);
				$total_venta = $venta_maestro->total_venta + $stat["subtotal"];
				$venta_maestro->total_venta = $total_venta;
				$venta_maestro->save();
				$cantidad = $stat["cantidad"];
					
			}else if(empty ($stat['producto_id'])){
				
				$stat["precio_compra"] = 0;
				$stat["precio_venta"] = $stat["precio_venta"];
				$stat["servicio_id"] = $stat["servicio_id"];
				$stat["subtotal"] = $stat["subtotal_venta"];
				$result = $venta_maestro->ventadetalle()->create($stat);
				$total_venta = $venta_maestro->total_venta + $stat["subtotal"];
				$venta_maestro->total_venta = $total_venta;
				$venta_maestro->save();
				$cantidad = $stat["cantidad"];
					
			}else{
				$producto = MovimientoProducto::where('id', $stat["movimiento_id"])->get()->first();
				$stat["precio_compra"] = $stat["precio_compra"];
				$stat["precio_venta"] = $stat["precio_venta"];
				$stat["subtotal"] = $stat["precio_venta"] * $stat["cantidad"];
				$stat["movimiento_producto_id"] = $stat["movimiento_id"];
				$result = $venta_maestro->ventadetalle()->create($stat);
				$total_venta = $venta_maestro->total_venta + $stat["subtotal"];
				$venta_maestro->total_venta = $total_venta;
				$venta_maestro->save();
				$existencias = $producto->existencias;
				$paquete = $producto->paquete;
				$cantidad = $stat["cantidad"];
				$cantidadu = $stat["cantidadu"];
				$newExistencias = $existencias - ($cantidad*$cantidadu);
				$newpaquete = $paquete - $cantidad;
				
				//kardex
				$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $producto->producto_id )
				->sum( "existencias");

				if($existencia_anterior == null){
					$existencia_anterior = 0;
				};
				
				$costo_ponderado=0;
				if ($existencia_anterior==0) {
					$costo_ponderado=$stat["precio_compra"];
				} else {
					$query = " SELECT k.saldo as saldo,k.costo_acumulado as acumulado
					FROM kardex k
					where k.producto_id=".$producto->producto_id."
					order by k.id desc
					limit 1";
					$datos = DB::select($query);
					$costo_ponderado=$datos[0]->acumulado/$datos[0]->saldo;
				}
				
				$costo_entrada=0*$stat["precio_compra"];
				$costo_salida=$costo_ponderado*($stat['cantidad']*$stat['cantidadu']);
				$costo_anterior=$costo_ponderado*$existencia_anterior;
				$costo_acumulado=$costo_entrada+$costo_anterior-$costo_salida;
				


				event(new ActualizacionProducto($producto->producto_id, 'Venta', 0,($stat['cantidad']*$stat['cantidadu']), $existencia_anterior, $existencia_anterior - ($stat['cantidad']*$stat['cantidadu']),$stat["precio_compra"],$costo_ponderado,$costo_entrada,$costo_salida,$costo_anterior,$costo_acumulado ));

				$updateExistencia = MovimientoProducto::where('id', $stat["movimiento_id"])
				->update(['existencias' => $newExistencias, 'vendido' => 1]);
				$updateExistencia = MovimientoProducto::where('id', $stat["movimiento_id"])
				->update(['paquete' => $newpaquete, 'vendido' => 1]);
			}
			
		}
		
		return Response::json($result);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Venta $venta_maestro)
	{
		return view('venta.show')->with('venta_maestro', $venta_maestro);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Venta $venta)
	{
		$query = "SELECT * FROM ventas_maestro WHERE id= ".$venta->id."";
		$fieldsArray = DB::select($query);

		$clientes = Cliente::all();
		$tipo_pagos = TipoPago::all();
	
        return view ("venta.edit", compact('venta', 'fieldsArray', 'clientes', 'tipo_pagos'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Venta $venta_maestro, Request $request)
	{
		function cargarSaldo(CuentasPorCobrar $cuentaporcobrar, Venta $venta_maestro){
			$detalle = array(
				'compra_id' => $venta_maestro->id,
				'num_factura' => 'Fac-'.$venta_maestro->id,
				'fecha' => $venta_maestro->created_at,
				'descripcion' => 'Venta modificada',
				'cargos' => $venta_maestro->total_venta,	
				'abonos' => 0,
				'saldo' => $cuentaporcobrar->total + $venta_maestro->total_venta
			);					

			$cuentaporcobrar->cuentas_por_cobrar_detalle()->create($detalle);

			$newtotal = $detalle['saldo'];
			$cuentaporcobrar->update(['total' => $newtotal]);
		};

		function nuevaCuenta(venta $venta_maestro, Request $data){
			$cuenta = new CuentasPorCobrar;
			$cuenta->total = $venta_maestro->total_venta;
			$cuenta->cliente_id = $data["cliente_id"];
			$cuenta->save();

			$detalle = array(
				'compra_id' => $venta_maestro->id,
				'num_factura' => 'Fac-'.$venta_maestro->id,
				'fecha' => $venta_maestro->created_at,
				'descripcion' => 'Venta modificada',
				'cargos' => $venta_maestro->total_venta,	
				'abonos' => 0,
				'saldo' => $venta_maestro->total_venta
			);							

			$cuenta->cuentas_por_cobrar_detalle()->create($detalle);

		};

		function abonarSaldo(CuentasPorCobrar $cuentaporcobrar, Venta $venta_maestro){
			$total = $cuentaporcobrar->total;
			$NuevoTotal = $total - $venta_maestro->total_venta;

			$detalle = array(
				'compra_id' => $venta_maestro->id,
				'num_factura' => 'Fac-'.$venta_maestro->id,
				'fecha' => carbon::now(),
				'descripcion' => 'Venta modifico cliente anterior',
				'cargos' => 0,	
				'abonos' => $venta_maestro->total_venta,
				'saldo' => $NuevoTotal
			);					

			$cuentaporcobrar->cuentas_por_cobrar_detalle()->create($detalle);
			$cuentaporcobrar->update(['total' => $NuevoTotal]);
		};

		$data = $request->all();
		$tipo_pago_anterior = $venta_maestro->tipo_pago_id;
		$cliente_anterior = $venta_maestro->cliente_id;

		$venta_maestro->tipo_pago_id = $data["tipo_pago_id"];
		$venta_maestro->cliente_id = $data["cliente_id"];

		if($tipo_pago_anterior == 1 && $data["tipo_pago_id"] == 3 && $cliente_anterior == $data['cliente_id'] || 
		   $tipo_pago_anterior == 2 && $data["tipo_pago_id"] == 3 && $cliente_anterior == $data['cliente_id'] )
			{
				$cuentaporcobrar = CuentasPorCobrar::where('cliente_id', $data["cliente_id"])->first();

				if($cuentaporcobrar){
					cargarSaldo($cuentaporcobrar, $venta_maestro);					
				}

				else 
				{
					nuevaCuenta($venta_maestro, $data);				
				}	

			}
		elseif( $tipo_pago_anterior == 1 && $data["tipo_pago_id"] == 3 && $cliente_anterior != $data['cliente_id'] || 
				$tipo_pago_anterior == 2 && $data["tipo_pago_id"] == 3 && $cliente_anterior != $data['cliente_id'] )
		{

			$cuentaNueva = CuentasPorCobrar::where('cliente_id', $data['cliente_id'])->first();

			if($cuentaNueva)
			{
				//Se carga deuda a cliente nuevo
				cargarSaldo($cuentaNueva, $venta_maestro);
			}

			else
			{
				//Se Crea deuda a nuevo cliente
				nuevaCuenta($venta_maestro, $data);
			}

		}

		elseif($tipo_pago_anterior == 3 && $tipo_pago_anterior == $data["tipo_pago_id"] && $cliente_anterior != $data['cliente_id'] )
		{
			$cuentaporcobrar = CuentasPorCobrar::where('cliente_id', $cliente_anterior)->first();

				//Se abona deuda cliente anterior
				abonarSaldo($cuentaporcobrar, $venta_maestro);

				$cuentaNueva = CuentasPorCobrar::where('cliente_id', $data['cliente_id'])->first();

				if($cuentaNueva)
				{
					//Se carga deuda a cliente nuevo
					cargarSaldo($cuentaNueva, $venta_maestro);
				}

				else
				{
					//Se crea deuda a nuevo cliente
					nuevaCuenta($venta_maestro, $data);
				}		
		}

		elseif($tipo_pago_anterior == 3 && $tipo_pago_anterior == $data["tipo_pago_id"] && $cliente_anterior == $data['cliente_id'])
		{

		}

		//Cambio de credito a efectivo o tarjeta
		elseif($tipo_pago_anterior == 3 && $data["tipo_pago_id"] == 1 && $cliente_anterior == $data['cliente_id']||
				$tipo_pago_anterior == 3 && $data["tipo_pago_id"] == 2 && $cliente_anterior == $data['cliente_id'])
		{
			$cuentaporcobrar = CuentasPorCobrar::where('cliente_id', $cliente_anterior)->first();
			//Se abona deuda cliente anterior
			abonarSaldo($cuentaporcobrar, $venta_maestro);
			
		}

		elseif($tipo_pago_anterior == 3 && $data["tipo_pago_id"] == 1 && $cliente_anterior != $data['cliente_id']||
				$tipo_pago_anterior == 3 && $data["tipo_pago_id"] == 2 && $cliente_anterior != $data['cliente_id'])
		{
			$cuentaporcobrar = CuentasPorCobrar::where('cliente_id', $cliente_anterior)->first();
			//Se abona deuda cliente anterior
			abonarSaldo($cuentaporcobrar, $venta_maestro);

		}
		$venta_maestro->save();
		return redirect('/ventas');	
}
	
	public function updateTotal(Venta $venta_maestro, Request $request)
	{
	
		$data = $request->all();
		$venta_maestro->tipo_pago_id = $data["tipo_pago_id"];
		$venta_maestro->save();
		
		return $venta_maestro;
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Venta $venta_maestro, Request $request)
	{

		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$detalles = VentaDetalle::where('venta_id', $venta_maestro->id)
			->get();
			foreach($detalles as $detalle) 
			{
				if($detalle['producto_id']>0){
				$producto = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->get()->first();
				$existencias = $producto->existencias;
				$cantidad = $detalle->cantidad;


				//kardex
				$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $producto->producto_id )->sum( "existencias");
				

				if($existencia_anterior == null){
					$existencia_anterior = 0;
				};

				event(new ActualizacionProducto($producto->producto_id, 'Venta Borrada', $cantidad, 0, $existencia_anterior, $existencia_anterior + $cantidad,0));

				//Movimiento Producto
				$newExistencias = $existencias + $cantidad;
				$updateExistencia = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->update(['existencias' => $newExistencias]);
				}else{
					$producto = $detalle["servicio_id"];
				}
			}


			if($venta_maestro->tipo_pago_id == 3 )
			{
				$cuentaporcobrar = CuentasPorCobrar::where('cliente_id', $venta_maestro->cliente_id)->first();

				$total = $cuentaporcobrar->total;
				$NuevoTotal = $total - $venta_maestro->total_venta;

				$detallecuenta = array(
					'num_factura' => 'Fac-'.$venta_maestro->num_factura,
					'fecha' => carbon::now(),
					'descripcion' => 'Se elimino venta',
					'cargos' => 0,	
					'abonos' => $venta_maestro->total_venta,
					'saldo' => $NuevoTotal
				);
				
				$cuentaporcobrar->cuentas_por_cobrar_detalle()->create($detallecuenta);


				$cuentaporcobrar->update(['total' => $NuevoTotal]);
				$venta_maestro->update(['edo_venta_id' => 3]);

			}
			else
			{
				$venta_maestro->update(['edo_venta_id' => 3]);
			}		


			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}

	public function destroyDetalle(VentaDetalle $venta_detalle, Request $request)
	{

		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			if($venta_detalle->movimiento_producto_id>0){
				$producto = MovimientoProducto::where('id', $venta_detalle->movimiento_producto_id)
				->get()->first();
				$existencias = $producto->existencias;
				$cantidad = $venta_detalle->cantidad;
				$newExistencias = $existencias + $cantidad;

				//kardex
				$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $producto->producto_id )->sum( "existencias");

				if($existencia_anterior == null){
					$existencia_anterior = 0;
				};

				event(new ActualizacionProducto($producto->producto_id, 'Venta Borrada', $cantidad, 0, $existencia_anterior, $existencia_anterior + $cantidad,0));

				$updateExistencia = MovimientoProducto::where('id', $venta_detalle->movimiento_producto_id)
				->update(['existencias' => $newExistencias]);
			}
			$ventamaestro = Venta::where('id', $venta_detalle->venta_id)
			->get()->first();
			$total = $ventamaestro->total_venta;
			$totalresta = $venta_detalle->subtotal;
			$newTotal = $total - $totalresta;
			$updateTotal = Venta::where('id', $venta_detalle->venta_id)
			->update(['total_venta' => $newTotal]);

			
			//Actualiza cuenta por cobrar

			if($ventamaestro->tipo_pago_id == 3)
			{
				$cuentaporcobrar = CuentasPorCobrar::where('cliente_id', $ventamaestro->cliente_id)->first();

				$totalactual = $cuentaporcobrar->total;

				$NuevoTotal = $totalactual - $totalresta;

				$detallecuenta = array(
					'num_factura' => 'Fac-'.$ventamaestro->id,
					'fecha' => carbon::now(),
					'descripcion' => 'Se elimino detalle de venta',
					'cargos' => 0,	
					'abonos' => $totalresta,
					'saldo' => $NuevoTotal
				);
				
				$cuentaporcobrar->cuentas_por_cobrar_detalle()->create($detallecuenta);


				$cuentaporcobrar->update(['total' => $NuevoTotal]);
				$venta_detalle->delete();

			}

			else
			{
				$venta_detalle->delete();
			}

			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}

	public function destroyDetalle2(VentaDetalle $venta_detalle, MovimientoProducto $movimiento_producto, Request $request)
	{
		$existencias = $movimiento_producto->existencias;
		$cantidad = $venta_detalle->cantidad;
		$newExistencias = $existencias + $cantidad;

		//kardex
		$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $venta_detalle->producto_id )->sum( "existencias");

		if($existencia_anterior == null){
			$existencia_anterior = 0;
		};

		//event(new ActualizacionProducto($venta_detalle->producto_id, 'Venta Borrada', $cantidad, 0, $existencia_anterior, $existencia_anterior + $cantidad,0));

		//Movimiento Producto
		$updateExistencia = MovimientoProducto::where('id', $movimiento_producto->id)
		->update(['existencias' => $newExistencias]);

		$ventamaestro = Venta::where('id', $venta_detalle->venta_id)
		->get()->first();
		$total = $ventamaestro->total_venta;
		$totalresta = $venta_detalle->subtotal;
		$newTotal = $total - $totalresta;
		$updateTotal = Venta::where('id', $venta_detalle->venta_id)
		->update(['total_venta' => $newTotal]);

		$venta_detalle->delete();
		$response["response"] = "El registro ha sido borrado";
		return Response::json($response);
	}
	public function destroyDetalle3(VentaDetalle $venta_detalle,Request $request)
	{
		
		$ventamaestro = Venta::where('id', $venta_detalle->venta_id)
		->get()->first();
		$total = $ventamaestro->total_venta;
		$totalresta = $venta_detalle->subtotal;
		$newTotal = $total - $totalresta;
		$updateTotal = Venta::where('id', $venta_detalle->venta_id)
		->update(['total_venta' => $newTotal]);

		$venta_detalle->delete();
		$response["response"] = "El registro ha sido borrado";
		return Response::json($response);
	}

// funciones para la edicion del detalle de ventas
	public function UpdateDetalle2(VentaDetalle $venta_detalle, MovimientoProducto $movimiento_producto, Request $request)
	{
		$data = $request->all();
		$existencia_anterior = VentaDetalle::where( "id" , "=" , $venta_detalle->id )->sum( "cantidad");
		$diferencia=$existencia_anterior - $data['cantidad'] ;
		$existencias = $movimiento_producto->existencias;
		$newExistencias = $existencias + $diferencia;
		//dd($data);
		//actualizacion de total de ventas
		$ventamaestro = Venta::where('id', $venta_detalle->venta_id)
		->get()->first();
		$total = $ventamaestro->total_venta;
		$sub=$data["cantidad"] * $data["precio_venta"];
		$totalresta = $venta_detalle->subtotal- $sub;
		$newTotal = $total - $totalresta;
		$updateTotal = Venta::where('id', $venta_detalle->venta_id)
		->update(['total_venta' => $newTotal]);


		//Movimiento Producto
		$updateExistencia = MovimientoProducto::where('id', $movimiento_producto->id)
		->update(['existencias' => $newExistencias]);
		$venta_detalle->cantidad=$data["cantidad"];
		$venta_detalle->precio_venta=$data["precio_venta"];
		$venta_detalle->subtotal=$data["cantidad"] * $data["precio_venta"];
		$venta_detalle->save();



		$response["response"] = "";
		return Response::json($response);
	}
	public function UpdateDetalle3(VentaDetalle $venta_detalle,Request $request)
	{
		$data=$request->all();
		$existencia_anterior = VentaDetalle::where( "id" , "=" , $venta_detalle->id )->sum( "cantidad");
		$diferencia=$existencia_anterior - $data['cantidad'] ;
		//actualizacion de total de ventas
		$ventamaestro = Venta::where('id', $venta_detalle->venta_id)
		->get()->first();
		$total = $ventamaestro->total_venta;
		$sub=$data["cantidad"] * $data["precio_venta"];
		$totalresta = $venta_detalle->subtotal - $sub;
		$newTotal = $total - $totalresta;
		$updateTotal = Venta::where('id', $venta_detalle->venta_id)
		->update(['total_venta' => $newTotal]);

		if (empty( $data["servicio_id"])) {
			$venta_detalle->cantidad=$data["cantidad"];
			$venta_detalle->detalle_mano_obra=$data["nombre"];
			$venta_detalle->precio_venta=$data["precio_venta"];
			$venta_detalle->subtotal=$data["cantidad"] * $data["precio_venta"];
			$venta_detalle->save();
			
		} else {
			
		$venta_detalle->cantidad=$data["cantidad"];
		$venta_detalle->precio_venta=$data["precio_venta"];
		$venta_detalle->subtotal=$data["cantidad"] * $data["precio_venta"];
		$venta_detalle->save();

		}
		
		

		$response["response"] = "";
		return Response::json($response);
	
	}
	public function getTipoPago( Venta $venta_maestro )
	{
		$result = Venta::where( "id" , "=" , $venta_maestro->id )
		->get()
		->first();
		return Response::json( $result);
	}
	public function editDetalle ( VentaDetalle $venta_detalle)
	{
		/*$query = "SELECT * FROM compras WHERE id=".$compra->id."";
		$fieldsArray = DB::select($query);*/
		
		$productos = Producto::all();
		$servicios = Servicio::all();
		$movimientos;
		if ($venta_detalle->movimiento_producto_id>0) {
			$movimientos = MovimientoProducto::where( "id" , "=" , $venta_detalle->movimiento_producto_id )->sum( "existencias");	
		}
        return view ("venta.editdetalle", compact('venta_detalle','productos', 'servicios','movimientos'));
	}
	public function updateDetalle(VentaDetalle $venta_detalle,MovimientoProducto $movimiento_producto, Request $request )
	{
		$data=$request->all();
		
		$diferencias=0;

		if (empty($data["producto_id"]) && empty($data["servicio_id"] ) ) {
			$existencia_anterior = VentaDetalle::where( "id" , "=" , $venta_detalle->id )->sum( "cantidad");
			$diferencia=$existencia_anterior - $data['cantidad'] ;
			//actualizacion de total de ventas
			$ventamaestro = Venta::where('id', $venta_detalle->venta_id)
			->get()->first();
			$total = $ventamaestro->total_venta;
			$sub=$data["cantidad"] * $data["precio_venta"];
			$totalresta = $venta_detalle->subtotal - $sub;
			$diferencias=$totalresta;
			$newTotal = $total - $totalresta;
			$updateTotal = Venta::where('id', $venta_detalle->venta_id)
			->update(['total_venta' => $newTotal]);

			$venta_detalle->cantidad=$data["cantidad"];
			$venta_detalle->detalle_mano_obra=$data["detalle_mano_obra"];
			$venta_detalle->precio_venta=$data["precio_venta"];
			$venta_detalle->subtotal=$data["cantidad"] * $data["precio_venta"];
			$venta_detalle->save();
		} else  if (empty($data["producto_id"]) ) {
			$existencia_anterior = VentaDetalle::where( "id" , "=" , $venta_detalle->id )->sum( "cantidad");
			$diferencia=$existencia_anterior - $data['cantidad'] ;
			//actualizacion de total de ventas
			$ventamaestro = Venta::where('id', $venta_detalle->venta_id)
			->get()->first();
			$total = $ventamaestro->total_venta;
			$sub=$data["cantidad"] * $data["precio_venta"];
			$totalresta = $venta_detalle->subtotal - $sub;
			$diferencias=$totalresta;
			$newTotal = $total - $totalresta;
			$updateTotal = Venta::where('id', $venta_detalle->venta_id)
			->update(['total_venta' => $newTotal]);

			$venta_detalle->cantidad=$data["cantidad"];
			$venta_detalle->precio_venta=$data["precio_venta"];
			$venta_detalle->subtotal=$data["cantidad"] * $data["precio_venta"];
			$venta_detalle->save();
			
		
		}
		else{
			
			$existencia_anterior = VentaDetalle::where( "id" , "=" , $venta_detalle->id )->sum( "cantidad");
			$diferencia=$existencia_anterior - $data['cantidad'] ;
			$existencias = MovimientoProducto::where( "id" , "=" , $venta_detalle->movimiento_producto_id )->sum( "existencias");
			$newExistencias = $existencias + $diferencia;
			//actualizacion de total de ventas
			$ventamaestro = Venta::where('id', $venta_detalle->venta_id)
			->get()->first();
			$total = $ventamaestro->total_venta;
			$sub=$data["cantidad"] * $data["precio_venta"];
			$totalresta = $venta_detalle->subtotal- $sub;
			$diferencias=$totalresta;
			$newTotal = $total - $totalresta;
			$updateTotal = Venta::where('id', $venta_detalle->venta_id)
			->update(['total_venta' => $newTotal]);

			//Movimiento Producto
			$updateExistencia = MovimientoProducto::where('id', $venta_detalle->movimiento_producto_id)
			->update(['existencias' => $newExistencias]);
			$venta_detalle->cantidad=$data["cantidad"];
			$venta_detalle->precio_venta=$data["precio_venta"];
			$venta_detalle->subtotal=$data["cantidad"] * $data["precio_venta"];
			$venta_detalle->save();
			
		}
		
		 if ($ventamaestro->tipo_pago_id==3) {
			
			$total = CuentasPorCobrar::where( "cliente_id" , "=" , $ventamaestro->cliente_id )->sum( "total");
			$newtt=$total-$diferencias;
			$updatetotal1 = CuentasPorCobrar::where('cliente_id', $ventamaestro->cliente_id)
			->update(['total' => $newtt]);

			$updatetotal1 = CuentaPorCobrarDetalle::where('venta_id', $ventamaestro->id)
			->update(['cargos' => $newtt,'saldo' => $newtt ]);

		 }
		
		return redirect('/ventadetalle/'.$venta_detalle->venta_id);	

	}


	public function makeCorte (Request $request)
	{
		$user1= Auth::user()->password;
		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{

			$user = Auth::user()->name;
			Mail::send('email.test', ['user' => $user], function ($m) use ($user) {
				$data = PdfController::getDataCCresumen();
				$user = Auth::user()->name;
				$today = Carbon::now();

				$efec = "SELECT SUM(VD.subtotal) AS efectivo FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=1";
				$efectivo = DB::select($efec);

				$tar = "SELECT SUM(VD.subtotal) AS tarjeta FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=2";
				$tarjeta = DB::select($tar);        

				$sub1 = "SELECT SUM(VD.subtotal) AS subtotal1 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=1";
				$subtotal1 = DB::select($sub1); 

				$sub11 = "SELECT SUM(VD.subtotal) + 400 AS subtotal11 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1";
				$subtotal11 = DB::select($sub11); 

				$sub12 = "SELECT (SUM(VD.subtotal) + 400) - (SELECT SUM(VD.subtotal) AS tarjeta FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=2) AS subtotal12 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1";
				$subtotal12 = DB::select($sub12); 

				$sub2 = "SELECT SUM(VD.subtotal) - 400 AS subtotal2 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=1";
				$subtotal2 = DB::select($sub2); 

				$view =  \View::make('pdf.pdf_ccresumen', compact('data', 'user', 'today', 'efectivo', 'tarjeta', 'subtotal1', 'subtotal2', 'subtotal11', 'subtotal12'))->render();
				$pdf = \App::make('dompdf.wrapper');
				$pdf->loadHTML($view);


				$data = PdfController::getDataCCdetalle();

				$efec = "SELECT SUM(VD.subtotal) AS efectivo FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=1";
				$efectivo1 = DB::select($efec);

				$tar = "SELECT SUM(VD.subtotal) AS tarjeta FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=2";
				$tarjeta1 = DB::select($tar);        

				$sub1 = "SELECT SUM(VD.subtotal) AS subtotal1 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1";
				$subtotal1 = DB::select($sub1);

				$view =  \View::make('pdf.pdf_ccdetalle', compact('data', 'user', 'today', 'tarjeta1','subtotal1','efectivo1'))->render();
				$pdf2 = \App::make('dompdf.wrapper');
				$pdf2->loadHTML($view);

				$m->from('info@technovation.com.gt', 'Technovation');

				$m->to("g.seijas1305@gmail.com", "Usuario")->subject('Corte de Caja');

				$m->attachData($pdf->output(), 'corte.pdf');

				$m->attachData($pdf2->output(), 'detalle.pdf');


			});

			$today = Carbon::now();
			$query = "update ventas_maestro set edo_venta_id=4 where edo_venta_id=1";
			$result = DB::select($query);
			return view("home");
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}

	}

	public function getJson(Request $params)
	{
		$query = 'SELECT TRUNCATE(total_venta,4) as total_venta, ventas_maestro.id as id, ventas_maestro.created_at as fecha, ventas_maestro.tipo_venta_id as tipo_venta_id,
		tipos_pago.tipo_pago, estado_venta.edo_venta as edo_venta, users.name as name from ventas_maestro inner join 
		tipos_pago on ventas_maestro.tipo_pago_id=tipos_pago.id inner join users on users.id=ventas_maestro.user_id
		inner join estado_venta on ventas_maestro.edo_venta_id=estado_venta.id WHERE ventas_maestro.edo_venta_id != 3 ';

		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}

	public function getJsonDetalle(Request $params, $detalle)
	{
		$query ='SELECT vd.venta_id as No_Venta, vd.id, 	
				IF(vd.producto_id>0,pr.nombre, if(vd.servicio_id>0,sr.nombre, vd.detalle_mano_obra)) as nombre, 
				vd.cantidad as cantidad, vd.subtotal as subtotal
				FROM ventas_detalle vd
				LEFT JOIN productos pr ON vd.producto_id=pr.id
				LEFT JOIN servicios sr ON vd.servicio_id=sr.id
				where venta_id='.$detalle.' ';

		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}
	public function rpt_ventas_dia(Request $request)
    {
        $today = date("Y/m/d");
		
        $query = "SELECT v.id, DATE_FORMAT(v.created_at, '%d-%m-%Y') as fecha, s.serie, f.numero, v.total_venta
		FROM ventas_maestro v
		LEFT JOIN facturas f on f.venta_id = v.id
		LEFT JOIN series s on s.id = f.serie_id
		WHERE v.created_at BETWEEN '".$today."' AND '".$today." 23:59:59' order by fecha ";
        $detalles = DB::select($query);

       
		//$pdf = \PDF::loadView();
		$view =  \View::make('pdf.rpt_ventas_dia', compact('detalles', 'today'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);


        return $pdf->stream('Reporte de ventas de dia.pdf', array("Attachment" => 0));
    }
    

	public function rpt_ventas(Request $request)
    {
        $fecha_inicial = $request['fecha_inicial'];
        $fecha_final = $request['fecha_final'];
		$user = Auth::user()->name;

        $query = "SELECT v.id, DATE_FORMAT(v.created_at, '%d-%m-%Y') as fecha, v.total_venta, concat(C.nombres,' ' ,C.apellidos) as nombres, C.nit as nit
		FROM ventas_maestro v
		LEFT JOIN clientes C on C.id = v.cliente_id
		WHERE v.created_at BETWEEN '".$fecha_inicial."' AND '".$fecha_final." 23:59:59' order by fecha ";
        $detalles = DB::select($query);
		$total=0;
		foreach ($detalles as $detalle) {
			$total=$total+$detalle->total_venta;
		}
		$hoy=Carbon::now();
        $fecha_inicial = Carbon::parse($fecha_inicial)->format('d/m/Y');
        $fecha_final = Carbon::parse($fecha_final)->format('d/m/Y');
    
        $pdf = PDF::loadView('pdf.rpt_ventas', compact('hoy','total','detalles', 'fecha_inicial', 'fecha_final','user'));
        return $pdf->stream('Reporte de ventas.pdf');
    }
    
    public function rpt_generar()
    {
        return view("venta.rptGenerar");
	}
	
	public function rpt_ventas_cliente(Request $request)
    {
        $fecha_inicial = $request['fecha_inicial'];
        $fecha_final = $request['fecha_final'];

        $query = "SELECT c.nit, CONCAT(c.nombres,' ',c.apellidos) as nombre_completo, SUM(v.total_venta) as total
		FROM ventas_maestro v
		INNER JOIN clientes c on v.cliente_id = c.id
		WHERE v.created_at BETWEEN '".$fecha_inicial."' AND '".$fecha_final." 23:59:59' AND v.edo_venta_id != 3 GROUP BY nombre_completo, c.nit order by total ";
		$detalles = DB::select($query);
		
		$query2 = "SELECT SUM(v.total_venta) as total
		FROM ventas_maestro v
		WHERE v.created_at BETWEEN '".$fecha_inicial."' AND '".$fecha_final." 23:59:59' 
		AND v.edo_venta_id != 3  ";
		$total_general = DB::select($query2);

        $fecha_inicial = Carbon::parse($fecha_inicial)->format('d/m/Y');
        $fecha_final = Carbon::parse($fecha_final)->format('d/m/Y');
    
        $pdf = PDF::loadView('pdf.rpt_ventas_cliente', compact('detalles', 'fecha_inicial', 'fecha_final', 'total_general'));
        return $pdf->stream('Reporte de ventas por cliente.pdf');
    }
    
    public function rpt_ventas_cliente_generar()
    {
        return view("clientes.rptGenerar");
    }
}