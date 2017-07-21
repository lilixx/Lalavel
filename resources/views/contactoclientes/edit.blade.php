@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('contactoclientes.update', $contactocliente->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

  <h1 class="titulo cliente"> Editar Contacto </h1>

 <div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-10">
        <input  type="text" class="form-control" name="nombres" value="{{ $contactocliente->nombres }}">
    </div>
  </div>
</div>

<div class="col-lg-6">
 <div class="form-group">
   <label for="titulo" class="col-sm-2 control-label">Email</label>
   <div class="col-sm-10">
       <input  type="text" class="form-control" name="email" value="{{ $contactocliente->email }}">
   </div>
 </div>
</div>

<div class="col-lg-6">
 <div class="form-group">
   <label for="titulo" class="col-sm-2 control-label">Teléfono</label>
   <div class="col-sm-10">
       <input  type="text" class="form-control" name="telefono" value="{{ $contactocliente->telefono }}">
   </div>
 </div>
</div>

<div class="col-lg-6">
 <div class="form-group">
   <label for="titulo" class="col-sm-2 control-label">Cargo</label>
   <div class="col-sm-10">
       <input  type="text" class="form-control" name="cargo" value="{{ $contactocliente->cargo }}">
   </div>
 </div>
</div>

<div class="col-sm-4" style="float:right;">
  <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
</div>

</form>

@endsection
