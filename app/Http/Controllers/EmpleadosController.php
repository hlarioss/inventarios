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
Use App\Empleado;
Use App\Puesto;

class EmpleadosController extends Controller
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
        return view ("empleados.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $user = Auth::user()->id;
       $puestos = Puesto::all();
       return view("empleados.create" , compact( "user", "puestos"));
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
        $empleado = empleado::create($data);

        return Response::json($empleado);
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
    public function nitDisponible()
	{
		$dato = Input::get("nit");
		$query = Empleado::where("nit",$dato)->get();
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
    public function dpiDisponible()
	{
		$dato = Input::get("emp_cui");
		$query = Empleado::where("emp_cui",$dato)->get();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        $query = "SELECT * FROM empleados WHERE id=".$empleado->id."";
        $fieldsArray = DB::select($query);

        $puestos = Puesto::all();
        return view('empleados.edit', compact('empleado', 'fieldsArray', 'puestos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Empleado $empleado, Request $request)
    {
        $this->validate($request,['nit' => 'required|unique:empleados,nit,'.$empleado->id
        ]);
        $this->validate($request,['emp_cui' => 'required|unique:empleados,emp_cui,'.$empleado->id
        ]);
        Response::json( $this->updateEmpleado($empleado , $request->all()));
        return redirect('/empleados');
    }

    public function updateEmpleado(Empleado $empleado, array $data )
    {
        $id= $empleado->id;
        $empleado->nombre = $data["nombre"];
        $empleado->apellido = $data["apellido"];
        $empleado->nit = $data["nit"];
        $empleado->emp_cui = $data["emp_cui"];
        $empleado->telefono = $data["telefono"];
        $empleado->direccion = $data["direccion"];
        $empleado->puesto_id = $data["puesto_id"];
        $empleado->fecha_inicio = $data["fecha_inicio"];
		$empleado->fecha_nacimiento = $data["fecha_nacimiento"];
        $empleado->save();

        return $empleado;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $empleado->id;
            $empleado->delete();
            
            $response["response"] = "el Empleado ha sido eliminado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }

    public function getInfo(Request $request)
	{
		$empleado = $request["data"];

		if ($empleado == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT e.nombre, e.apellido, p.sueldo 

            FROM empleados e
            
            INNER JOIN puestos p on p.id = e.puesto_id WHERE e.id ='".$empleado."'";
				$result = DB::select($query);
				return Response::json( $result);
			}

    }
    
    public function getJson(Request $params)
    {
        $query = "SELECT * FROM empleados";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
