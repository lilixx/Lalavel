@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('habitaciontipos.update', $habtipo->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

 <h1 class="titulo habitacion"> Editar Tipo de Habitaciones </h1>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nombre" value="{{ $habtipo->nombre }}">
    </div>
  </div>

  <div class="form-group">
    <label for="tarifainicial" class="col-sm-2 control-label">Tarifa Inicial</label>
    <div class="col-sm-10">
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">$</span>
        <input type="text" class="form-control" name="tarifainicial" value="{{ $habtipo->tarifainicial }}"/>
      </div>
    </div>
  </div>


  @if (!empty($habtipo->urlimg))
    <label for="urlimg" class="col-sm-2 control-label">Imagen Actual</label>
    <img src="<?php echo  url('/');?>/imgHabitaciones/{{ $habtipo->urlimg }}" class="img-responsive" alt="Responsive image" style="max-width: 260px;">
  @endif

  <div class="form-group">
    <label for="urlimg" class="col-sm-2 control-label">Cambio de Imagen</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" name="urlimg" value="{{ $habtipo->urlimg }}"></textarea>
    </div>
  </div>

  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
  </div>

</form>

@endsection
