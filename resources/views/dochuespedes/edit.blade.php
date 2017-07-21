@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('dochuespedes.update', $dochuespede->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

 <h1 class="titulo huesped"> Editar Identificación </h1>

 <div class="form-group">
   <label for="titulo" class="col-sm-2 control-label">Tipo de doc.</label>
   <div class="col-sm-10">
     <select class="form-control input-sm" name="tipodocumento_id" value="tipodocumento_id">
      @foreach ($tipodoc as $doc)
        <option value="{{$doc->id}}"  @if($doc->id==$dochuespede->tipodocumento_id)
                selected='selected' @endif>{{ $doc->nombre}}</option>
      @endforeach
    </select>
   </div>
 </div>

 <div class="form-group">
   <label for="titulo" class="col-sm-2 control-label">Documento</label>
   <div class="col-sm-10">
       <input  type="text" class="form-control" name="valordocumento" value="{{ $dochuespede->valordocumento }}">
   </div>
 </div>

 <div class="col-sm-4" style="float:right;">
   <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
 </div>

</form>

@endsection
