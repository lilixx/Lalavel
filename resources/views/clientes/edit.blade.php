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

<form class="form-horizontal" role="form" method="POST" action="{{ route('entidades.update', $cliente->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

 <h1 class="titulo cliente"> Modificar Cliente </h1>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="nombres"  value="{{ $cliente->nombres }}">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Apellidos</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="apellidos" value="{{ $cliente->apellidos }}">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Dirección</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="direccion" value="{{ $cliente->direccion }}">
    </div>
  </div>
</div>

<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">País</label>
    <div class="col-sm-8">
      <select  class="form-control input-sm" name="paise_id">
       <option value="0" selected="true" disabled="true">Seleccione un país</option>
        @foreach ($pais as $pa)
           <option value="{{ $pa->id }}"  @if($pa->id==$cliente->paise_id)
                   selected='selected' @endif> {{ $pa->nombre }}   </option>
        @endforeach
      </select>
    </div>
  </div>
</div>

<input type="hidden" class="form-control" name="role_id" value="2">

 @if($cliente->tipoentidade_id!=1)
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Num. RUC</label>
                    <div class="col-sm-8">
                      <div class="input-group">
                          <input type="text" class="form-control" name="num_ruc" value="{{ $cliente->num_ruc }}">
                      </div>
                    </div>
                </div>
              </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="titulo" class="col-sm-2 control-label">Tour operadora</label>
                <div class="col-sm-9">
                   <label class="radio-inline"><input type="radio" name="tipoentidade_id" value="3"
                     @if($cliente->tipoentidade_id==3) checked="checked" @endif>Si</label>
                   <label class="radio-inline"><input type="radio" name="tipoentidade_id" value="2"
                      @if($cliente->tipoentidade_id==2) checked="checked" @endif>No</label>
                </div>
              </div>
            </div>

 @endif
 

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Comentarios</label>
    <div class="col-sm-8">
      <textarea class="form-control" rows="3" name="comentario">{{$cliente->comentario}}</textarea>
    </div>
  </div>
</div>

<div class="col-sm-4" style="float:right;">
  <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
</div>


@endsection
