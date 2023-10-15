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
use App\Vehiculo;
use App\TipoVehiculo;
use App\Marca;
use App\User;
use App\Transmision;
use App\Cliente;
use App\Traccion;
use App\Tipo_caja;
use App\Combustible;
use App\Direccion;
use App\Linea;
use App\Color;
use App\TipoMarca;

class VehiculosController extends Controller
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
        return view("vehiculos.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $query = "SELECT * FROM marcas WHERE tipo_marca_id=".'1'." OR tipo_marca_id='2'";
        
        $marcas = DB::select($query);

        $tipos_vehiculos = TipoVehiculo::all();
        $tipos_transmision = Transmision::all();
        $clientes = Cliente::all();
        $lineas= Linea::all();
        $colores= Color::all();
        $direcciones= Direccion::all();
        $tipos_caja= Tipo_caja::all();
        $combustibles= Combustible::all();
        $tracciones= Traccion::all();
        $tipos_marcas=TipoMarca::all();

        return view("vehiculos.create" , compact("tipos_marcas","colores","lineas","combustibles","tipos_caja","direcciones","tracciones","tipos_vehiculos", "marcas","tipos_transmision", "clientes"));
    }

    public function cargarSelect()
	{
		$query = "SELECT * FROM vehiculos ";

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
        
        $vehiculo = Vehiculo::create($data);


        return Response::json($vehiculo);
    }

    public function store2(Request $request)
    {
        $data = $request->all();
        $vehiculo = Vehiculo::create($data);

        return back();
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

    public function getDatos($cliente_id, Vehiculo $vehiculo) {
        $cliente=$cliente_id;
            if ($cliente == "")
            {
                $result = "";
                return Response::json( $result);
                
            }
            else {
                $query = "SELECT * FROM vehiculos
                            where vehiculos.cliente_id='$cliente'";
                $result = DB::select($query);
                return Response::json( $result);
            }
    }

    public function placaDisponible()
	{
		$dato = Input::get("placa");
		$query = Vehiculo::where("placa",$dato)->get();
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
    
    public function vinDisponible()
	{
		$dato = Input::get("vin");
		$query = Vehiculo::where("vin",$dato)->get();
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
    public function edit(Vehiculo $vehiculo)
    {
        $query = "SELECT * FROM vehiculos WHERE id=".$vehiculo->id."";
        $fieldsArray = DB::select($query);

        $query2 = "SELECT * FROM marcas WHERE tipo_marca_id=".'1'." OR tipo_marca_id='2'";
        $marcas = DB::select($query2);
        if($vehiculo->transmision_id==1){
            $query4= "SELECT * from tipos_caja limit 2";
        }else{
        $query4= "SELECT * from tipos_caja order by id desc limit 1";
        }

        $tipos_vehiculos = TipoVehiculo::all();
        $tipos_transmision = Transmision::all();
        $clientes = Cliente::all();
        $query3= "SELECT * FROM linea WHERE linea.marca_id=".$vehiculo->marca_id."";
        $lineas = DB::select($query3);
        $colores= Color::all();
        $direcciones= Direccion::all();
        $tipos_caja= DB::select($query4);
        $combustibles= Combustible::all();
        $tracciones= Traccion::all();

        return view('vehiculos.edit', compact('vehiculo', 'fieldsArray', "colores","lineas","combustibles","tipos_caja","direcciones","tracciones","tipos_vehiculos", "marcas","tipos_transmision", "clientes"));
    }

    /**
     * Updata the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Vehiculo $vehiculo, Request $request)
    {
        $this->validate($request,['placa' => 'required|unique:vehiculos,placa,'.$vehiculo->id, 'vin' => 'required|unique:vehiculos,vin,'.$vehiculo->id
        ]);
        

        Response::json( $this->updateVehiculo($vehiculo , $request->all()));
        return redirect('/vehiculos');
    }

    public function updateVehiculo(Vehiculo $vehiculo, array $data )
    {
        $id= $vehiculo->id;
        $vehiculo->placa = $data["placa"];   
        $vehiculo->tipo_vehiculo_id = $data["tipo_vehiculo_id"];
        $vehiculo->marca_id = $data["marca_id"];
        $vehiculo->linea_id = $data["linea_id"];
        $vehiculo->kilometraje = $data["kilometraje"];
        $vehiculo->anio = $data["anio"];
        $vehiculo->color_id = $data["color_id"];
        $vehiculo->fecha_ultimo_servicio = $data["fecha_ultimo_servicio"];
        $vehiculo->vin = $data["vin"];
        $vehiculo->cliente_id = $data["cliente_id"];
        $vehiculo->direccion_id = $data["direccion_id"];

        $vehiculo->transmision_id = $data["transmision_id"];
        $vehiculo->traccion_id = $data["traccion_id"];
        $vehiculo->diferenciales = $data["diferenciales"];
        $vehiculo->tipo_caja_id = $data["tipo_caja_id"];
        $vehiculo->aceite_caja_fabrica = $data["aceite_caja_fabrica"];
        $vehiculo->aceite_caja = $data["aceite_caja"];
        $vehiculo->cantidad_aceite_caja = $data["cantidad_aceite_caja"];
        $vehiculo->viscosidad_caja = $data["viscosidad_caja"];


        $vehiculo->combustible_id = $data["combustible_id"];
        $vehiculo->no_motor = $data["no_motor"];
        $vehiculo->ccs = $data["ccs"];
        $vehiculo->cilindros = $data["cilindros"];
        $vehiculo->aceite_motor_fabrica = $data["aceite_motor_fabrica"];
        $vehiculo->aceite_motor = $data["aceite_motor"];
        $vehiculo->cantidad_aceite_motor = $data["cantidad_aceite_motor"];
        $vehiculo->viscosidad_motor = $data["viscosidad_motor"];
        $vehiculo->observaciones = $data["observaciones"];
        $vehiculo->save();
        return $vehiculo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehiculo $vehiculo, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $vehiculo->id;
            $vehiculo->delete();
            
            $response["response"] = "El vehiculo se ha Eliminado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }

    public function getJson(Request $params)
    {
       
        $query = "SELECT V.id AS id, V.placa, V.aceite_caja, V.aceite_motor, V.fecha_ultimo_servicio, V.kilometraje, TV.nombre as tipo_vehiculo 
                    from vehiculos V
                    inner Join tipos_vehiculo TV on TV.id = V.tipo_vehiculo_id";


        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
