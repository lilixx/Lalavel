@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('estadiahab.update', $f) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

 <h1 class="titulo estadia"> Cambiar Huésped a otra Habitación </h1>

@foreach ($estadiahab as $eh)
  <div class="col-sm-12">
  <h3 class="destacado">Huésped:  {{$eh->nombres}} {{$eh->apellidos}} </h3>
  </div><br/>
@endforeach


 <div class="form-group">
   <label for="titulo" class="col-sm-2 control-label">Seleccione la Habitación</label>
   <div class="col-sm-10">
     <select class="form-control input-sm" name="estadia_habitacione_id" value="folio_id">
       <option value="0" selected="true" disabled="true">Seleccione una Habitación</option>
      @foreach ($habitacion as $hab)
        <option value="{{$hab->id}}">{{$hab->numero}}</option>
      @endforeach
    </select>
   </div>
 </div>

   <input type="hidden" name="identidadestadiahab" value="{{$id}}">



 <div class="col-sm-12" style="float:right;">
   <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Cambiar</button>
 </div>


</form>

@endsection
