<?php

namespace App\Http\Controllers;

use App\Compra;
use App\MaquinariaEquipo;
use App\IngresoProducto;
use App\User;
use App\Proveedor;
use App\EstadoIngreso;
use App\Producto;
use App\DetalleCompra;
use App\MovimientoProducto;
use App\TipoPago;
use View;
Use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kodeine\Acl\Models\Eloquent\Role;
use Kodeine\Acl\Models\Eloquent\Permission;
use Carbon\Carbon;
use App\CuentaPorPagar;
use App\DetalleCuentaPorPagar; 
use App\Kardex;
use App\Events\ActualizacionProducto;
use App\TipoProveedor;
use Barryvdh\DomPDF\Facade as PDF;

class ComprasController extends Controller
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
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        return view ("compras.index", compact('proveedores', 'productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$proveedores = Proveedor::all();
		$productos = Producto::all();
		$maquinarias = MaquinariaEquipo::all();
		$tipos_proveedores = TipoProveedor::all();
		$tipos_pago = TipoPago::all();
		return view("compras.create" , compact("back","proveedores", "productos", "maquinarias","tipos_pago", 'tipos_proveedores') );
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

		$data0 = $request->all();
		$data = $data0['formData'];
		$data["user_id"] = Auth::user()->id;
		//$data['fecha_factura'] = Carbon::createFromFormat('d/m/Y', $data['fecha_factura']);
		$data["edo_ingreso_id"] = 1;
		$data["tipo_pago_id"] = $request['formData']["tipo_pago_id"];
		$maestro = Compra::create($data);

		if($request['formData']["tipo_pago_id"] == 3){

			$existeCuentaProveedor = CuentaPorPagar::where('proveedor_id',$request['formData']["proveedor_id"])->first();

			if($existeCuentaProveedor){

				$detalle = array(
					'compra_id' => $maestro->id,
					'num_factura' => 'Fac-'.$request['formData']["num_factura"],
					'fecha' => $data["fecha_factura"],
					'descripcion' => 'Compra',
					'cargos' => $request['formData']["total_factura"],	
					'abonos' => 0,
					'saldo' => $existeCuentaProveedor->total + $request['formData']["total_factura"]
				);					

				$existeCuentaProveedor->detalles_cuentas_por_pagar()->create($detalle);

				$newtotal = $detalle['saldo'];
				$existeCuentaProveedor->update(['total' => $newtotal]);
			}

			else{
				$cuenta = new CuentaPorPagar;
				$cuenta->total = $request['formData']["total_factura"];
				$cuenta->proveedor_id = $request['formData']["proveedor_id"];
				$cuenta->save();

				$detalle = array(
					'compra_id' => $maestro->id,
					'num_factura' => 'Fac-'.$request['formData']["num_factura"],
					'fecha' => $data["fecha_factura"],
					'descripcion' => 'Compra',
					'cargos' => $request['formData']["total_factura"],	
					'abonos' => 0,
					'saldo' => $request['formData']["total_factura"]
				);							

				$cuenta->detalles_cuentas_por_pagar()->create($detalle);
			}
			
		}

		//return $maestro;

		//Guarda Detalle

		$statsArray = $data0['detalle'];

		foreach($statsArray as $stat) {
			if(empty($stat['producto_id'])){
				$stat['user_id'] = Auth::user()->id;
				$stat['maquinaria_equipo_id'] = $stat['maquinaria_equipo_id'];
				
				$stat["subtotal"] = $stat["subtotal_venta"];
				$stat['existencias'] = $stat["cantidad"];
				$stat["precio_compra"] = $stat["precio_compra"];
				$stat['fecha_ingreso'] = Carbon::now();
			
				$detalle = MovimientoProducto::create($stat);
				$stat["movimiento_producto_id"] = $detalle->id;
				$maestro->detalles_compras()->create($stat);
			}

			else{
				$stat['user_id'] = Auth::user()->id;
				$stat['producto_id'] = $stat['producto_id'];
				
				$stat["subtotal"] = $stat["subtotal_venta"];
				$stat['paquete'] = $stat["cantidad"];
				$stat['existencias'] = $stat["unidades"];
				$stat["precio_compra"] = $stat["precio_compra"];
				$stat['fecha_ingreso'] = Carbon::now();

				//kardex

				$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $stat["producto_id"] )
				->sum( "existencias");


				/*
 				*/

				if($existencia_anterior == null){
					$existencia_anterior = 0;
				};
			
				$detalle = MovimientoProducto::create($stat);
				$stat["movimiento_producto_id"] = $detalle->id;
				$maestro->detalles_compras()->create($stat);
				
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
				
				$costo_entrada=$stat["unidades"]*$stat["precio_compra"];
				$costo_salida=$costo_ponderado*0;
				$costo_anterior=$costo_ponderado*$existencia_anterior;
				$costo_acumulado=$costo_entrada+$costo_anterior-$costo_salida;
				
				event(new ActualizacionProducto($stat['producto_id'], 'Compra', $stat['unidades'],0, $existencia_anterior, $existencia_anterior + $stat['unidades'],$stat["precio_compra"],$costo_ponderado,$costo_entrada,$costo_salida,$costo_anterior,$costo_acumulado));
			}		
			
		}

		DB::commit();
		return Response::json(['result' => 'ok']);
		}

		catch(Exception $e)
		{
            DB::rollBack();
		}

	}

	public function saveDetalle(Request $request, Compra $compra)
	{/*

		$statsArray = $request->all();
		foreach($statsArray as $stat) {

			if(empty($stat['producto_id'])){
				$stat['user_id'] = Auth::user()->id;
				$stat['maquinaria_equipo_id'] = $stat['maquinaria_equipo_id'];
				$stat["precio_venta"] = 0;
				$stat["subtotal"] = $stat["subtotal_venta"];
				$stat['existencias'] = $stat["cantidad"];
				$stat["precio_compra"] = $stat["precio_compra"];
				$stat['fecha_ingreso'] = Carbon::now();
			
				$detalle = MovimientoProducto::create($stat);
				$stat["movimiento_producto_id"] = $detalle->id;
				$compra->detalles_compras()->create($stat);
			}

			else{
				$stat['user_id'] = Auth::user()->id;
				$stat['producto_id'] = $stat['producto_id'];
				$stat["precio_venta"] = $stat["precio_venta"];
				$stat["subtotal"] = $stat["subtotal_venta"];
				$stat['existencias'] = $stat["cantidad"];
				$stat["precio_compra"] = $stat["precio_compra"];
				$stat['fecha_ingreso'] = Carbon::now();

				//kardex

				$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $stat["producto_id"] )
				->sum( "existencias");

				if($existencia_anterior == null){
					$existencia_anterior = 0;
				};
			
				$detalle = MovimientoProducto::create($stat);
				$stat["movimiento_producto_id"] = $detalle->id;
				$compra->detalles_compras()->create($stat);

				event(new ActualizacionProducto($stat['producto_id'], 'Compra', $stat['cantidad'],0, $existencia_anterior, $existencia_anterior + $stat['cantidad']));
			}		
			
		}
		return Response::json(['result' => 'ok']); */

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function show(Compra $compra)
	{
		return view('compras.show')->with('compra', $compra);
	}


	public function getName(Compra $compra )
	{
		$date =Carbon::createFromFormat('Y-m-d H:i:s', $compra->fecha_factura)->format('d-m-Y');
		$compra->fecha_factura = $date;
		return Response::json($compra);
	}

	public function getDetalle( DetalleCompra $detallecompra)
	{
		$ingresoproducto = DetalleCompra::where( "detalles_compras.id" , "=" , $detallecompra->id )
		->select( "existencias", "precio_compra", "precio_venta")
		->get()
		->first();
		return Response::json( $ingresoproducto);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Compra $compra)
	{
		$query = "SELECT * FROM compras WHERE id=".$compra->id."";
		$fieldsArray = DB::select($query);
		
		$proveedores = Proveedor::all();
		$tipo_pagos = TipoPago::all();
        return view ("compras.edit", compact('compra', 'fieldsArray','proveedores', 'tipo_pagos'));
	}

	public function editDetalle(DetalleCompra $detallecompra)
	{
		/*$query = "SELECT * FROM compras WHERE id=".$compra->id."";
		$fieldsArray = DB::select($query);*/
		
		$productos = Producto::all();
		$maquinarias = MaquinariaEquipo::all();
        return view ("compras.editdetalle", compact('detallecompra','productos', 'maquinarias'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function update(Compra $compra, Request $request )
	{
		function cargarSaldo(CuentaPorPagar $cuentaporpagar, Compra $compra){
			$detalle = array(
				'compra_id' => $compra->id,
				'num_factura' => 'Fac-'.$compra->num_factura,
				'fecha' => $compra->created_at,
				'descripcion' => 'Compra modificada',
				'cargos' => $compra->total_factura,	
				'abonos' => 0,
				'saldo' => $cuentaporpagar->total + $compra->total_factura
			);					

			$cuentaporpagar->detalles_cuentas_por_pagar()->create($detalle);

			$newtotal = $detalle['saldo'];
			$cuentaporpagar->update(['total' => $newtotal]);
		};

		function nuevaCuentaPorPagar(compra $compra, array $data){
			$cuenta = new CuentaPorPagar;
			$cuenta->total = $compra->total_factura;
			$cuenta->proveedor_id = $data["proveedor_id"];
			$cuenta->save();

			$detalle = array(
				'compra_id' => $compra->id,
				'num_factura' => 'Fac-'.$compra->num_factura,
				'fecha' => $compra->created_at,
				'descripcion' => 'Compra modificada',
				'cargos' => $compra->total_factura,	
				'abonos' => 0,
				'saldo' => $compra->total_factura
			);							

			$cuenta->detalles_cuentas_por_pagar()->create($detalle);

		};

		function abonarSaldo(CuentaPorPagar $cuentaporpagar, Compra $compra){
			$total = $cuentaporpagar->total;
			$NuevoTotal = $total - $compra->total_factura;

			$detalle = array(
				'compra_id' => $compra->id,
				'num_factura' => 'Fac-'.$compra->num_factura,
				'fecha' => carbon::now(),
				'descripcion' => 'Compra modifico proveedor anterior',
				'cargos' => 0,	
				'abonos' => $compra->total_factura,
				'saldo' => $NuevoTotal
			);					

			$cuentaporpagar->detalles_cuentas_por_pagar()->create($detalle);
			$cuentaporpagar->update(['total' => $NuevoTotal]);
		};

		$data = $request->all();
		$tipo_pago_anterior = $compra->tipo_pago_id;
		$proveedor_anterior = $compra->proveedor_id;

		$compra->tipo_pago_id = $data["tipo_pago_id"];
		$compra->proveedor_id = $data["proveedor_id"];

		if($tipo_pago_anterior == 1 && $data["tipo_pago_id"] == 3 && $proveedor_anterior == $data['proveedor_id'] || 
		   $tipo_pago_anterior == 2 && $data["tipo_pago_id"] == 3 && $proveedor_anterior == $data['proveedor_id'] )
			{
				$cuentaporpagar = CuentaPorPagar::where('proveedor_id', $data["proveedor_id"])->first();

				if($cuentaporpagar){
					cargarSaldo($cuentaporpagar, $compra);					
				}

				else 
				{
					//dd($data);
					nuevaCuentaPorPagar($compra, $data);				
				}	

			}
		elseif( $tipo_pago_anterior == 1 && $data["tipo_pago_id"] == 3 && $proveedor_anterior != $data['proveedor_id'] || 
				$tipo_pago_anterior == 2 && $data["tipo_pago_id"] == 3 && $proveedor_anterior != $data['proveedor_id'] )
		{

			$cuentaNueva = CuentaPorPagar::where('proveedor_id', $data['proveedor_id'])->first();

			if($cuentaNueva)
			{
				//Se carga deuda a proveedor nuevo
				cargarSaldo($cuentaNueva, $compra);
			}

			else
			{
				//Se Crea deuda a nuevo proveedor
				nuevaCuentaPorPagar($compra, $data);
			}

		}

		elseif($tipo_pago_anterior == 3 && $tipo_pago_anterior == $data["tipo_pago_id"] && $proveedor_anterior != $data['proveedor_id'] )
		{
			$cuentaporpagar = CuentaPorPagar::where('proveedor_id', $proveedor_anterior)->first();

				//Se abona deuda proveedor anterior
				abonarSaldo($cuentaporpagar, $compra);

				$cuentaNueva = CuentaPorPagar::where('proveedor_id', $data['proveedor_id'])->first();

				if($cuentaNueva)
				{
					//Se carga deuda a proveedor nuevo
					cargarSaldo($cuentaNueva, $compra);
				}

				else
				{
					//Se crea deuda a nuevo proveedor
					nuevaCuentaPorPagar($compra, $data);
				}		
		}

		elseif($tipo_pago_anterior == 3 && $tipo_pago_anterior == $data["tipo_pago_id"] && $proveedor_anterior == $data['proveedor_id'])
		{

		}

		//Cambio de credito a efectivo o tarjeta
		elseif($tipo_pago_anterior == 3 && $data["tipo_pago_id"] == 1 && $proveedor_anterior == $data['proveedor_id']||
				$tipo_pago_anterior == 3 && $data["tipo_pago_id"] == 2 && $proveedor_anterior == $data['proveedor_id'])
		{
			$cuentaporpagar = CuentaPorPagar::where('proveedor_id', $proveedor_anterior)->first();
			//Se abona deuda proveedor anterior
			abonarSaldo($cuentaporpagar, $compra);
			
		}

		elseif($tipo_pago_anterior == 3 && $data["tipo_pago_id"] == 1 && $proveedor_anterior != $data['proveedor_id']||
				$tipo_pago_anterior == 3 && $data["tipo_pago_id"] == 2 && $proveedor_anterior != $data['proveedor_id'])
		{
			$cuentaporpagar = CuentaPorPagar::where('proveedor_id', $proveedor_anterior)->first();
			//Se abona deuda proveedor anterior
			abonarSaldo($cuentaporpagar, $compra);

		}
		//$compra->save();
		//return redirect('/compras');

		//UPDATE COMPRAS
		Response::json($this->updateIngresoProducto($compra , $request->all()));
        return redirect('/compras');

		//return Response::json( $this->updateIngresoProducto($compra, $request->all())); 
	}


	public function updateDetalle(DetalleCompra $detallecompra, Request $request )
	{
		function cargarSaldo(CuentaPorPagar $cuentaporpagar, Compra $compra, $cargar){
			$detalle = array(
				'compra_id' => $compra->id,
				'num_factura' => 'Fac-'.$compra->num_factura,
				'fecha' => $compra->created_at,
				'descripcion' => 'Detalle Compra modificado',
				'cargos' => $cargar,	
				'abonos' => 0,
				'saldo' => $cuentaporpagar->total + $cargar
			);					

			$cuentaporpagar->detalles_cuentas_por_pagar()->create($detalle);

			$newtotal = $detalle['saldo'];
			$cuentaporpagar->update(['total' => $newtotal]);
		};

		function abonarSaldo(CuentaPorPagar $cuentaporpagar, Compra $compra, $abonar){
			$total = $cuentaporpagar->total;
			$NuevoTotal = $total - $abonar;

			$detalle = array(
				'compra_id' => $compra->id,
				'num_factura' => 'Fac-'.$compra->num_factura,
				'fecha' => carbon::now(),
				'descripcion' => 'Detalle Compra modificado',
				'cargos' => 0,	
				'abonos' => $abonar,
				'saldo' => $NuevoTotal
			);					

			$cuentaporpagar->detalles_cuentas_por_pagar()->create($detalle);
			$cuentaporpagar->update(['total' => $NuevoTotal]);
		};

		$data = $request->all();
		$compra = Compra::where('id', $detallecompra->compra_id)->first();
		$tipo_pago_anterior = $compra->tipo_pago_id;
		$proveedor_anterior = $compra->proveedor_id;
		$subtotal_anterior = $detallecompra->existencias * $detallecompra->precio_compra;
		$subtotal_nuevo = $data['existencias'] * $data['precio_compra'];

		//UPDATE cuando el detalle es de una compra al credito
		if($tipo_pago_anterior == 3)
		{
			$cuentaporpagar = CuentaPorPagar::where('proveedor_id', $proveedor_anterior)->first();
			abonarSaldo($cuentaporpagar, $compra, $subtotal_anterior);
			cargarSaldo($cuentaporpagar, $compra, $subtotal_nuevo);					
		}

		//Se actualiza el total de la factura
		$nuevoTotalFactura = $compra->total_factura - $subtotal_anterior + $subtotal_nuevo;

		$compra->total_factura = $nuevoTotalFactura;
		$compra->save();


		//Se actualiza el movimiento
		if(!empty($data['producto_id'])){

			//kardex para rebajar
			$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $detallecompra->producto_id )->sum("existencias");

			if($existencia_anterior == null){
				$existencia_anterior = 0;
			};
		
			event(new ActualizacionProducto($detallecompra->producto_id, 'Reversion Compra', 0,$detallecompra->existencias, $existencia_anterior, $existencia_anterior - $detallecompra->existencias,0));


			$movimiento = MovimientoProducto::where('id', $detallecompra->movimiento_producto_id)->first();
			$movimiento->existencias = $data['existencias'];
			$movimiento->producto_id = $data['producto_id'];
			$movimiento->precio_compra = $data['precio_compra'];
		
			$movimiento->save();

			//kardex para cargar

			/*if($data['producto_id'] == $detallecompra->producto_id){
				$existencia_anterior2 = MovimientoProducto::where( "producto_id" , "=" , $data["producto_id"] )->sum("existencias");

				$existencia_anterior2 = $existencia_anterior2 - $data['existencias'];
			}
			else{
				$existencia_anterior2 = MovimientoProducto::where( "producto_id" , "=" , $data["producto_id"] )->sum("existencias");
				$existencia_anterior2 = $existencia_anterior2 - $detallecompra->existencias;
			}*/

			$existencia_anterior2 = MovimientoProducto::where( "producto_id" , "=" , $data["producto_id"] )->sum("existencias");

			$existencia_anterior2 = $existencia_anterior2 - $data['existencias'];

			if($existencia_anterior2 == null){
				$existencia_anterior2 = 0;
			};
		
			event(new ActualizacionProducto($data['producto_id'], 'Compra', $data['existencias'],0, $existencia_anterior2, $existencia_anterior2 + $data['existencias'],0));
		}

		else{
			$movimiento = MovimientoProducto::where('id', $detallecompra->movimiento_producto_id)->first();
			$movimiento->existencias = $data['existencias'];
			$movimiento->maquinaria_equipo_id = $data['maquinaria_equipo_id'];
			$movimiento->precio_compra = $data['precio_compra'];
			
			$movimiento->save();			
		}


		//UPDATE DETALLE
		if(!empty($data['producto_id'])){
		$detallecompra->producto_id = $data['producto_id'];
		$detallecompra->user_id = Auth::user()->id;
		$detallecompra->precio_compra = $data['precio_compra'];
		
		$detallecompra->existencias = $data['existencias'];
		$detallecompra->save();
		}
		else{
			$detallecompra->maquinaria_equipo_id = $data['maquinaria_equipo_id'];
			$detallecompra->user_id = Auth::user()->id;
			$detallecompra->precio_compra = $data['precio_compra'];
			
			$detallecompra->existencias = $data['existencias'];
			$detallecompra->save();
		}

        return redirect('/compras');

		//return Response::json( $this->updateIngresoProducto($compra, $request->all())); 
	}



	public function updateIngresoProducto(Compra $compra, array $data )
	{

		//$data['fecha_factura'] = Carbon::createFromFormat('d-m-Y', $data['fecha_factura']);
		$compra->serie_factura = $data["serie_factura"];
		$compra->num_factura = $data["num_factura"];
		$compra->fecha_factura = $data["fecha_factura"];
		$compra->proveedor_id = $data["proveedor_id"];
		$compra->tipo_pago_id = $data["tipo_pago_id"];
		$compra->save();
		return $compra;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Compra $compra,  Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$detalles = DetalleCompra::where('compra_id', $compra->id)
			->get();
			foreach($detalles as $detalle) 
			{
				$producto = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->get()->first();

				//kardex
				$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $producto->producto_id )->sum( "existencias");

				if($existencia_anterior == null){
					$existencia_anterior = 0;
				};

				$salida = $detalle->existencias;

				event(new ActualizacionProducto($producto->producto_id, 'Compra Borrada', 0,$salida, $existencia_anterior, $existencia_anterior - $salida,0));
			
				//Movimiento de Producto
				$newExistencias = 0;
				$updateExistencia = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->update(['existencias' => $newExistencias]);

				
			}

			if($compra->tipo_pago_id == 3 )
			{
				$cuentaporpagar = CuentaPorPagar::where('proveedor_id', $compra->proveedor_id)->first();

				$total = $cuentaporpagar->total;
				$NuevoTotal = $total - $compra->total_factura;

				$detallecuenta = array(
					'num_factura' => 'Fac-'.$compra->num_factura,
					'fecha' => carbon::now(),
					'descripcion' => 'Se elimino compra',
					'cargos' => 0,	
					'abonos' => $compra->total_factura,
					'saldo' => $NuevoTotal
				);
				
				$cuentaporpagar->detalles_cuentas_por_pagar()->create($detallecuenta);


				$cuentaporpagar->update(['total' => $NuevoTotal]);

				$compra->update(['edo_ingreso_id' => 3]);

			}
			else
			{
				$compra->update(['edo_ingreso_id' => 3]);
			}			

			
			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}

	public function destroyDetalle(DetalleCompra $detallecompra,  Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$producto = MovimientoProducto::where('id', $detallecompra->movimiento_producto_id)->get()->first();
			$existencias = $producto->existencias;
			$cantidad = $detallecompra->existencias;
			$newExistencias = $existencias - $cantidad;

			//kardex
			$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $producto->producto_id )->sum("existencias");

			if($existencia_anterior == null){
				$existencia_anterior = 0;
			};

			$salida = $detallecompra->existencias;

			event(new ActualizacionProducto($producto->producto_id, 'Compra Borrada', 0,$salida, $existencia_anterior, $existencia_anterior - $salida,0));

			//Movimiento de Producto
			$updateExistencia = MovimientoProducto::where('id', $detallecompra->movimiento_producto_id)
			->update(['existencias' => $newExistencias]);

			$ingresomaestro = Compra::where('id', $detallecompra->compra_id)->get()->first();
			$total = $ingresomaestro->total_factura;
			$totalresta = ($detallecompra->precio_compra * $detallecompra->existencias);
			$newTotal = $total - $totalresta;
			$updateTotal = Compra::where('id', $detallecompra->compra_id)
			->update(['total_factura' => $newTotal]);

			//Actualiza cuenta por pagar

			if($ingresomaestro->tipo_pago_id == 3)
			{
				$cuentaporpagar = CuentaPorPagar::where('proveedor_id', $ingresomaestro->proveedor_id)->first();

				$totalactual = $cuentaporpagar->total;

				$NuevoTotal = $totalactual - $totalresta;

				$detallecuenta = array(
					'num_factura' => 'Fac-'.$ingresomaestro->num_factura,
					'fecha' => carbon::now(),
					'descripcion' => 'Se elimino detalle de compra',
					'cargos' => 0,	
					'abonos' => $totalresta,
					'saldo' => $NuevoTotal
				);
				
				$cuentaporpagar->detalles_cuentas_por_pagar()->create($detallecuenta);


				$cuentaporpagar->update(['total' => $NuevoTotal]);
				$detallecompra->delete();

			}

			else
			{
				$detallecompra->delete();
			}
			
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
		
		$query = 'SELECT  c.id, c.serie_factura, c.num_factura, DATE_FORMAT(c.fecha_factura, "%d-%m-%Y") as fecha_factura, proveedores.nombre, TRUNCATE(c.total_factura,2) as total,
		IF((SELECT sum(mp.vendido) FROM compras
				INNER JOIN detalles_compras dc on compras.id = dc.compra_id 
				INNER JOIN movimientos_productos mp on mp.id = dc.movimiento_producto_id WhERE compras.id = c.id) > 0, 1, 0) as vendido
				FROM compras c
				INNER JOIN proveedores ON proveedores.id=c.proveedor_id WhERE c.edo_ingreso_id !=3 ';

		
		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}

	public function getJsonDetalle(Request $params, $detalle)
	{
		$query = 'SELECT dc.id, dc.compra_id, p.codigo_barra, p.nombre, m.codigo_maquina, m.nombre_maquina, dc.existencias, dc.precio_compra, dc.precio_venta, mp.vendido
		FROM detalles_compras dc
		left join productos p on p.id = dc.producto_id
		left join maquinarias_y_equipos m on m.id = dc.maquinaria_equipo_id
		inner JOIN movimientos_productos mp on mp.id = dc.movimiento_producto_id where dc.compra_id ='.$detalle.'';

		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}

	public function rpt_compras(Request $request)
    {
        $fecha_inicial = $request['fecha_inicial'];
        $fecha_final = $request['fecha_final'];

        $query = "SELECT  c.id, c.serie_factura, c.num_factura, DATE_FORMAT(c.fecha_factura, '%d-%m-%Y') as fecha_factura, proveedores.nombre, TRUNCATE(c.total_factura,2) as total,
		IF((SELECT sum(mp.vendido) FROM compras
				INNER JOIN detalles_compras dc on compras.id = dc.compra_id 
				INNER JOIN movimientos_productos mp on mp.id = dc.movimiento_producto_id WhERE compras.id = c.id) > 0, 1, 0) as vendido
				FROM compras c
				INNER JOIN proveedores ON proveedores.id=c.proveedor_id WhERE c.edo_ingreso_id !=3
				AND c.fecha_factura BETWEEN '".$fecha_inicial."' AND '".$fecha_final." 23:59:59 ' ";

		$detalles = DB::select($query);
		
		$query2 = "SELECT SUM(c.total_factura) as total FROM compras c where c.edo_ingreso_id !=3
		AND c.fecha_factura BETWEEN '".$fecha_inicial."' AND '".$fecha_final." 23:59:59' ";
		$total_general = DB::select($query2);

        $fecha_inicial = Carbon::parse($fecha_inicial)->format('d/m/Y');
        $fecha_final = Carbon::parse($fecha_final)->format('d/m/Y');
    
        $pdf = PDF::loadView('pdf.rpt_compra', compact('detalles', 'fecha_inicial', 'fecha_final', 'total_general'));
        return $pdf->stream('Compras.pdf');
    }
    
    public function rpt_compras_generar()
    {
        return view("compras.rptGenerar");
    }

}
