<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Marca;
use App\Linea;
Use App\User;
use Illuminate\Support\Facades\Input;

class LineasController extends Controller
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

        return view ("lineas.index");

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marcas= Marca::all();
        return view("lineas.create", compact('marcas'));
    }

    public function cargarSelect()
	{
		$query = "SELECT * FROM linea ";

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
        $linea = Linea::create($data);

        return Response::json($linea);
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
    public function edit(Linea $linea)
    {
        $query = "SELECT * FROM linea WHERE id=".$linea->id."";
        $fieldsArray = DB::select($query);

        $marcas = Marca::all();

        return view('lineas.edit', compact('linea', 'fieldsArray', 'marcas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Linea $linea, Request $request)
    {
        Response::json( $this->updateLinea($linea , $request->all()));
        return redirect('/lineas');
    }

    public function updateLinea(Linea $linea, array $data )
    {
        $id= $linea->id;
        $linea->linea = $data["linea"];
        $linea->marca_id = $data['marca_id'];
        $linea->save();

        return $linea;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Linea $linea, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $linea->id;
            $linea->delete();
            
            $response["response"] = "La Linea ha sido eliminada";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }
    public function getDatos($marca_id, Linea $linea) {
        $marca=$marca_id;
            if ($marca == "")
            {
                $result = "";
                return Response::json( $result);
                
            }
            else {
                $query = "SELECT * FROM linea
                            where linea.marca_id='$marca'";
                $result = DB::select($query);
                return Response::json( $result);
            }
    }
    public function lineaDisponible()
	{
		$dato = Input::get("linea");
		$query = Linea::where("linea",$dato)->get();
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
        $query = "SELECT L.id, L.linea, M.nombre as marca FROM linea L
                  INNER JOIN marcas M on M.id = L.marca_id";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}

