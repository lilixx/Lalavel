@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('foliocargos.update', $f) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

 <h1 class="titulo folio"> Mover Cargos a otro Folio </h1>

 <div class="form-group">
   <label for="titulo" class="col-sm-2 control-label">Seleccione el Folio</label>
   <div class="col-sm-10">
     <select class="form-control input-sm" name="folio_id" value="folio_id">
       <option value="0" selected="true" disabled="true">Seleccione un nombre</option>
      @foreach ($folio as $fl)
        <option value="{{$fl->id}}">
          {{$fl->entidadrole->entidade->nombres}} {{$fl->entidadrole->entidade->apellidos}}</option>
      @endforeach
    </select>
   </div>
 </div>

   <input type="hidden" name="folio_anterior" value="{{$id}}">

 <div class="col-lg-7">
   <div class="form-group">
     <label for="titulo" class="col-sm-3 control-label">Cargos a mover</label>
     <div class="col-sm-9">
         @foreach ($cargo as $car)
           <label class="radio-inline"><input type="checkbox" name="id[]" value="{{$car->id}}">
             {{$car->servicio->nombreservicio}} ({{$car->cantidad}})</label>
           @endforeach
      </div>
   </div>
 </div>


 <div class="col-sm-12" style="float:right;">
   <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Mover</button>
 </div>


</form>

@endsection
