@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
			<div class="user-created-message alert alert-dismissible fade in hidden" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<p></p>
            </div>
            
			@if ( isset( $user_created ) )
			<div class="alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				{{ $user_created  }}
			</div>
            @endif
            
			<div class="panel panel-default">
				<div class="panel panel-heading">
					<div class="row">
						<div class="col-sm-3 title-line-height"></div>
						<div class="col-sm-6 text-center">
							<h4 class="inline-title">Kardex de producto</h4>
						</div>
						<div class="col-sm-3 title-line-height text-right">
							<div class="btn-group">
								{{--<a class='delete-records-btn btn btn-danger btn-title m-r-15 border-radius' href="#" style="display: none;">Borrar</a>
                                <a class='btn-add-new-record btn btn-success btn-title border-radius' href="{{ url('productos/new') }}">Nuevo Producto</a> --}}
							</div>
						</div>
					</div>
                </div>
                
				<div class="panel panel-body">
					<table id="kardex-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Codigo de Barra</th>
                                <th>Nombre producto</th>
                                <th>Transaccion</th>
                                <th>Cantidad Entrada</th>
                                <th>Cantidad Salida</th>
                                <th>Existencia Anterior</th>
                                <th>Saldo</th>
                                <th>Ubicación</th>
                                <th>Costo</th>
                            </tr>
                        </thead>
                        

                        @foreach ($kardex as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->fecha}}</td>
                                <td>{{$item->codigo_barra}}</td>
                                <td>{{$item->nombre}}</td>
                                <td>{{$item->transaccion}}</td>
                                <td>{{$item->cantidad_ingreso}}</td>
                                <td>{{$item->cantidad_salida}}</td>
                                <td>{{$item->existencia_anterior}}</td>
                                <td>{{$item->saldo}}</td>
                                <td>{{$item->ubicacion}}</td>
                                <td>{{$item->costo}}</td>
                            </tr>
                            

                        @endforeach
                        
					</table>
                </div>
                
			</div>
		</div>
	</div>
</div>


@endsection
@section('scripts')
{!! HTML::script('/js/productos/kardex2.js') !!}
@endsection