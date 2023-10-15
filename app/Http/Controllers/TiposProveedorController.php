<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\TipoProveedor;
Use App\User;

class TiposProveedorController extends Controller
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
        return view ("tipos_proveedor.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("tipos_proveedor.create");
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
        $tipo_proveedor = TipoProveedor::create($data);

        return Response::json($tipo_proveedor);
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
    public function edit(TipoProveedor $tipo_proveedor)
    {
        $query = "SELECT * FROM tipos_proveedor WHERE id=".$tipo_proveedor->id."";
        $fieldsArray = DB::select($query);

        return view('tipos_proveedor.edit', compact('tipo_proveedor', 'fieldsArray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoProveedor $tipo_proveedor, Request $request)
    {
        Response::json( $this->updateTipoProveedor($tipo_proveedor , $request->all()));
        return redirect('/tipos_proveedor');
    }

    public function updateTipoProveedor(TipoProveedor $tipo_proveedor, array $data )
    {
        $id= $tipo_proveedor->id;
        $tipo_proveedor->nombre = $data["nombre"];
        $tipo_proveedor->save();

        return $tipo_proveedor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoProveedor $tipo_proveedor, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $tipo_proveedor->id;
            $tipo_proveedor->delete();
            
            $response["response"] = "El tipo cliente ha sido eliminado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }


    public function getJson(Request $params)
    {
        $query = "SELECT * FROM tipos_proveedor";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
