@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('categoriaadd') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

<h1 class="titulo cargo"> Agregar Categoría </h1>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nombre"  placeholder="nombre">
    </div>
  </div>

<div class="form-group">
  <label for="titulo" class="col-sm-2 control-label">Super Categoría</label>
  <div class="col-sm-10">
     <select  class="form-control input-sm" name="supercategoria_id">
     <option value="0" selected="true" disabled="true">Seleccione una Super Categoría</option>
       @foreach ($supercategoria as $sp)
         <option value="{{$sp->id}}">{{$sp->nombre}}</option>
       @endforeach
      </select>
   </div>
  </div>

  <div class="col-sm-12" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Crear</button>
  </div>

</form>

@endsection
