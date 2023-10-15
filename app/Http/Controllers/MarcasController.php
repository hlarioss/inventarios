<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Marca;
use App\TipoMarca;
Use App\User;
use Illuminate\Support\Facades\Input;

class MarcasController extends Controller
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

        return view ("marcas.index");

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos_marcas= TipoMarca::all();
        return view("marcas.create", compact('tipos_marcas'));
    }

    public function cargarSelect()
	{
		$query = "SELECT * FROM marcas WHERE tipo_marca_id=".'1'." OR tipo_marca_id='2' ";

		$result = DB::select($query);
		return Response::json( $result );		
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
        $marca = Marca::create($data);

        return Response::json($marca);
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
    public function edit(Marca $marca)
    {
        $query = "SELECT * FROM marcas WHERE id=".$marca->id."";
        $fieldsArray = DB::select($query);

        $tipos_marcas = TipoMarca::all();

        return view('marcas.edit', compact('marca', 'fieldsArray', 'tipos_marcas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Marca $marca, Request $request)
    {
        Response::json( $this->updateMarca($marca , $request->all()));
        return redirect('/marcas');
    }

    public function updateMarca(Marca $marca, array $data )
    {
        $id= $marca->id;
        $marca->nombre = $data["nombre"];
        $marca->tipo_marca_id = $data['tipo_marca_id'];
        $marca->save();

        return $marca;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marca $marca, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $marca->id;
            $marca->delete();
            
            $response["response"] = "La marca ha sido eliminado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }
    public function marcaDisponible()
	{
		$dato = Input::get("nombre");
		$query = Marca::where("nombre",$dato)->get();
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
    public function getJson(Request $params)
    {
        
        $query = "select M.id, M.nombre, T.nombre as tipo_marca_id
        from marcas M
        inner join tipos_marca T on T.id=M.tipo_marca_id";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
