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
Use App\PrecioProducto;
Use App\Producto;

class PreciosProductoController extends Controller
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
        return view ("precios_producto.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $user = Auth::user()->id;
       $productos = Producto::all();
       $fecha= Carbon::now();
       return view("precios_producto.create" , compact( "user", "productos", "fecha"));
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
        $precio_producto = PrecioProducto::create($data);

        return Response::json($precio_producto);
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
    public function edit(PrecioProducto $precio_producto)
    {
        $query = "SELECT * FROM precios_producto WHERE id=".$precio_producto->id."";
        $fieldsArray = DB::select($query);

        $productos = Producto::all();
        return view('precios_producto.edit', compact('precio_producto', 'fieldsArray', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PrecioProducto $precio_producto, Request $request)
    {
        Response::json( $this->updatePrecioProducto($precio_producto , $request->all()));
        return redirect('/precios_producto');
    }

    public function updatePrecioProducto(PrecioProducto $precio_producto, $data )
    {
        $data["user_id"] = Auth::user()->id;
        $data['fecha']=Carbon::now();
        $precio_producto=PrecioProducto::create($data);
        return $precio_producto;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrecioProducto $precio_producto, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $precio_producto->id;
            $precio_producto->delete();
            
            $response["response"] = "El tipo precio_producto ha sido eliminado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }

    public function getJson(Request $params)
    {
        $query = "SELECT pp.id as id, pp.precio_venta as precio_venta, pp.fecha as fecha, p.nombre as producto,p.codigo_barra as codigo FROM precios_producto pp
        INNER JOIN productos p on pp.producto_id=p.id;
        ";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
