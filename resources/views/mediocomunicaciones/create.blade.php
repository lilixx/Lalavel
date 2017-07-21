@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('mediocomunicaciones') }}" enctype="multipart/form-data">
 {{ csrf_field() }}


@if($rol==1)
   <h1 class="titulo huesped"> Agregar Medio de Comunicación al Huésped</h1>
 @else
    <h1 class="titulo cliente"> Agregar Medio de Comunicación al Cliente </h1>
@endif


  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Medio</label>
    <div class="col-sm-10">
      <select class="form-control input-sm" name="mediocomunicacione_id" value="mediocomunicacione_id">
      <option value="0" selected="true" disabled="true">Seleccione un medio</option>
       @foreach ($medio as $tm)
         <option value="{{$tm->id}}">{{ $tm->nombre}}</option>
       @endforeach
     </select>
    </div>
  </div>

<input type="hidden" name="rol" value="{{$rol}}">

<input type="hidden" name="entidade_id" value="{{$huespedid}}">

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Valor</label>
    <div class="col-sm-10">
        <input  type="text" class="form-control" name="valormediocomunicacion"  placeholder="Valor">
    </div>
  </div>

  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
  </div>

</form>

@endsection
