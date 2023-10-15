<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\TipoCliente;
Use App\User;

class TiposClienteController extends Controller
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
        $tiposcliente = TipoCliente::all();
        return view ("tipos_cliente.index");

        //return view ('tipos_cliente.index2', compact('tiposcliente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("tipos_cliente.create");
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
        $tipo_cliente = TipoCliente::create($data);

        return Response::json($tipo_cliente);
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
    public function edit(TipoCliente $tipo_cliente)
    {
        $query = "SELECT * FROM tipos_cliente WHERE id=".$tipo_cliente->id."";
        $fieldsArray = DB::select($query);

        return view('tipos_cliente.edit', compact('tipo_cliente', 'fieldsArray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoCliente $tipo_cliente, Request $request)
    {
        Response::json( $this->updateTipoCliente($tipo_cliente , $request->all()));
        return redirect('/tipos_cliente');
    }

    public function updateTipoCliente(TipoCliente $tipo_cliente, array $data )
    {
        $id= $tipo_cliente->id;
        $tipo_cliente->nombre = $data["nombre"];
        $tipo_cliente->descuento = $data["descuento"];
        $tipo_cliente->monto_mensual = $data["monto_mensual"];
        $tipo_cliente->save();

        return $tipo_cliente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoCliente $tipo_cliente, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $tipo_cliente->id;
            $tipo_cliente->delete();
            
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
        
        $query = "SELECT * FROM tipos_cliente";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
