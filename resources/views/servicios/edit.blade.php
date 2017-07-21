<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
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

<form class="form-horizontal" role="form" method="POST" action="{{ route('servicios.update', $servicio->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

<h1 class="titulo cargo"> Modificar Servicio </h1>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nombreservicio" value="{{ $servicio->nombreservicio }}">
    </div>
  </div>

  <div class="form-group">
    <label for="precio" class="col-sm-2 control-label">Precio</label>
    <div class="col-sm-10">
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">$</span>
        <input type="text" class="form-control" name="precio" value="{{ $servicio->precio }}"/>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Categoría</label>
      <div class="col-sm-10">
          <select id="categoria_id" class="form-control input-sm" name="categoria_id">
            @foreach ($categoria as $cat)
                 <option value="{{ $cat->id }}"  @if($cat->id==$servicio->categoria_id)
                         selected='selected' @endif> {{ $cat->nombre }} </option>
            @endforeach
         </select>
      </div>
    </div>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Descripción</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="descripcion"  value="{{ $servicio->descripcion }}">
    </div>
  </div>

      <div class="col-sm-4" style="float:right;">
        <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
         <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
      </div>

</form>

<script>
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true
    });

    $('.datepicker2').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true
    });
</script>

@endsection
