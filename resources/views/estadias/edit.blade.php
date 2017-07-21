<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<!--vue -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.5/vue.min.js"></script>

<script src="https://cdn.jsdelivr.net/vue.resource/1.2.1/vue-resource.min.js"></script>
<!-- Jquery -->
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<!-- Datepicker Files -->
<link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker3.css')}}">
<link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker.standalone.css')}}">
<script src="{{asset('datepicker/js/bootstrap-datepicker.js')}}"></script>
<!-- Languaje -->
<script src="{{asset('datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>


@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('huespede.update', $huespede->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

  <h1 class="titulo huesped"> Modificar Huésped </h1>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Nombres</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="nombres"  value="{{ $huespede->nombres }}">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Apellidos</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="apellidos" value="{{ $huespede->apellidos }}">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Dirección</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="direccion" value="{{ $huespede->direccion }}">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Profesión u oficio</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="profesion" value="{{ $huespede->profesion }}">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Fecha de Nac.</label>
      <div class="col-sm-8">
        <div class="input-group">
            <input type="text" class="form-control datepicker" value="{{ $huespede->fecha_nac }}">
            <div class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </div>
        </div>
      </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Sexo</label>
    <div class="col-sm-8">
       <label class="radio-inline"><input type="radio" name="sexo" value="F" @if($huespede->sexo=="F")
               checked="checked" @endif>F</label>
       <label class="radio-inline"><input type="radio" name="sexo" value="M" @if($huespede->sexo=="M")
               checked="checked" @endif>M</label>
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Estado civil</label>
    <div class="col-sm-8">
      <select class="form-control" name="estado_civil">
          <option @if($huespede->estado_civil=="Soltero")
                  selected='selected' @endif>Soltero</option>
          <option @if($huespede->estado_civil=="Casado")
                  selected='selected' @endif>Casado</option>
          <option @if($huespede->estado_civil=="Divorciado")
                  selected='selected' @endif>Divorciado</option>
          <option @if($huespede->estado_civil=="Viudo")
                  selected='selected' @endif>Viudo</option>
      </select>

    </div>
  </div>
</div>

<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Nacionalidad</label>
    <div class="col-sm-8">
      <select  class="form-control input-sm" name="pais_id">
       <option value="0" selected="true" disabled="true">Seleccione un país</option>
        @foreach ($pais as $pa)
           <option value="{{ $pa->id }}"  @if($pa->id==$huespede->pais_id)
                   selected='selected' @endif> {{ $pa->pais }}   </option>
        @endforeach
      </select>
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Comentarios</label>
    <div class="col-sm-8">
      <textarea class="form-control" rows="3" name="comentario">{{$huespede->comentario}}</textarea>
    </div>
  </div>
</div>

<div class="col-sm-4" style="float:right;">
  <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
</div>


@endsection
