<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\UnidadDeMedida;
Use App\User;

class UnidadesDeMedidaController extends Controller
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

        return view ("unidades_de_medida.index");

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidades_de_medida = UnidadDeMedida::all();
        return view("unidades_de_medida.create",compact('unidades_de_medida'));
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

        if($data['unidad_de_medida_id'] == ""){
            $data['unidad_de_medida_id'] = null;
        }

        $unidad_de_medida = UnidadDeMedida::create($data);
        //dd($data);

        return Response::json($unidad_de_medida);
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

    public function getCantidad(UnidadDeMedida $unidad_de_medida) {

		return Response::json($unidad_de_medida);
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(UnidadDeMedida $unidad_de_medida)
    {
        $query = "SELECT * FROM unidades_de_medida WHERE id=".$unidad_de_medida->id."";
        $fieldsArray = DB::select($query);
        $unidades_de_medida = UnidadDeMedida::all();

        return view('unidades_de_medida.edit', compact('unidad_de_medida', 'fieldsArray', 'unidades_de_medida'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnidadDeMedida $unidad_de_medida, Request $request)
    {
        Response::json( $this->updateUnidadDeMedida($unidad_de_medida , $request->all()));
        return redirect('/unidades_de_medida');
    }

    public function updateUnidadDeMedida(UnidadDeMedida $unidad_de_medida, array $data )
    {
        $id= $unidad_de_medida->id;
        $unidad_de_medida->descripcion = $data["descripcion"];
        $unidad_de_medida->cantidad = $data["cantidad"];
        
        if($data['unidad_de_medida_id'] == ""){
            $data['unidad_de_medida_id'] = null;
        }
        $unidad_de_medida->unidad_de_medida_id = $data['unidad_de_medida_id'];
        $unidad_de_medida->save();

        return $unidad_de_medida;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnidadDeMedida $unidad_de_medida, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $unidad_de_medida->id;
            $unidad_de_medida->delete();
            
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
        $query = "SELECT u.id, u.descripcion, u.cantidad, u2.descripcion as unidad_de_medida FROM unidades_de_medida u
        LEFT JOIN unidades_de_medida u2 on u2.id = u.unidad_de_medida_id";


        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
