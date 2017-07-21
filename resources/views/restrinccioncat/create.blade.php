@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('restrinccioncat') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

 <h1 class="titulo folio"> Restrincciones del Folio </h1>

 <div class="col-lg-12">
   <div class="form-group">
     <label for="titulo" class="col-sm-3 control-label">Restrinccion de Categorías</label>
     <div class="col-sm-9">
         @foreach ($categoria as $cat)
           <label class="radio-inline"><input type="checkbox" name="categoria_id[]" value="{{$cat->id}}">{{$cat->nombre}}</label>
           @endforeach
      </div>
   </div>
 </div>

  <input type="hidden" name="folio_id" value="{{$folioid}}">

  <div class="col-sm-12" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
  </div>

</form>

@endsection
