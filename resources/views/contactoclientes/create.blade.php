@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('contactoclientes') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

 <h1 class="titulo cliente"> Agregar Contacto </h1>

  <input type="hidden" name="entidade_id" value="{{$entidadid}}">

 <div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-10">
        <input  type="text" class="form-control" name="nombres"  placeholder="Nombre">
    </div>
  </div>
</div>

 <div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
        <input  type="text" class="form-control" name="email"  placeholder="Email">
    </div>
  </div>
</div>

 <div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Teléfono</label>
    <div class="col-sm-10">
        <input  type="text" class="form-control" name="telefono"  placeholder="Teléfono">
    </div>
  </div>
</div>

 <div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Cargo</label>
    <div class="col-sm-10">
        <input  type="text" class="form-control" name="cargo"  placeholder="Cargo">
    </div>
  </div>
</div>

<div class="col-sm-4" style="float:right;">
  <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
   <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Crear</button>
</div>

</form>

@endsection
