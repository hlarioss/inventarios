<?php

namespace App\Http\Controllers;

use App\Bodega;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Localidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Validator;


class LocalidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $bodegas=Bodega::where('estado',1)->get();
        return view ("localidades.index", compact('bodegas'));
    }
    public function store(Request $request)
    {       
        $data = $request->all();
        $localidad = new Localidad();
        $localidad->nombre=$data['nombre'];
        $localidad->bodega_id = $data['bodega_id'];
        $localidad->save();                       

        
        return Response::json(['success' => 'Éxito']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Localidad $localidad, Request $request)
    {

        $respuesta = $request->all();
        $localidada=$localidad;
        $localidad->nombre = $request->nombre;
        $localidad->bodega_id = $request->bodega_id;
        $localidad->save();
 
        return Response::json(['success' => 'Éxito']);
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Localidad $localidad, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $localidad->id;
            $localidad->estado = 0;
            $localidad->save();
 
            
            $response["response"] = "La bodega ha sido eliminado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        } 
          
        
    }


    public function getjson(Request $params)
    {

        $query = 'SELECT  L.id as id, L.nombre as nombre, L.bodega_id as bodega_id, B.nombre as bodega, L.created_at as fecha
        from localidades L
        INNER JOIN bodegas B on L.bodega_id=B.id
        where L.estado=1';

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
