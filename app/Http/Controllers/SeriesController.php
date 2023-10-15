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
Use App\Serie;
Use App\Documento;
use App\EstadoSerie;

class SeriesController extends Controller
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
        return view ("series.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $user = Auth::user()->id;
       $estados = EstadoSerie::all();
       $documentos = Documento::all();
       
       return view("series.create" , compact( "user", "estados","documentos"));
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
               
        $serie = serie::create($data);

        return Response::json($serie);
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
    public function edit(Serie $serie)
    {
        $query = "SELECT * FROM series WHERE id=".$serie->id."";
        $fieldsArray = DB::select($query);
        $estados = EstadoSerie::all();
        $documentos = Documento::all();
        return view('series.edit', compact('serie', 'fieldsArray', 'estados','documentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Serie $serie, Request $request)
    {
        
        Response::json( $this->updateSerie($serie , $request->all()));
        return redirect('/series');
    }

    public function updateSerie(Serie $serie, array $data )
    {
        $id= $serie->id;
        $serie->resolucion = $data["resolucion"];
        $serie->serie = $data["serie"];
        $serie->fecha_resolucion = $data["fecha_resolucion"];
        $serie->fecha_vencimiento = $data["fecha_vencimiento"];
        $serie->inicio = $data["inicio"];
        $serie->fin = $data["fin"];
        $serie->estado_id = $data["estado_id"];
        $serie->documento_id = $data["documento_id"];
        $serie->save();

        return $serie;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Serie $serie, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $serie->id;
            $serie->delete();
            
            $response["response"] = "La Serie ha sido eliminada";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }

    public function getDatos(Serie $serie) {

		return Response::json($serie);
	}
    public function getJson(Request $params)
    {
       
        $query = "SELECT S.id, S.resolucion, S.serie, S.fecha_resolucion, S.fecha_vencimiento, S.inicio, S.fin, E.estado as estado, D.descripcion as documento
        from series S
        INNER JOIN estados_serie E on E.id = S.estado_id 
        INNER JOIN documentos D on D.id = S.documento_id";

        

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }

    public function rangoDisponible()
    {
        $inicio = Input::get("inicio");
        $fin = Input::get('fin');
        $serie = Input::get("serie");

        $query = 'select s.serie, s.inicio, s.fin FROM series s  WHERE s.serie = "'.$serie.'" and s.fin >= "'.$inicio.'" ';
        $series = DB::select($query);
        
		$contador = count($series);
		if ($contador == 0)
		{
			return 'false';
		}
		else
		{
			return 'true';
		}
    }
    
    public function rangoDisponible_edit()
    {
        $inicio = Input::get("inicio");
        $fin = Input::get('fin');
        $serie = Input::get("serie");
        $serie_id = Input::get("serie_id");

        $query = 'select s.serie, s.inicio, s.fin FROM series s  WHERE s.serie = "'.$serie.'" and s.fin >= "'.$inicio.'" AND s.id != "'.$serie_id.'" AND s.id <= "'.$serie_id.'" ';
        $series = DB::select($query);
        
		$contador = count($series);
		if ($contador == 0)
		{
			return 'false';
		}
		else
		{
			return 'true';
		}
	}
}
