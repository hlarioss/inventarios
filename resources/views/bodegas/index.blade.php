@extends('layouts.app')
@section('content')
@include('bodegas.createModal')
@include('bodegas.editModal')
@include('users.confirmarAccionModal')
<div id="content">
	<div class="container-custom">
    <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

          <h3 class="box-title">Listado De Bodegas</h3>

          <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalBodega">
            <i class="fa fa-plus"></i>Agregar Bodega
          </button>

            <table id="Bodega-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
            </table>
            <input type="hidden" name="urlActual" value="{{url()->current()}}">
  </div>
</div>
@endsection


@section('scripts')
  <script src="{{asset('js/bodegas/index.js')}}"></script>
  <script src="{{asset('js/bodegas/create.js')}}"></script>
  <script src="{{asset('js/bodegas/edit.js')}}"></script>
@endsection