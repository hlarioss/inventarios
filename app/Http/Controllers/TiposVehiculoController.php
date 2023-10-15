<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\TipoVehiculo;
Use App\User;

class TiposVehiculoController extends Controller
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

        return view ("tipos_vehiculo.index");

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("tipos_vehiculo.create");
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
        $tipo_vehiculo = TipoVehiculo::create($data);

        return Response::json($tipo_vehiculo);
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
    public function edit(TipoVehiculo $tipo_vehiculo)
    {
        $query = "SELECT * FROM tipos_vehiculo WHERE id=".$tipo_vehiculo->id."";
        $fieldsArray = DB::select($query);

        return view('tipos_vehiculo.edit', compact('tipo_vehiculo', 'fieldsArray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoVehiculo $tipo_vehiculo, Request $request)
    {
        Response::json( $this->updateTipoVehiculo($tipo_vehiculo , $request->all()));
        return redirect('/tipos_vehiculo');
    }

    public function updateTipoVehiculo(TipoVehiculo $tipo_vehiculo, array $data )
    {
        $id= $tipo_vehiculo->id;
        $tipo_vehiculo->nombre = $data["nombre"];
        $tipo_vehiculo->save();

        return $tipo_vehiculo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoVehiculo $tipo_vehiculo, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $tipo_vehiculo->id;
            $tipo_vehiculo->delete();
            
            $response["response"] = "El tipo vehiculo ha sido eliminado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }


    public function getJson(Request $params)
    {
        $query = "SELECT * FROM tipos_vehiculo";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
