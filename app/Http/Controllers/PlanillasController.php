<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Planilla;
use App\User;
use App\Empleado;
use App\DetallePlanilla;
use View;
Use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kodeine\Acl\Models\Eloquent\Role;
use Kodeine\Acl\Models\Eloquent\Permission;
use Carbon\Carbon;

class PlanillasController extends Controller
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
        $empleados = Empleado::all();
        return view ("planillas.index", compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$empleados = Empleado::all();
		return view("planillas.create" , compact("empleados") );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
	{
		$data = $request->all();
		$data["user_id"] = Auth::user()->id;
		//$data['fecha'] = Carbon::createFromFormat('d-m-Y', $data['fecha']);
		$maestro = Planilla::create($data);
		return $maestro;
	}

	public function saveDetalle(Request $request, Planilla $planilla)
	{
		$statsArray = $request->all();
		foreach($statsArray as $stat) {

			$stat['user_id'] = Auth::user()->id;
			$stat['empleado_id'] = $stat['empleado_id'];
			$stat["igss"] = $stat["igss"];
			$stat["sueldo"] = $stat["sueldo"];
			$stat["subtotal"] = $stat["subtotal_planilla"];
			$stat['isr'] = 0;
			$stat["bono_incentivo"] = $stat["bono_incentivo"];
			$stat["horas_extra"] = $stat["monto_hora_extra"];
		
			$planilla->detalles_planillas()->create($stat);
	
			
		}
		return Response::json(['result' => 'ok']);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function show(Planilla $planilla)
	{
		return view('planillas.show')->with('planilla', $planilla);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Planilla $planilla)
	{
		$query = "SELECT * FROM planillas WHERE id=".$planilla->id."";
		$fieldsArray = DB::select($query);
		
        return view ("planillas.edit", compact('planilla', 'fieldsArray'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function update(Planilla $planilla, Request $request )
	{
		Response::json($this->updateIngresoEmpleado($planilla , $request->all()));
        return redirect('/planillas');

	}

	public function updateIngresoEmpleado(Planilla $planilla, array $data )
	{
		$planilla->fecha = $data["fecha"];
		$planilla->save();
		return $planilla;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Planilla $planilla,  Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$detalles = DetallePlanilla::where('planilla_id', $planilla->id)
			->get();
			$planilla->delete();
			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}

	public function destroyDetalle(DetallePlanilla $detalleplanilla,  Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$planillamaestro = Planilla::where('id', $detalleplanilla->planilla_id)
			->get()->first();
			$total = $planillamaestro->total;
			$totalresta = ($detalleplanilla->sueldo + $detalleplanilla->bono_incentivo + $detalleplanilla->horas_extra -
			$detalleplanilla->igss - $detalleplanilla->isr);
			$newTotal = $total - $totalresta;
			$updateTotal = Planilla::where('id', $detalleplanilla->planilla_id)
			->update(['total' => $newTotal]);


			$detalleplanilla->delete();
			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}

	public function getJson(Request $params)
	{
		$query = 'SELECT planillas.id, DATE_FORMAT(planillas.fecha, "%d-%m-%Y") as fecha, TRUNCATE(planillas.total,2) as total FROM planillas ';
		
		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}

	public function getJsonDetalle(Request $params, $detalle)
	{
		$query = 'SELECT dp.id, dp.planilla_id, dp.empleado_id, CONCAT(e.nombre,'."' '".',e.apellido) as nombre_completo, p.sueldo,
		dp.horas_extra, dp.bono_incentivo, dp.igss, dp.isr
		FROM detalles_planillas dp
		INNER JOIN empleados e on e.id = dp.empleado_id
		INNER JOIN puestos p on p.id = e.puesto_id WHERE dp.planilla_id ='.$detalle.'';

		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}

}
