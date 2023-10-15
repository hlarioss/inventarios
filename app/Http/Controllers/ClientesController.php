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
Use App\Cliente;
Use App\TipoCliente;
use App\ClasificacionCliente;

class ClientesController extends Controller
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
        return view ("clientes.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $user = Auth::user()->id;
       $tipos_clientes = TipoCliente::all();
       $clasificaciones = ClasificacionCliente::all();
       return view("clientes.create" , compact( "user", "tipos_clientes", 'clasificaciones'));
    }

    public function cargarSelect()
	{
		$query = "SELECT * FROM clientes ";

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
        $data["user_id"] = Auth::user()->id;
        $cliente = cliente::create($data);

        return Response::json($cliente);
    }

    public function store2(Request $request)
    {       

        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        $cliente = cliente::create($data);
        return Response::json($cliente);
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
		$query = Cliente::where("nit",$dato)->get();
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
		$dato = Input::get("dpi");
		$query = Cliente::where("dpi",$dato)->get();
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
    public function edit(Cliente $cliente)
    {
        $query = "SELECT * FROM clientes WHERE id=".$cliente->id."";
        $fieldsArray = DB::select($query);

        $clasificaciones = ClasificacionCliente::all();
        $tipos_clientes = TipoCliente::all();
        return view('clientes.edit', compact('cliente', 'fieldsArray', 'tipos_clientes', 'clasificaciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Cliente $cliente, Request $request)
    {
        $this->validate($request,['nit' => 'required|unique:clientes,nit,'.$cliente->id
        ]);
        $this->validate($request,['dpi' => 'required|unique:clientes,dpi,'.$cliente->id
        ]);
        Response::json( $this->updateCliente($cliente , $request->all()));
        return redirect('/clientes');
    }

    public function updateCliente(Cliente $cliente, array $data )
    {
        $id= $cliente->id;
        $cliente->nit = $data["nit"];
        $cliente->nombres = $data["nombres"];
        $cliente->apellidos = $data["apellidos"];
        $cliente->telefonos = $data["telefonos"];
        $cliente->direccion = $data["direccion"];
        $cliente->email = $data["email"];
        $cliente->tipo_cliente_id = $data["tipo_cliente_id"];
        $cliente->save();

        return $cliente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $cliente->id;
            $cliente->delete();
            
            $response["response"] = "El tipo cliente ha sido eliminado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }

    public function getDatos(cliente $cliente) {

		return Response::json($cliente);
	}
    public function getJson(Request $params)
    {
        
        $query = "SELECT C.nombres, C.apellidos, C.nit, C.direccion,C.telefonos, C.id 
        from clientes C";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
