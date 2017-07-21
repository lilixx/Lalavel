@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('habtipoadd') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

  <h1 class="titulo habitacion"> Agregar Tipo de Habitaciones </h1>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nombre"  placeholder="nombre">
    </div>
  </div>

  <div class="form-group">
    <label for="tarifainicial" class="col-sm-2 control-label">Tarifa Inicial</label>
    <div class="col-sm-10">
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">$</span>
        <input type="text" class="form-control" name="tarifainicial" placeholder="Precio"/>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label for="urlimg" class="col-sm-2 control-label">Imagen</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" name="urlimg"></textarea>
    </div>
  </div>

  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
  </div>

</form>

@endsection
