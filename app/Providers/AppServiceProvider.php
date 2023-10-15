<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\MovimientoProducto;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*$this->app->validator->extendImplicit('hayExistencia', function ($attribute, $value, $parameters) {

            $mp = MovimientoProducto::where('producto_id', $parameters)->first();

            if($mp->existencias <= $value){
                return true;
            }

            else{
                return false;
            }
        }, 'No hay existencia suficiente');*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
