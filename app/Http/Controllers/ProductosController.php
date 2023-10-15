<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Localidad;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Producto;
use App\User;
use App\UnidadDeMedida;
use App\Marca;
//use Yajra\Datatables\Datatables;
use Barryvdh\DomPDF\Facade as PDF;

class ProductosController extends Controller
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
		return view("productos.index");
	}

	public function existenciasIndex()
	{
		return view('productos.existencias');
	}



	public function existencias(Request $params)
	{

		$query = "SELECT l.nombre as ubicacion, m.nombre as id, p.nombre,p.codigo_barra, IF(SUM(mp.existencias) IS NULL,0,SUM(mp.existencias)) AS existencias,
		p.descripcion as minimo, IF(MAX(mp.fecha_ingreso) IS NULL,0,MAX(mp.fecha_ingreso)) as ultimo_ingreso FROM productos p
		LEFT JOIN movimientos_productos mp on p.id = mp.producto_id
		LEFT JOIN marcas m on p.marca_id = m.id
		LEFT JOIN localidades l on p.localidad_id=l.id
		 GROUP BY p.nombre, p.id";
        
		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}

	public function kardexIndex()
	{
		$query = "SELECT DISTINCT l.nombre as ubicacion, k.id,k.fecha, p.codigo_barra, p.nombre, k.transaccion, k.ingreso as cantidad_ingreso, k.salida as cantidad_salida, k.existencia_anterior, k.saldo,k.costo_ponderado as ponderado,k.costo_entrada as entrada,k.costo_salida as salida,k.costo_anterior as anterior,k.costo_acumulado as acumulado from kardex k 
		LEFT JOIN productos p on p.id = k.producto_id
		LEFT JOIN localidades l on p.localidad_id=l.id
		order by k.id  ";
		$kardex = DB::select($query);
		
		return view('productos.kardex2', compact('kardex'));
	}

	public function rpt_kardex(Request $request)
    {
        $fecha_inicial = $request['fecha_inicial'];
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
    
    public function rpt_generar_kardex()
    {
        return view("productos.rptGenerarKardex");
	}
	
	public function rpt_kardex_producto(Request $request)
    {
		$idProducto = $request['producto_id'];
        $fecha_inicial = $request['fecha_inicial'];
        $fecha_final = $request['fecha_final'];

        $query = "SELECT l.nombre as ubicacion, k.id, DATE_FORMAT(k.fecha, '%d-%m-%Y') as fecha , p.codigo_barra, p.nombre, k.transaccion, k.ingreso, k.salida, k.existencia_anterior, k.saldo
		FROM kardex k
		INNER JOIN productos p on p.id = k.producto_id
		LEFT JOIN localidades l on p.localidad_id = l.id
		WHERE p.id = '".$idProducto."' AND k.fecha BETWEEN '".$fecha_inicial."' AND '".$fecha_final." 23:59:59' ";
		$detalles = DB::select($query);
		
		$query2 = "SELECT p.nombre FROM productos p WHERE p.id = '".$idProducto."' ";
        $producto = DB::select($query2);

        $fecha_inicial = Carbon::parse($fecha_inicial)->format('d/m/Y');
        $fecha_final = Carbon::parse($fecha_final)->format('d/m/Y');
    
        $pdf = PDF::loadView('pdf.rpt_kardex_producto', compact('detalles', 'fecha_inicial', 'fecha_final', 'producto'));
        return $pdf->stream('Kardex de Producto.pdf');
    }
    
    public function rpt_generar_kardex_producto()
    {
		$productos = Producto::all();
        return view("productos.rptGenerarKardexProducto", compact('productos'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$user = Auth::user()->id;
		$medidas = UnidadDeMedida::All();
		$marcas = Marca::All();
		$localidades=Localidad::where('estado',1)->get();
		return view("productos.create" , compact( "user",'medidas','marcas','localidades'));
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
		$data["user_id"] = Auth::user()->id;
		$producto = Producto::create($data);

		return Response::json($producto);
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
	public function edit(Producto $producto)
	{
		$query = "SELECT * FROM productos WHERE id=".$producto->id."";
		$fieldsArray = DB::select($query);
		$medidas = UnidadDeMedida::All();
		$marcas = Marca::All();
		$localidades=Localidad::where('estado',1)->get();

		return view('productos.edit', compact('producto', 'fieldsArray','medidas','marcas','localidades'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Producto $producto, Request $request)
	{
		$this->validate($request,['codigo_barra' => 'required|unique:productos,codigo_barra,'.$producto->id
		]);
		
		Response::json( $this->updateProducto($producto , $request->all()));
		return redirect('/productos');
	}


	public function updateProducto(Producto $producto, array $data )
	{
		
		$id= $producto->id;
		$producto->codigo_barra = $data["codigo_barra"];
        $producto->nombre = $data["nombre"];
		$producto->minimo = $data["minimo"];
		$producto->marca_id = $data["marca_id"];
		$producto->medida_id = $data["medida_id"];
		$producto->descripcion = $data["descripcion"];
		$producto->localidad_id = $data["localidad_id"];
		$producto->save();

		return $producto;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Producto $producto, Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$id= $producto->id;
			$producto->delete();
			
			$response["response"] = "El producto ha sido eliminado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}    
	}

	public function codigoDisponible()
	{
		$dato = Input::get("codigo_barra");
		$query = Producto::where("codigo_barra",$dato)->get();
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

	public function getJson()
	{
		$query = "SELECT P.nombre, P.codigo_barra, L.nombre as localidad, P.id, P.descripcion, MR.nombre as mrnombre , U.descripcion as udesc
        FROM productos P 
        INNER JOIN marcas MR ON MR.id = P.marca_id 
        INNER JOIN unidades_de_medida U on U.id = P.medida_id
        INNER JOIN localidades L on P.localidad_id=L.id ";

		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}

	public function getInfo(Request $request)
	{
		$producto = $request["data"];

		if ($producto == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query="SELECT MP.id as producto_id, 
			if(MP.fecha_ingreso is null,0,MP.fecha_ingreso) as fecha, PR.id as prod_id,
				PR.nombre,  
				if((select sum(paquete) from movimientos_productos mp where mp.producto_id=PR.id) is null,0,(select sum(paquete) from movimientos_productos mp where mp.producto_id=PR.id)) as existencias, 
				 UM.descripcion as medida, UM.cantidad as cantidadu,
				if((select precio_venta from precios_producto p where p.producto_id = PR.id order by p.id DESC limit 1) is null,0,(select precio_venta from precios_producto p where p.producto_id = PR.id order by p.id DESC limit 1))  as precio_venta, 
				(select id from precios_producto p where p.producto_id = PR.id order by p.id DESC limit 1)  as precio_id, 			
			if(MP.precio_compra is null,0,MP.precio_compra) as precio_compra,	PR.codigo_barra
						from productos PR
					left join movimientos_productos MP on PR.id=MP.producto_id and (MP.existencias>0)
					Inner join unidades_de_medida UM on UM.id = PR.medida_id
					having PR.codigo_barra = '".$producto."'
					order by MP.fecha_ingreso DESC limit 1";
			/*
			$query = "SELECT MP.id as producto_id, if(MP.fecha_ingreso is null,0,MP.fecha_ingreso) as fecha, PR.id as prod_id,
			PR.nombre, if(MP.existencias is null,0,MP.existencias) as existencias, UM.descripcion as medida, UM.cantidad as cantidadu,
			if(MP.precio_compra is null,0,MP.precio_compra) as precio_compra, PR.codigo_barra,
				if(MP.precio_venta is null,0,MP.precio_venta) as precio_venta
					from productos PR
				left join movimientos_productos MP on PR.id=MP.producto_id and (MP.existencias>0)
				Inner join unidades_de_medida UM on UM.id = PR.medida_id
				having PR.codigo_barra = '".$producto."'
				order by MP.fecha_ingreso DESC limit 1";*/
				$result = DB::select($query);
				return Response::json( $result);
			}

	}

	public function getPrecio(Producto $producto) {

		return Response::json($producto);
	}


	public function getJsonExistencia(Request $params)
	{
		$api_Result = array();
		$columnsMapping = array( "productos.id", "codigo_barra", "nombre", "movimientos_productos.precio_compra", "existencias");


		$api_logsQueriable = DB::table('productos');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'SELECT productos.id AS Codigo, productos.codigo_barra, productos.nombre, IF(movimientos_productos.precio_compra IS NULL,0,ROUND(movimientos_productos.precio_compra,4)) AS precio_compra, IF(SUM(movimientos_productos.existencias) IS NULL,0,SUM(movimientos_productos.existencias)) AS existencias, IF(SUM(movimientos_productos.existencias) IS NULL,0,ROUND(SUM(movimientos_productos.existencias) * movimientos_productos.precio_compra,4)) AS total_neto FROM productos  LEFT JOIN movimientos_productos ON productos.id=movimientos_productos.producto_id ';

		$where = "";

		if (isset($params->search['value']) && !empty($params->search['value'])){

			foreach ($columnsMapping as $column) {
				if (strlen($where) == 0) {
					$where .=" where (".$column." like  '%".$params->search['value']."%' ";
				} else {
					$where .=" or ".$column." like  '%".$params->search['value']."%' ";
				}

			}
			$where .= ') ';
		}

		$query = $query . $where;

	// Sorting
		$sort = "";
	
		$filter = " limit ".$params->length." offset ".$params->start."";
		$group = " GROUP BY productos.id, productos.codigo_barra, movimientos_productos.precio_compra ";
		
					$data =  $query . $sort . $group;
					$result = DB::select($data);

		$api_Result['recordsFiltered'] = count($result);

					$query .= $sort . $group . $filter;

		$result = DB::select($query);

		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}
}
