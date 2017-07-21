@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('dochuespedes') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

  <h1 class="titulo huesped"> Agregar Identifición </h1>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Tipo de doc.</label>
    <div class="col-sm-10">
      <select class="form-control input-sm" name="tipodocumento_id" value="tipodocumento_id">
       @foreach ($tipodoc as $doc)
         <option value="{{$doc->id}}">{{ $doc->nombre}}</option>
       @endforeach
     </select>
    </div>
  </div>

  <input type="hidden" name="entidade_id" value="{{$huespedid}}">

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Documento</label>
    <div class="col-sm-10">
        <input  type="text" class="form-control" name="valordocumento"  placeholder="Número de Documento">
    </div>
  </div>

  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
  </div>

</form>

@endsection
