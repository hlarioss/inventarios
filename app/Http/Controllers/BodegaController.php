<?php

namespace App\Http\Controllers;

use App\Bodega;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Validator;

class BodegaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view ("bodegas.index");
    }
    public function store(Request $request)
    {       
        $data = $request->all();
        $bodega = new Bodega();
        $bodega->nombre=$data['nombre'];
        $bodega->direccion = $data['direccion'];
        $bodega->save();                       

        
        return Response::json(['success' => 'Éxito']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Bodega $bodega, Request $request)
    {

        $respuesta = $request->all();
        $bodegaa=$bodega;
        $bodega->nombre = $request->nombre;
        $bodega->direccion = $request->direccion;
        $bodega->save();
 
        return Response::json(['success' => 'Éxito']);
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bodega $bodega, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $bodega->id;
            $bodega->estado = 0;
            $bodega->save();
 
            
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

        $query = 'SELECT id  as id, nombre as nombre, direccion as direccion, created_at as fecha  FROM bodegas where estado=1';

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
    public function cargarSelect()
	{

        $result = DB::table('bodegas')
        ->select('bodegas.id','bodegas.nombre')->where('estado',1)->get();

		return Response::json( $result );		
    }
}
