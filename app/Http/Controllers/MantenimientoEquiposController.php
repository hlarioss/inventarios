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
Use App\MantenimientoEquipo;
Use App\MaquinariaEquipo;
use App\Proveedor;

class MantenimientoEquiposController extends Controller
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
        return view ("manttoequipo.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedores =Proveedor::all();
        $maquinarias = MaquinariaEquipo::all();
        return view("manttoequipo.create" , compact("maquinarias" , "proveedores"));
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
        $manttoequipo = MantenimientoEquipo::create($data);

        return Response::json($manttoequipo);
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
    public function edit(MantenimientoEquipo $manttoequipo)
    {
        $query = "SELECT * FROM mantto_equipo WHERE id=".$manttoequipo->id."";
        $fieldsArray = DB::select($query);

        $proveedores =Proveedor::all();
        $maquinarias = MaquinariaEquipo::all();
        return view('manttoequipo.edit', compact('manttoequipo', 'fieldsArray', 'maquinarias','proveedores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MantenimientoEquipo $manttoequipo, Request $request)
    {
        Response::json( $this->updateManttoEquipo($manttoequipo , $request->all()));
        return redirect('/mantto_equipo');
    }

    public function updateManttoEquipo(MantenimientoEquipo $manttoequipo, array $data )
    {
        $id= $manttoequipo->id;
        $manttoequipo->descripcion = $data["descripcion"];
        $manttoequipo->fecha_proximo_servicio = $data["fecha_proximo_servicio"];
        $manttoequipo->fecha_servicio = $data["fecha_servicio"];
        $manttoequipo->labadas_servicio = $data["labadas_servicio"];
        $manttoequipo->labadas_proximo_servicio = $data["labadas_proximo_servicio"];
        $manttoequipo->maquinaria_id = $data["maquinaria_id"];
        $manttoequipo->proveedor_id = $data["proveedor_id"];
                
        $manttoequipo->save();

        return $manttoequipo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MantenimientoEquipo $manttoequipo, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $manttoequipo->id;
            $manttoequipo->delete();
            
            $response["response"] = "El registro del mantenimiento se ha eliminado correctamente";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }

    public function getJson(Request $params)
    {
        $query = "SELECT P.nombre as prov, m.id, m.descripcion, m.fecha_proximo_servicio, c.nombre_maquina  as nombre, m.labadas_servicio, m.fecha_servicio, m.labadas_proximo_servicio 
        FROM mantto_equipo m 
        INNER JOIN maquinarias_y_equipos C ON m.maquinaria_id=C.id 
        INNER JOIN proveedores P on m.proveedor_id = P.id";
        
        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
