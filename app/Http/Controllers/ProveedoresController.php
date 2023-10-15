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
Use App\Proveedor;
Use App\TipoProveedor;

class ProveedoresController extends Controller
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
        return view ("proveedores.index");
    }

    public function cargarSelect()
	{
		$query = "SELECT * FROM proveedores ";

		$result = DB::select($query);
		return Response::json( $result );		
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $user = Auth::user()->id;
       $tipos_proveedores = TipoProveedor::all();
       return view("proveedores.create" , compact( "user", "tipos_proveedores"));
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
        $proveedor = proveedor::create($data);

        return Response::json($proveedor);
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
		$query = Proveedor::where("nit",$dato)->get();
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
    public function edit(Proveedor $proveedor)
    {
        $query = "SELECT * FROM proveedores WHERE id=".$proveedor->id."";
        $fieldsArray = DB::select($query);

        $tipos_proveedores = TipoProveedor::all();
        return view('proveedores.edit', compact('proveedor', 'fieldsArray','tipos_proveedores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Proveedor $proveedor, Request $request)
    {
        $this->validate($request,['nit' => 'required|unique:proveedores,nit,'.$proveedor->id
        ]);
        Response::json( $this->updateProveedor($proveedor , $request->all()));
        return redirect('/proveedores');
    }

    public function updateProveedor(Proveedor $proveedor, array $data )
    {
        $id= $proveedor->id;
        $proveedor->nit = $data["nit"];
        $proveedor->nombre = $data["nombre"];
        $proveedor->telefonos = $data["telefonos"];
        $proveedor->direccion = $data["direccion"];
        $proveedor->save();

        return $proveedor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedor, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $proveedor->id;
            $proveedor->delete();
            
            $response["response"] = "El tipo proveedor ha sido eliminado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }


    public function getJson(Request $params)
    {
        $query = "SELECT * FROM proveedores";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
