@extends('layouts.app')
@section('content')
@include('localidades.createModal')
@include('localidades.editModal')
@include('users.confirmarAccionModal')
<div id="content">
	<div class="container-custom">
    <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

          <h3 class="box-title">Listado De Localidades</h3>

          <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalLocalidad">
            <i class="fa fa-plus"></i>Agregar Localidad
          </button>

            <table id="Localidad-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
            </table>
            <input type="hidden" name="urlActual" value="{{url()->current()}}">
  </div>
</div>
@endsection


@section('scripts')
  <script src="{{asset('js/localidades/index.js')}}"></script>
  <script src="{{asset('js/localidades/create.js')}}"></script>
  <script src="{{asset('js/localidades/edit.js')}}"></script>
@endsection