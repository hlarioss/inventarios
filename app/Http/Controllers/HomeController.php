<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use DB;
use View;
use Illuminate\Http\Request;
use App\Bitacora;
use App\cliente;
use App\vale_maestro;
use App\Bloqueo_Diario;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		$date = Carbon::now();

		return view('home', compact('date'));
	}


	public function bloqueo()
	{
		
	}      




	public static function bitacora($action)
	{
		$datos['user_id'] = Auth::user()->id;
		$datos['accion'] = $action;
		$data = Bitacora::create($datos);
		return $data;
	}


}
