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
Use App\Vehiculo;
Use App\Cliente;
Use App\OrdenDeTrabajo;
Use App\OrdenTrabajoServicio;
Use App\TipoCliente;
Use App\TipoVehiculo;
Use App\Marca;
Use App\ComponentesAccesorios;
Use App\Servicio;
Use App\Golpe;
Use App\Rayon;
Use App\ClasificacionCliente;
use App\Transmision;
use App\Traccion;
use App\Tipo_caja;
use App\Combustible;
use App\Direccion;
use App\Linea;
use App\Color;

class OrdenesDeTrabajoController extends Controller
{
    public function index()
    {
        return view ("ordenes_de_trabajo.index");
    }

    public function new()
    {
        $query = "SELECT * FROM marcas WHERE tipo_marca_id=".'1'." OR tipo_marca_id='2'";
        $marcas = DB::select($query);

        $tipos_transmision = Transmision::all();
        $lineas= Linea::all();
        $colores= Color::all();
        $direcciones= Direccion::all();
        $tipos_caja= Tipo_caja::all();
        $combustibles= Combustible::all();
        $tracciones= Traccion::all();

        $clientes = Cliente::all();
        $vehiculos = Vehiculo::all();
        $tipos_clientes = TipoCliente::all();
        $tipos_vehiculos = TipoVehiculo::all();
        $clasificaciones = ClasificacionCliente::all();
		return view("ordenes_de_trabajo.create" , compact('clientes', 'vehiculos', 'tipos_clientes', 'tipos_vehiculos', 'marcas', 'clasificaciones', 'tipos_transmision', 'lineas', 'colores', 'direcciones', 'tipos_caja', 'combustibles', 'tracciones'));
    }

    public function create2(OrdenDeTrabajo $orden_de_trabajo)
    {
        $componentesAccesorios = ComponentesAccesorios::All();
        $id=$orden_de_trabajo->id;
        
        return view("ordenes_de_trabajo.create2", compact('orden_de_trabajo', 'componentesAccesorios'));
        
    }
    public function create3(OrdenDeTrabajo $orden_de_trabajo)
    {
        $id=$orden_de_trabajo->id;
        
        return view("ordenes_de_trabajo.create3", compact('orden_de_trabajo'));
        
    }
    
    public function createServicios(OrdenDeTrabajo $orden_de_trabajo)
    {
        $servicios = Servicio::all();
        
		return view("ordenes_de_trabajo.createServicios", compact('orden_de_trabajo', 'servicios'));
        
    }

    public function updateTotal(OrdenDeTrabajo $orden_de_trabajo, Request $request)
	{
        $data = $request->all();
        $orden_de_trabajo->update(['total' => $request['total']]);
        return $orden_de_trabajo;		
	}
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    // edit pagina 1
    public function edit(OrdenDetrabajo $orden)
    {
        $query = "SELECT * FROM ordenes_de_trabajo WHERE id=".$orden->id."";
        $fieldsArray = DB::select($query);
        $clientes = Cliente::all();
        $vehiculos = Vehiculo::all();
        $tipos_clientes = TipoCliente::all();
        $tipos_vehiculos = TipoVehiculo::all();
        $clasificaciones = ClasificacionCliente::all();
        $query2 = "SELECT * FROM marcas WHERE tipo_marca_id=".'1'." OR tipo_marca_id='2'";
        $marcas = DB::select($query2);

        $tipos_transmision = Transmision::all();
        $lineas= Linea::all();
        $colores= Color::all();
        $direcciones= Direccion::all();
        $tipos_caja= Tipo_caja::all();
        $combustibles= Combustible::all();
        $tracciones= Traccion::all();

        return view('ordenes_de_trabajo.editcreate', compact('orden','clientes' ,'vehiculos','tipos_clientes', 'tipos_vehiculos', 'marcas', 'clasificaciones', 'tipos_transmision', 'lineas', 'colores', 'direcciones', 'tipos_caja', 'combustibles', 'tracciones','fieldsArray'));
    }
    public function update(OrdenDetrabajo $orden, Request $request)
    {
        Response::json( $this->updateorden($orden , $request->all()));
        return redirect('/ordenes_de_trabajo/editcreate2/'.$orden->id);
    }
    public function updateorden(OrdenDetrabajo $orden, array $data )
    {
        $id= $orden->id;
        $orden->cliente_id = $data["cliente_id"];
        $orden->vehiculo_id = $data['vehiculo_id'];
        $orden->fecha_prometida = $data['fecha_prometida'];
        $orden->save();

        return $orden;
    }

    // edit pagina 2
    public function edit2(OrdenDetrabajo $orden)
    {
        $query = "SELECT * FROM componentes_accesorios WHERE orden_id=".$orden->id."";
        $componentes = DB::select($query);
        if(empty($componentes)){
            return redirect('/ordenes_de_trabajo/create2/'.$orden->id);
        }
        else{
        return view('ordenes_de_trabajo.editcreate2', compact('orden', 'componentes' ));
        }
    }

    public function update2(OrdenDetrabajo $orden, Request $request)
    {
        $query = "SELECT id FROM componentes_accesorios WHERE orden_id=".$orden->id."";
        $id = DB::select($query);
        $idd=$id[0]->id;        
        ComponentesAccesorios::find($idd)->update($request->all());
        return Response::json($id);
    
    }

    //edit pagina 3
    public function edit3(OrdenDetrabajo $orden)
    {
        $query = "SELECT * FROM rayones WHERE orden_id=".$orden->id."";
        $rayones = DB::select($query);
        $query2 = "SELECT * FROM golpes WHERE orden_id=".$orden->id."";
        $golpes = DB::select($query2);
        if(empty($rayones) && empty($golpes) ){
            return redirect('/ordenes_de_trabajo/create3/'.$orden->id);
        }
        else{
            return view('ordenes_de_trabajo.editcreate3', compact('orden', 'rayones','golpes' ));
        }
    }
    public function update3(OrdenDetrabajo $orden, Request $request)
    {
        $query2 = "SELECT id FROM golpes WHERE orden_id=".$orden->id."";
        $golpes = DB::select($query2);
        $id=$golpes[0]->id;
        
        Golpe::find($id)->update($request->all());
    }

    public function update4(OrdenDetrabajo $orden, Request $request)
    {
        $query2 = "SELECT id FROM rayones WHERE orden_id=".$orden->id."";
        $golpes = DB::select($query2);
        $id=$golpes[0]->id;
        Rayon::find($id)->update($request->all());
        return Response::json($golpes);
        
    
    }
    public function updateestado(OrdenDeTrabajo $orden, Request $request)
    {
        $id=$request->id;
            
        OrdenDeTrabajo::find($id)->update($request->all());
        return Response::json($id);
        
    
    }


    //edit pagina 4
    public function edit4(OrdenDetrabajo $orden)
    {
        $query = "SELECT * FROM orden_trabajo_servicio WHERE id=".$orden->id."";
        $query2 = "SELECT * FROM ordenes_de_trabajo WHERE id=".$orden->id."";
        $servicios = Servicio::all();
        
        $ordenes = DB::select($query2);
        $services = DB::select($query);
        if(empty($services)){
            return redirect('/ordenes_de_trabajo/createServicios/'.$orden->id);
        }
        else{
        return view('ordenes_de_trabajo.editcreateServicios', compact('orden', 'services','servicios','ordenes'));
        }
    }
    public function getDatos($orden)
    {
        $query="SELECT O.id as detalle_id,O.mano_obra, S.id as servicio_id, S.nombre, S.precio,O.orden_de_trabajo_id
        from orden_trabajo_servicio O
        inner join servicios S on S.id = O.servicio_id
        where O.orden_de_trabajo_id =".$orden."";
        
        $service= DB::select($query);

        return Response::json($service);

    }
    // crear pagina 2
    public function save2(Request $request)
	{
        $data = $request->all();
        $componentes=ComponentesAccesorios::create($data);

        $orden_de_trabajo = $request['orden_id'];
               

		return Response::json($componentes);
    }
    public function golpes(Request $request)
	{
        $data = $request->all();  
        $golpes=Golpe::create($data);
        $orden_de_trabajo = $request['orden_id'];
              

		return Response::json($golpes);
    }
    public function rayones(Request $request)
	{
        $data = $request->all();  
        $rayones=Rayon::create($data);
        $orden_de_trabajo = $request['orden_id'];
              

		return Response::json($rayones);
    }



    public function saveServicios(OrdenDeTrabajo $orden_de_trabajo, Request $request)
	{
        $statsArray = $request->all();
		foreach($statsArray as $stat) {
            $ordentrabajo = OrdenDeTrabajo::where('id', $orden_de_trabajo->id)->get()->first();
		    $total = $ordentrabajo->total;
            $newtotal=$total+$stat['subtotal_venta'];
            $updateTotal = OrdenDeTrabajo::where('id', $orden_de_trabajo->id)->update(['total' => $newtotal]);
            $stat['servicio_id'] = $stat['servicio_id'];
            $stat['mano_obra'] = $stat['mano_obra'];
            //$stat["subtotal"] = $stat["subtotal_venta"];
        
            $orden_de_trabajo->orden_trabajo_servicio()->create($stat);
            
		}
		return Response::json(['result' => 'ok']);

    }

    public function save(Request $request)
	{
        $data = $request->all();
        $data['fecha_hora'] = Carbon::createFromFormat('d-m-y h:i:s A', $request['fecha_hora']);
        $orden_de_trabajo = OrdenDeTrabajo::create($data);

        //return Response::json($orden_de_trabajo);
        return redirect()->route('ordenes_de_trabajo.create2', $orden_de_trabajo);
    }
    public function destroy(OrdenDeTrabajo $orden_de_trabajo, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $orden_de_trabajo->id;
            $orden_de_trabajo->delete();
            
            $response["response"] = "La orden de trabajo ha sido eliminada";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }

    public function destroyDetalle3(OrdenTrabajoServicio $orden_trabajo_servicio, Request $request)
	{
		$ordentrabajo = OrdenDeTrabajo::where('id', $orden_trabajo_servicio->orden_de_trabajo_id)->get()->first();
		$total = $ordentrabajo->total;
		$totalresta = $orden_trabajo_servicio->subtotal;
		$newTotal = $total - $totalresta;
		$updateTotal = OrdenDeTrabajo::where('id', $orden_trabajo_servicio->orden_de_trabajo_id)->update(['total' => $newTotal]);
		$orden_trabajo_servicio->delete();
		$response["response"] = "El registro ha sido borrado";
		return Response::json($response);
	}


    
    public function getJson(Request $params)
    {
        
        $query = "SELECT O.total, O.fecha_hora,O.id, concat(C.nombres,' ',C.apellidos) as cliente, V.placa, E.estado as estado,O.estado_id
        FROM ordenes_de_trabajo O
        inner join clientes C on C.id = O.cliente_id
        inner join vehiculos V on V.id=O.vehiculo_id
        inner join estados_serie E on E.id = O.estado_id";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
