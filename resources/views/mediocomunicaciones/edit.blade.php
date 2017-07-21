@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('mediocomunicaciones.update', $entidadmedio->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

 @if($rol==1)
    <h1 class="titulo huesped"> Editar Medio de Comunicación del Huésped</h1>
  @else
     <h1 class="titulo cliente"> Editar Medio de Comunicación del Cliente </h1>
 @endif

 <div class="form-group">
   <label for="titulo" class="col-sm-2 control-label">Medio</label>
   <div class="col-sm-10">
     <select class="form-control input-sm" name="mediocomunicacione_id" value="mediocomunicacione_id">
      @foreach ($medio as $tm)
        <option value="{{$tm->id}}"  @if($tm->id==$entidadmedio->mediocomunicacione_id)
                selected='selected' @endif>{{ $tm->nombre}}</option>
      @endforeach
    </select>
   </div>
 </div>

 <input type="hidden" name="rol" value="{{$rol}}">

 <div class="form-group">
   <label for="titulo" class="col-sm-2 control-label">Valor</label>
   <div class="col-sm-10">
       <input  type="text" class="form-control" name="valormediocomunicacion" value="{{ $entidadmedio->valormediocomunicacion }}">
   </div>
 </div>

 <div class="col-sm-4" style="float:right;">
   <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
 </div>

</form>

@endsection
