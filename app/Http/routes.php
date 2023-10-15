<?php

Route::get('/', function () 
{

	if (Auth::check())
	{
		return view('home');
	}
	else 
	{
		return view('welcome');
	}
});


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => ['web']], function () 
{

	Route::auth();

	Route::group(array('middleware' => 'auth'), function()
	{
		/* ========== RUTAS PARA LA GESTIÓN DE VENTAS =========== */
		Route::get( '/ventas' , 'VentasController@index');
		Route::get( '/venta/getJson' , 'VentasController@getJson');
		Route::get( '/venta/new' , 'VentasController@create');	
		Route::get('/venta/get/', 'ProductosController@getInfo');
		Route::get( '/servicio/precio/{servicio}' , 'ServiciosController@getPrecio');
		Route::get( '/cliente/datos/{cliente}' , 'ClientesController@getDatos');
		Route::get('/venta/getpartida/', 'ProductosController@getInfoPartida');
		Route::get( '/venta/save/' , 'VentasController@save');
		Route::get( '/venta/savecpc/' , 'VentasController@ccobrar');
		Route::post( '/venta-detalle/{venta_maestro}' , 'VentasController@saveDetalle');
		Route::delete( '/venta/destroy/{venta_maestro}' , 'VentasController@destroy');
		Route::get('/existencia/getJson', 'ProductosController@getJsonExistencia');
		Route::post('/cortecaja', 'VentasController@makeCorte');
		Route::get('/tipoventa/{venta_maestro}', 'VentasController@getTipoPago');
		Route::get('/ventadetalle/{venta_maestro}', 'VentasController@show');
		Route::patch('/venta/{venta_maestro}/update' , 'VentasController@update');
		Route::patch('/venta/update-total/{venta_maestro}/' , 'VentasController@updateTotal');
		Route::get('/ventadetalle/{venta_maestro}/getJson' , 'VentasController@getJsonDetalle');
		Route::delete('/ventadetalle/destroy/{venta_detalle}', 'VentasController@destroyDetalle');
		Route::delete('/ventadetalle2/destroy/{venta_detalle}/{movimiento_producto}', 'VentasController@destroyDetalle2');
		Route::delete('/ventadetalle3/destroy/{venta_detalle}', 'VentasController@destroyDetalle3');
		Route::get('/ventas/edit/{venta}', 'VentasController@edit');
		//rutas para edicion de detalle de ventas

		Route::get('/venta/get2/', 'VentasController@getInfo');
		Route::patch('/ventadetalle2/update/{venta_detalle}/{movimiento_producto}', 'VentasController@UpdateDetalle2');
		Route::patch('/ventadetalle3/update/{venta_detalle}', 'VentasController@UpdateDetalle3');
		
		Route::get('/detallesventas/edit/{venta_detalle}' , 'VentasController@editDetalle');
		Route::patch( '/detallesventas/{venta_detalle}' , 'VentasController@updateDetalle' );

		Route::get('/tipos_cliente', 'TiposClienteController@index');
		Route::get('/tipos_cliente/getJson/' , 'TiposClienteController@getJson');
		Route::get('/tipos_cliente/new' , 'TiposClienteController@create');
		Route::post('/tipos_cliente/save/' , 'TiposClienteController@store');
		Route::get('/tipos_cliente/edit/{tipo_cliente}' , 'TiposClienteController@edit');
		Route::patch('/tipos_cliente/{tipo_cliente}/update' , 'TiposClienteController@update');
		Route::delete('/tipos_cliente/remove/{tipo_cliente}' , 'TiposClienteController@destroy');

		Route::get('/clientes', 'ClientesController@index');
		Route::get('/clientes/getJson/' , 'ClientesController@getJson');
		Route::get('/clientes/new' , 'ClientesController@create');
		Route::post('/clientes/save/' , 'ClientesController@store');
		Route::get('/clientes/edit/{cliente}' , 'ClientesController@edit');
		Route::patch('/clientes/{cliente}/update' , 'ClientesController@update');
		Route::delete('/clientes/remove/{cliente}' , 'ClientesController@destroy');
		Route::get('/clientes/nitDisponible/', 'ClientesController@nitDisponible');
		Route::get( '/clientes/dpiDisponible/', 'ClientesController@dpiDisponible');

		Route::get('/tipos_vehiculo', 'TiposVehiculoController@index');
		Route::get('/tipos_vehiculo/getJson/' , 'TiposVehiculoController@getJson');
		Route::get('/tipos_vehiculo/new' , 'TiposVehiculoController@create');
		Route::post('/tipos_vehiculo/save/' , 'TiposVehiculoController@store');
		Route::get('/tipos_vehiculo/edit/{tipo_vehiculo}' , 'TiposVehiculoController@edit');
		Route::patch('/tipos_vehiculo/{tipo_vehiculo}/update' , 'TiposVehiculoController@update');
		Route::delete('/tipos_vehiculo/remove/{tipo_vehiculo}' , 'TiposVehiculoController@destroy');

		//rutas puestos
		Route::get('/puestos', 'PuestosController@index');
		Route::get('/puestos/getJson/' , 'PuestosController@getJson');
		Route::get('/puestos/new' , 'PuestosController@create');
		Route::post('/puestos/save/' , 'PuestosController@store');
		Route::get('/puestos/edit/{puesto}' , 'PuestosController@edit');
		Route::patch('/puestos/{puesto}/update' , 'PuestosController@update');
		Route::delete('/puestos/remove/{puesto}' , 'PuestosController@destroy');
		
		// rutas empleados
		Route::get( '/empleados' , 'EmpleadosController@index');
		Route::get( '/empleados/getJson/' , 'EmpleadosController@getJson');
		Route::get( '/empleados/new/' , 'EmpleadosController@create');
		Route::get( '/empleados/edit/{empleado}' , 'EmpleadosController@edit');
		Route::patch( '/empleados/{empleado}/update' , 'EmpleadosController@update');
		Route::post( '/empleados/save/' , 'EmpleadosController@store');
		Route::delete( '/empleados/remove/{empleado}' , 'EmpleadosController@destroy');
		Route::get('/empleados/nitDisponible/', 'EmpleadosController@nitDisponible');
		Route::get( 'cui-disponible/', 'EmpleadosController@dpiDisponible');
		
		//Rutas Maquinarias y equipo
		Route::get('/maquinarias_equipo', 'MaquinariasEquipoController@index');
		Route::get('/maquinarias_equipo/getJson/' , 'MaquinariasEquipoController@getJson');
		Route::get('/maquinarias_equipo/new' , 'MaquinariasEquipoController@create');
		Route::post('/maquinarias_equipo/save/' , 'MaquinariasEquipoController@store');
		Route::get('/maquinarias_equipo/edit/{maquinariaequipo}' , 'MaquinariasEquipoController@edit');
		Route::patch('/maquinarias_equipo/{maquinariaequipo}/update' , 'MaquinariasEquipoController@update');
		Route::delete('/maquinarias_equipo/remove/{maquinariaequipo}' , 'MaquinariasEquipoController@destroy');
		Route::get('/maquinarias_equipo/get/', 'MaquinariasEquipoController@getInfo');
		Route::get( 'codigo-disponible-maquina/', 'MaquinariasEquipoController@codigoDisponible');
		Route::get('/existencias/maquinaria', 'MaquinariasEquipoController@existenciasIndex');
		Route::get('/existencias/maquinaria/getJson/', 'MaquinariasEquipoController@existencias');
		
		//rutas mantenimienotos de maquinarias y equipos
		Route::get('/mantto_equipo', 'MantenimientoEquiposController@index');
		Route::get('/mantto_equipo/getJson/' , 'MantenimientoEquiposController@getJson');
		Route::get('/mantto_equipo/new' , 'MantenimientoEquiposController@create');
		Route::post('/mantto_equipo/save/' , 'MantenimientoEquiposController@store');
		Route::get('/mantto_equipo/edit/{manttoequipo}' , 'MantenimientoEquiposController@edit');
		Route::patch('/mantto_equipo/{manttoequipo}/update' , 'MantenimientoEquiposController@update');
		Route::delete('/mantto_equipo/remove/{manttoequipo}' , 'MantenimientoEquiposController@destroy');
			

		//rutas Proveedores
		Route::get( '/proveedores' , 'ProveedoresController@index');
		Route::get( '/proveedores/getJson/' , 'ProveedoresController@getJson');
		Route::get( '/proveedores/new' , 'ProveedoresController@create');
		Route::get( '/proveedores/edit/{proveedor}' , 'ProveedoresController@edit');
		Route::patch( '/proveedores/{proveedor}/update' , 'ProveedoresController@update');
		Route::post( '/proveedores/save/' , 'ProveedoresController@store');
		Route::delete( '/proveedores/remove/{proveedor}' , 'ProveedoresController@destroy');
		Route::get('/proveedores/nitDisponible/', 'ProveedoresController@nitDisponible');
		Route::get( '/proveedores/cargar' , 'ProveedoresController@cargarSelect');

		Route::get('/vehiculos', 'VehiculosController@index');
		Route::get('/vehiculos/getJson/' , 'VehiculosController@getJson');
		Route::get('/vehiculos/new' , 'VehiculosController@create');
		Route::post('/vehiculos/save/' , 'VehiculosController@store');
		Route::post( '/vehiculos/save/modal' , 'VehiculosController@store2')->name('vehiculos.store2');
		Route::get('/vehiculos/edit/{vehiculo}' , 'VehiculosController@edit');
		Route::patch('/vehiculos/{vehiculo}/update' , 'VehiculosController@update');
		Route::delete('/vehiculos/remove/{vehiculo}' , 'VehiculosController@destroy');
		Route::get( 'placa-disponible/', 'VehiculosController@placaDisponible');
		Route::get( 'vin-disponible/', 'VehiculosController@vinDisponible');
		Route::get( '/linea/obtener/{marca}' , 'LineasController@getDatos');
		Route::get( '/vehiculos/cargar' , 'VehiculosController@cargarSelect');
		Route::get( '/vehiculo/obtener/{cliente}' , 'VehiculosController@getDatos');

		Route::get('/unidades_de_medida', 'UnidadesDeMedidaController@index');
		Route::get('/unidades_de_medida/getJson/' , 'UnidadesDeMedidaController@getJson');
		Route::get('/unidades_de_medida/new' , 'UnidadesDeMedidaController@create');
		Route::post('/unidades_de_medida/save/' , 'UnidadesDeMedidaController@store');
		Route::get('/unidades_de_medida/edit/{unidad_de_medida}' , 'UnidadesDeMedidaController@edit');
		Route::patch('/unidades_de_medida/{unidad_de_medida}/update' , 'UnidadesDeMedidaController@update');
		Route::delete('/unidades_de_medida/remove/{unidad_de_medida}' , 'UnidadesDeMedidaController@destroy');
		Route::get( '/unidad_de_medida/cantidad/{unidad_de_medida}' , 'UnidadesDeMedidaController@getCantidad');

		Route::get('/tipos_proveedor', 'TiposProveedorController@index');
		Route::get('/tipos_proveedor/getJson/' , 'TiposProveedorController@getJson');
		Route::get('/tipos_proveedor/new' , 'TiposProveedorController@create');
		Route::post('/tipos_proveedor/save/' , 'TiposProveedorController@store');
		Route::get('/tipos_proveedor/edit/{tipo_proveedor}' , 'TiposProveedorController@edit');
		Route::patch('/tipos_proveedor/{tipo_proveedor}/update' , 'TiposProveedorController@update');
		Route::delete('/tipos_proveedor/remove/{tipo_proveedor}' , 'TiposProveedorController@destroy');

		Route::get('/marcas', 'MarcasController@index');
		Route::get('/marcas/getJson/' , 'MarcasController@getJson');
		Route::get('/marcas/new' , 'MarcasController@create');
		Route::post('/marcas/save/' , 'MarcasController@store');
		Route::get('/marcas/edit/{marca}' , 'MarcasController@edit');
		Route::patch('/marcas/{marca}/update' , 'MarcasController@update');
		Route::delete('/marcas/remove/{marca}' , 'MarcasController@destroy');
		Route::get( '/marcas/marcaDisponible/', 'MarcasController@marcaDisponible');
		Route::get( '/marcas/cargar' , 'MarcasController@cargarSelect');


		// Rutas de lineas
		Route::get('/lineas', 'LineasController@index');
		Route::get('/lineas/getJson/' , 'LineasController@getJson');
		Route::get('/lineas/new' , 'LineasController@create');
		Route::post('/lineas/save/' , 'LineasController@store');
		Route::get('/lineas/edit/{linea}' , 'LineasController@edit');
		Route::patch('/lineas/{linea}/update' , 'LineasController@update');
		Route::delete('/lineas/remove/{linea}' , 'LineasController@destroy');
		Route::get( '/lineas/lineaDisponible/', 'LineasController@lineaDisponible');
		Route::get( '/lineas/cargar' , 'LineasController@cargarSelect');
		
		//rutas bodegas
		Route::get('/bodegas', 'BodegaController@index');
		Route::get('/bodegas/getjson/' , 'BodegaController@getjson');
		Route::put( '/bodegas/{bodega}/update' , 'BodegaController@update')->name('bodegas.update');
		Route::post( '/bodegas/save' , 'BodegaController@store')->name('bodegas.save');
		Route::delete('/bodegas/{bodega}/delete' , 'BodegaController@destroy');
		Route::get('/bodegas/nombreDisponible/', 'BodegaController@nombreDisponible');
		Route::get('/bodegas/nombreDisponibleEdit/', 'BodegaController@nombreDisponibleEdit');
		
		//rutas bodegas
		Route::get('/localidades', 'LocalidadController@index');
		Route::get('/localidades/getjson/' , 'LocalidadController@getjson');
		Route::put( '/localidades/{localidad}/update' , 'LocalidadController@update')->name('localidades.update');
		Route::post( '/localidades/save' , 'LocalidadController@store')->name('localidades.save');
		Route::delete('/localidades/{localidad}/delete' , 'LocalidadController@destroy');
		Route::get('/localidades/nombreDisponible/', 'LocalidadController@nombreDisponible');
		Route::get('/localidades/nombreDisponibleEdit/', 'LocalidadController@nombreDisponibleEdit');
		Route::get( '/bodegas/cargar' , 'BodegaController@cargarSelect')->name('bodegas.cargar');


		//rutas productos
		Route::get('/productos', 'ProductosController@index');
		Route::get('/productos/getJson/' , 'ProductosController@getJson');
		Route::get('/productos/new' , 'ProductosController@create');
		Route::post('/productos/save/' , 'ProductosController@store');
		Route::get('/productos/edit/{producto}' , 'ProductosController@edit');
		Route::patch('/productos/{producto}/update' , 'ProductosController@update');
		Route::delete('/productos/remove/{producto}' , 'ProductosController@destroy');
		Route::get( '/producto/precio/{producto}' , 'ProductosController@getPrecio');
		Route::get('/existencias/producto', 'ProductosController@existenciasIndex');
		Route::get('/existencias/getJson/', 'ProductosController@existencias');
		Route::get('/kardex/producto', 'ProductosController@kardexIndex');
		Route::get( 'codigo-disponible/', 'ProductosController@codigoDisponible');

		Route::get('/precios_producto', 'PreciosProductoController@index');
		Route::get('/precios_producto/getJson/' , 'PreciosProductoController@getJson');
		Route::get('/precios_producto/new' , 'PreciosProductoController@create');
		Route::post('/precios_producto/save/' , 'PreciosProductoController@store');
		Route::get('/precios_producto/edit/{precio_producto}' , 'PreciosProductoController@edit');
		Route::patch('/precios_producto/{precio_producto}/update' , 'PreciosProductoController@update');
		Route::delete('/precios_producto/remove/{precio_producto}' , 'PreciosProductoController@destroy');

		Route::get('/documentos', 'DocumentosController@index');
		Route::get('/documentos/getJson/' , 'DocumentosController@getJson');
		Route::get('/documentos/new' , 'DocumentosController@create');
		Route::post('/documentos/save/' , 'DocumentosController@store');
		Route::get('/documentos/edit/{documento}' , 'DocumentosController@edit');
		Route::patch('/documentos/{documento}/update' , 'DocumentosController@update');
		Route::delete('/documentos/remove/{documento}' , 'DocumentosController@destroy');

		Route::get('/tipos_servicio', 'TiposServicioController@index');
		Route::get('/tipos_servicio/getJson/' , 'TiposServicioController@getJson');
		Route::get('/tipos_servicio/new' , 'TiposServicioController@create');
		Route::post('/tipos_servicio/save/' , 'TiposServicioController@store');
		Route::get('/tipos_servicio/edit/{tipo_servicio}' , 'TiposServicioController@edit');
		Route::patch('/tipos_servicio/{tipo_servicio}/update' , 'TiposServicioController@update');
		Route::delete('/tipos_servicio/remove/{tipo_servicio}' , 'TiposServicioController@destroy');

		Route::get('/servicios', 'ServiciosController@index');
		Route::get('/servicios/getJson/' , 'ServiciosController@getJson');
		Route::get('/servicios/new' , 'ServiciosController@create');
		Route::post('/servicios/save/' , 'ServiciosController@store');
		Route::get('/servicios/edit/{servicio}' , 'ServiciosController@edit');
		Route::patch('/servicios/{servicio}/update' , 'ServiciosController@update');
		Route::delete('/servicios/remove/{servicio}' , 'ServiciosController@destroy');
		Route::get( '/servicios/save/' , 'ServiciosController@save');
		Route::post( '/servicios-detalle/{servicio}' , 'ServiciosController@saveDetalle');
		Route::get('/servicios/show/{servicio}' , 'ServiciosController@show');
		Route::get( '/servicios/{servicio}/getJson' , 'ServiciosController@getJsonDetalle' );
		Route::get( '/codigo-disponible-servicio/', 'ServiciosController@codigoDisponible');

		Route::get('/detalleservicios/edit/{detalle}' , 'ServiciosController@editDetalle');
		Route::patch('/detalleservicios/{detalle}/update' , 'ServiciosController@updateDetalle');

		Route::get( '/compras' , 'ComprasController@index' );
        Route::get( '/compras/getJson' , 'ComprasController@getJson' );
        Route::get( '/compras/new' , 'ComprasController@create' );
        Route::get( '/compras/save/' , 'ComprasController@save');
        Route::post( '/compras-detalle/{compra}' , 'ComprasController@saveDetalle');
		Route::patch( '/compras/{compra}/update' , 'ComprasController@update' );
        Route::resource("compras", "ComprasController");
        Route::get('/compras/name/{compra}', 'ComprasController@getName' );
		Route::delete('/compras/destroy/{compra}' , 'ComprasController@destroy' );
		Route::get('/productos/get/', 'ProductosController@getInfo');
		
        Route::get('/detallescompras/{compra}', 'ComprasController@show');
        Route::get( '/detallescompras/{compra}/getJson' , 'ComprasController@getJsonDetalle' );
		Route::patch( '/detallescompras/{compra}/update' , 'ComprasController@update' );
		Route::delete( '/detallescompras/destroy/{detallecompra}' , 'ComprasController@destroyDetalle' );
		Route::get('/detallescompras/name/{detallecompra}', 'ComprasController@getDetalle');		
		Route::get('/compras/edit/{compra}', 'ComprasController@edit');

		Route::get('/detallescompras/edit/{detallecompra}' , 'ComprasController@editDetalle');
		Route::patch( '/detallescompras/{detallecompra}' , 'ComprasController@updateDetalle' );

		//Rutas Planillas
		Route::get( '/planillas' , 'PlanillasController@index' );
        Route::get( '/planillas/getJson' , 'PlanillasController@getJson' );
        Route::get( '/planillas/new' , 'PlanillasController@create' );
        Route::get( '/planillas/save/' , 'PlanillasController@save');
        Route::post( '/planillas-detalle/{planilla}' , 'PlanillasController@saveDetalle');
        Route::patch( '/planillas/{planilla}/update' , 'PlanillasController@update' );
        Route::resource("planillas", "PlanillasController");
        Route::get('/planillas/name/{planilla}', 'PlanillasController@getName' );
		Route::delete('/planillas/destroy/{planilla}' , 'PlanillasController@destroy' );
		Route::get('/empleados/get/', 'EmpleadosController@getInfo');
		
        Route::get('/detallesplanillas/{planilla}', 'PlanillasController@show');
        Route::get( '/detallesplanillas/{planilla}/getJson' , 'PlanillasController@getJsonDetalle' );
		Route::patch( '/detallesplanillas/{planilla}/update' , 'PlanillasController@update' );
		Route::delete( '/detallesplanillas/destroy/{detalleplanilla}' , 'PlanillasController@destroyDetalle' );
		Route::get('/planillas/edit/{planilla}', 'PlanillasController@edit');

		Route::get('/cuentas_por_pagar', 'CuentasPorPagarController@index');
		Route::get('/cuentas_por_pagar/getJson/' , 'CuentasPorPagarController@getJson');
		Route::get('/cuentas_por_pagar/show/{cuenta_por_pagar}' , 'CuentasPorPagarController@show');
		Route::get( '/cuentas_por_pagar/{cuenta_por_pagar}/getJson' , 'CuentasPorPagarController@getJsonDetalle' );
		Route::get('/cuentas_por_pagar/new/notacredito' , 'CuentasPorPagarController@notacredito');
		Route::get('/cuentas_por_pagar/new/notadebito' , 'CuentasPorPagarController@notadebito');
		Route::post('/cuentas_por_pagar/save/notacredito' , 'CuentasPorPagarController@savenotacredito');
		Route::post('/cuentas_por_pagar/save/notadebito' , 'CuentasPorPagarController@savenotadebito');
		
		Route::get('/cuentas_por_cobrar', 'CuentasPorCobrarController@index');
		Route::get('/cuentas_por_cobrar/getJson/' , 'CuentasPorCobrarController@getJson');
		Route::get('/cuentas_por_cobrar/show/{cuenta_por_cobrar}' , 'CuentasPorCobrarController@show');
		Route::get( '/cuentas_por_cobrar/{cuenta_por_cobrar}/getJson' , 'CuentasPorCobrarController@getJsonDetalle' );
		Route::get('/cuentas_por_cobrar/new/notacredito' , 'CuentasPorCobrarController@notacredito');
		Route::get('/cuentas_por_cobrar/new/notadebito' , 'CuentasPorCobrarController@notadebito');
		Route::post('/cuentas_por_cobrar/save/notacredito' , 'CuentasPorCobrarController@savenotacredito');
		Route::post('/cuentas_por_cobrar/save/notadebito' , 'CuentasPorCobrarController@savenotadebito');

		Route::get('/ordenes_de_trabajo' , 'OrdenesDeTrabajoController@index');
		Route::get('/ordenes_de_trabajo/getJson/' , 'OrdenesDeTrabajoController@getJson');
		Route::get('/ordenes_de_trabajo/new' , 'OrdenesDeTrabajoController@new');
		Route::get('/ordenes_de_trabajo/create2/{orden_de_trabajo}' , 'OrdenesDeTrabajoController@create2')->name('ordenes_de_trabajo.create2');
		Route::post('/ordenes_de_trabajo/save' , 'OrdenesDeTrabajoController@save')->name('ordenes_de_trabajo.save');
		Route::get('/ordenes_de_trabajo/createServicios/{orden_de_trabajo}' , 'OrdenesDeTrabajoController@createServicios')->name('ordenes_de_trabajo.create3');
		Route::post('/ordenes_de_trabajo/saveServicios/{orden_de_trabajo}' , 'OrdenesDeTrabajoController@saveServicios')->name('ordenes_de_trabajo.save3');
		Route::patch('/ordenes_de_trabajo/estado/{orden_de_trabajo}' , 'OrdenesDeTrabajoController@updateestado');
		Route::delete( '/ordenes_de_trabajo/remove/{orden_de_trabajo}' , 'OrdenesDeTrabajoController@destroy');
		
		//edicion pagina 1
		Route::patch('/ordenes_de_trabajo/total/{orden_de_trabajo}/' , 'OrdenesDeTrabajoController@updateTotal');
		Route::get('/ordenes_de_trabajo/edit/{orden}' , 'OrdenesDeTrabajoController@edit');
		Route::patch('/ordenes_de_trabajo/{orden}/update' , 'OrdenesDeTrabajoController@update');
		// edicion pagina 2
		Route::get('/ordenes_de_trabajo/editcreate2/{orden}' , 'OrdenesDeTrabajoController@edit2');
		Route::patch('/ordenes_de_trabajo/{orden}/update2' , 'OrdenesDeTrabajoController@update2');
		// edicion pagina 3
		Route::get('/ordenes_de_trabajo/editcreate3/{orden}' , 'OrdenesDeTrabajoController@edit3');
		Route::patch('/ordenes_de_trabajo/{orden}/update3' , 'OrdenesDeTrabajoController@update3');
		Route::patch('/ordenes_de_trabajo/{orden}/update4' , 'OrdenesDeTrabajoController@update4');
		Route::get('/ordenes_de_trabajo/editcreate4/{orden}' , 'OrdenesDeTrabajoController@edit4');
		
		// edicion pagina 4
		Route::get('/ordenes_de_trabajo/create3/{orden_de_trabajo}' , 'OrdenesDeTrabajoController@create3')->name('ordenes_de_trabajo.create3');
		Route::get('/ordenes_de_trabajo/getDatos/{orden}' , 'OrdenesDeTrabajoController@getDatos');
		Route::post('/ordenes_de_trabajo/save2' , 'OrdenesDeTrabajoController@save2');
		Route::delete('/ordendetalle3/destroy/{orden_trabajo_servicio}', 'OrdenesDeTrabajoController@destroyDetalle3');
		Route::post('/ordenes_de_trabajo/{orden}/golpes/' , 'OrdenesDeTrabajoController@golpes')->name('ordenes_de_trabajo.golpe');
		Route::post('/ordenes_de_trabajo/{orden}/rayones/' , 'OrdenesDeTrabajoController@rayones')->name('ordenes_de_trabajo.rayon');

		//Reporte Ordenes
		Route::get( '/rpt_orden_trabajo/{orden_de_trabajo}' , 'PdfController@rpt_orden_trabajo');
		
		Route::get( '/rpt_estado_cuenta_por_pagar/generar' , 'CuentasPorPagarController@rpt_generar');	
		Route::post( '/rpt_estado_cuenta_por_pagar/' , 'CuentasPorPagarController@rpt_estado_cuenta_por_pagar');
		Route::get( '/rpt_estado_cuenta_por_pagar/total' , 'CuentasPorPagarController@rpt_estado_cuenta_por_pagarTotal');

		Route::get( '/rpt_estado_cuenta_por_cobrar/generar' , 'CuentasPorCobrarController@rpt_generar');
		Route::post( '/rpt_estado_cuenta_por_cobrar/' , 'CuentasPorCobrarController@rpt_estado_cuenta_por_cobrar');
		Route::get( '/rpt_estado_cuenta_por_cobrar/total' , 'CuentasPorCobrarController@rpt_estado_cuenta_por_cobrarTotal');

		Route::get( '/rpt_servicios/generar' , 'ServiciosController@rpt_generar');
		Route::post( '/rpt_servicios/' , 'ServiciosController@rpt_ventas');

		Route::get( '/rpt_ventas/generar' , 'VentasController@rpt_generar');
		Route::post( '/rpt_ventas/' , 'VentasController@rpt_ventas');
		Route::post( '/rpt_ventas_dia/' , 'VentasController@rpt_ventas_dia');

		Route::get( '/rpt_ventas_cliente/generar' , 'VentasController@rpt_ventas_cliente_generar');
		Route::post( '/rpt_ventas_cliente/' , 'VentasController@rpt_ventas_cliente');

		
		Route::get('/rpt_factura/{venta}' , 'PdfController@rpt_factura');
		//reporte de salida de inventario
		Route::get('/rpt_salida/{venta}' , 'PdfController@rpt_salida');

		Route::get('/rpt_compras/generar' , 'ComprasController@rpt_compras_generar');
		Route::post( '/rpt_compras/' , 'ComprasController@rpt_compras');

		

		//Reportes kardex

		Route::get( '/rpt_kardex/generar' , 'ProductosController@rpt_generar_kardex');
		Route::post( '/rpt_kardex/' , 'ProductosController@rpt_kardex');

		Route::get( '/rpt_kardex/producto/generar' , 'ProductosController@rpt_generar_kardex_producto');
		Route::post( '/rpt_kardex/producto' , 'ProductosController@rpt_kardex_producto');

		Route::get('/cajas_chicas', 'CajasChicasController@index');
		Route::get('/cajas_chicas/getJson/' , 'CajasChicasController@getJson');
		Route::get('/cajas_chicas/new/egreso' , 'CajasChicasController@newegreso');
		Route::get('/cajas_chicas/new/ingreso' , 'CajasChicasController@newingreso');
		Route::post('/cajas_chicas/save/egreso' , 'CajasChicasController@saveegreso');
		Route::post('/cajas_chicas/save/ingreso' , 'CajasChicasController@saveingreso');
		Route::get( '/caja_chica/saldo' , 'CajasChicasController@getSaldo');

		Route::get( '/ingresos_productos' , 'IngresosProductoController@index' );
        Route::get( '/ingresos_productos/getJson' , 'IngresosProductoController@getJson' );
        Route::get( '/ingresos_productos/new' , 'IngresosProductoController@create' );
        Route::post( '/ingresos_productos/save/' , 'IngresosProductoController@save');
		Route::patch( '/ingresos_productos/{ingreso_producto}/update' , 'IngresosProductoController@update' );
		Route::get('/ingresos_productos/edit/{ingreso_producto}', 'IngresosProductoController@edit');
		Route::delete('/ingresos_productos/destroy/{ingreso_producto}' , 'IngresosProductoController@destroy' );

		Route::get( '/salidas_productos' , 'SalidaProductoController@index' );
        Route::get( '/salidas_productos/getJson' , 'SalidaProductoController@getJson' );
        Route::get( '/salidas_productos/new' , 'SalidaProductoController@create' );
        Route::post( '/salidas_productos/save/' , 'SalidaProductoController@save');
		Route::patch( '/salidas_productos/{salida_producto}/update' , 'SalidaProductoController@update' );
		Route::get('/salidas_productos/edit/{salida_producto}', 'SalidaProductoController@edit');
		Route::delete('/salidas_productos/destroy/{salida_producto}' , 'SalidaProductoController@destroy' );

		Route::get( '/conversiones_productos' , 'ConversionesProductoController@index' );
        Route::get( '/conversiones_productos/getJson' , 'ConversionesProductoController@getJson' );
        Route::get( '/conversiones_productos/new' , 'ConversionesProductoController@create' );
		Route::post( '/conversiones_productos/save/' , 'ConversionesProductoController@save');
		Route::get('/conversiones_productos/show/{conversion_producto}' , 'ConversionesProductoController@show');
		Route::get( '/conversiones_productos/{conversion_producto}/getJson' , 'ConversionesProductoController@getJsonDetalle');
		
		//rutas Cortes de caja
		Route::get( '/cortes_caja' , 'CortesCajaController@index');
		Route::get( '/cortes_caja/getJson/' , 'CortesCajaController@getJson');
		Route::get( '/cortes_caja/new' , 'CortesCajaController@create');
		Route::get( '/cortes_caja/edit/{corte_caja}' , 'CortesCajaController@edit');
		Route::patch( '/cortes_caja/{corte_caja}/update' , 'CortesCajaController@update');
		Route::post( '/cortes_caja/save/' , 'CortesCajaController@store');
		Route::delete( '/cortes_caja/remove/{corte_caja}' , 'CortesCajaController@destroy');
		Route::get('/cortes_caja/getEfectivo/', 'CortesCajaController@getEfectivo');
		Route::get('/cortes_caja/getCredito/', 'CortesCajaController@getCredito');
		Route::get('/cortes_caja/getTarjeta/', 'CortesCajaController@getTarjeta');
		Route::get('/cortes_caja/getTotal/', 'CortesCajaController@getTotal');
		Route::get('/cortes_caja/getEfectivoSF/', 'CortesCajaController@getEfectivoSF');
		Route::get('/cortes_caja/getCreditoSF/', 'CortesCajaController@getCreditoSF');
		Route::get('/cortes_caja/getTarjetaSF/', 'CortesCajaController@getTarjetaSF');
		Route::get('/cortes_caja/getTotalSF/', 'CortesCajaController@getTotalSF');
		Route::get('/cortes_caja/getTotalVenta/', 'CortesCajaController@getTotalVenta');
		Route::get( '/cortes_caja/corteUnico/', 'CortesCajaController@corteUnico');
		Route::get( '/cortes_caja/getFacturas/', 'CortesCajaController@getFacturas');

		//ruta para reporte de ventas general
		Route::get( '/reporte_ventas' , 'CortesCajaController@index3');
		Route::get( '/cortes_caja/getJson/{inicial}/{final}' , 'CortesCajaController@getJson3');


		// corte de  caja por empleado
		
		Route::get( '/corte_caja_empleado' , 'CortesCajaController@index2');
		Route::get( '/corte_caja_empleado/new' , 'CortesCajaController@rpt_generar_corte');
		Route::get( '/corte_caja_empleado/getJson/' , 'CortesCajaController@getJson2');
		Route::post( '/rpt_corte_empleado/' , 'CortesCajaController@rpt_corte');
		Route::get('/cortes_caja/getEfectivo/{user_id}/{fecha}', 'CortesCajaController@getEfectivo2');
		Route::get('/cortes_caja/getCredito/{user_id}/{fecha}', 'CortesCajaController@getCredito2');
		Route::get('/cortes_caja/getTarjeta/{user_id}/{fecha}', 'CortesCajaController@getTarjeta2');
		Route::get('/cortes_caja/getTotal/{user_id}/{fecha}', 'CortesCajaController@getTotal2');
		Route::get('/cortes_caja/getEfectivoSF/{user_id}/{fecha}', 'CortesCajaController@getEfectivoSF2');
		Route::get('/cortes_caja/getCreditoSF/{user_id}/{fecha}', 'CortesCajaController@getCreditoSF2');
		Route::get('/cortes_caja/getTarjetaSF/{user_id}/{fecha}', 'CortesCajaController@getTarjetaSF2');
		Route::get('/cortes_caja/getTotalSF/{user_id}/{fecha}', 'CortesCajaController@getTotalSF2');
		Route::get('/cortes_caja/getTotalVenta/{user_id}/{fecha}', 'CortesCajaController@getTotalVenta2');
		Route::get( '/cortes_caja/corteUnico/{user_id}/{fecha}', 'CortesCajaController@corteUnico2');
		Route::get( '/cortes_caja/getFacturas/{user_id}/{fecha}', 'CortesCajaController@getFacturas2');






		Route::get('/home', 'HomeController@index');
		Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

		Route::patch( '/user/{user}/change' , 'UserController@changePassword' );
		Route::patch( '/user/{user}/changeInfo' , 'UserController@changeInformation' );

		Route::group(array('middleware' => 'acl' , 'is' => 'superadmin|administrator' ), function()
		{

			Route::get( '/user' , 'UserController@index' );
			Route::get( '/user/getJson' , 'UserController@getJson' );
			Route::post( '/user/names' , 'UserController@getNames' );
			Route::post( '/user/store' , 'UserController@store' );
			Route::delete( '/user/destroy/{user}' , 'UserController@destroy' );
			Route::delete( '/user/multiple/destroy' , 'UserController@multipleDestroy' );
			Route::patch( '/user/{user}/update' , 'UserController@update' );
			Route::get( '/user/show/' , 'UserController@getInformationByUser');
			Route::get('/user/name/{user}', 'UserController@getName' );

			//clientes routes
			Route::get( '/clientes' , 'ClientesController@index');
			Route::get( '/cliente/getJson/' , 'ClientesController@getJson');
			Route::get( '/clientes/new/' , 'ClientesController@create');
			Route::get( '/clientes/edit/{cliente}' , 'ClientesController@edit');
			Route::patch( '/clientes/{cliente}/update' , 'ClientesController@update');
			Route::post( '/clientes/save/' , 'ClientesController@store')->name('clientes.store');
			Route::post( '/clientes/save/modal' , 'ClientesController@store2')->name('clientes.store2');
			Route::delete( '/clientes/active/{cliente}' , 'ClientesController@active');
			Route::delete( '/clientes/remove/{cliente}' , 'ClientesController@destroy');
			Route::delete( '/clientes/bloquear/{cliente}' , 'ClientesController@bloquear');
			Route::get( '/clientes/cargar' , 'ClientesController@cargarSelect');

			Route::get( '/empleados' , 'EmpleadosController@index');
			Route::get( '/empleado/getJson/' , 'EmpleadosController@getJson');
			Route::get( '/empleados/new' , 'EmpleadosController@create');
			Route::get( '/empleados/edit/{empleado}' , 'EmpleadosController@edit');
			Route::patch( '/empleados/{empleado}/update' , 'EmpleadosController@update');
			Route::post( '/empleados/save/' , 'EmpleadosController@store');
			Route::delete( '/empleado/remove/{empleado}' , 'EmpleadosController@destroy');
			Route::post( '/empleado/active/{empleado}' , 'EmpleadosController@active');
			Route::get('cui-disponible/', 'EmpleadosController@dpiDisponible');
			Route::get('cui-disponible-edit/', 'EmpleadosController@dpiDisponibleEdit');


			Route::get( '/productos' , 'ProductosController@index');
			Route::get( '/producto/getJson/' , 'ProductosController@getJson');
			Route::get( '/productos/new' , 'ProductosController@create');
			Route::get( '/productos/edit/{producto}' , 'ProductosController@edit');
			Route::patch( '/productos/{producto}/update' , 'ProductosController@update');
			Route::post( '/productos/save/' , 'ProductosController@store');
			Route::post( '/productos/save_precios/{producto}' , 'ProductosController@store_precios');
			Route::delete( '/productos/remove/{producto}' , 'ProductosController@destroy');
			Route::get('producto-disponible/', 'ProductosController@Producto_Disponible');
			Route::get('producto-disponible-edit/', 'ProductosController@Producto_Disponible_Edit');
			Route::get('/detalleproductos/{detalle}/GetJson' , 'ProductosController@getJsonDetalle');
			Route::get( '/productos/detalle/{producto}' , 'ProductosController@getDetalle');
		});

		Route::group(array('middleware' => 'acl' , 'is' => 'superadmin|administrator|finanzas' ), function()
		{

			//Rutas para Series
			Route::get( '/series' , 'SeriesController@index');
			Route::get( '/series/getJson/' , 'SeriesController@getJson');
			Route::get( '/series/new' , 'SeriesController@create');
			Route::post( '/series/save/' , 'SeriesController@store');
			Route::get( '/series/edit/{serie}' , 'SeriesController@edit');
			Route::patch( '/series/{serie}/update' , 'SeriesController@update');
			Route::delete( '/series/remove/{serie}' , 'SeriesController@destroy');
			Route::get( '/series/rangoDisponible/', 'SeriesController@rangoDisponible');
			Route::get( '/series/rangoDisponible-edit/', 'SeriesController@rangoDisponible_edit');
			
			//Rutas para Facturas
			Route::get('/factura', 'FacturasController@index');
			Route::get('/factura/getJson/' , 'FacturasController@getJson');
			Route::get('/factura/new' , 'FacturasController@create');
			Route::post('/factura/save/' , 'FacturasController@store');
			Route::post('/factura/save2/' , 'FacturasController@store2');
			Route::get('/factura/edit/{factura}' , 'FacturasController@edit');
			Route::patch('/factura/{factura}/update' , 'FacturasController@update');
			Route::delete('/factura/remove/{factura}' , 'FacturasController@destroy');
			Route::get( '/serie/datos/{serie}' , 'SeriesController@getDatos');
			Route::get( '/facturas/noDisponible/', 'FacturasController@noDisponible');

		});
	});
});