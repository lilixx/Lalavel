@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('habitaciones.update', $habitacion->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">

 {{ csrf_field() }}

 <h1 class="titulo habitacion"> Modificar Habitación </h1>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Número de la Habitación</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="numero" value="{{ $habitacion->numero }}">
    </div>
  </div>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Tipo de Habitacion</label>
      <div class="col-sm-10">
          <select id="habitacion_tipo_id" class="form-control input-sm" name="habitacion_tipo_id">
              @foreach ($habtipo as $tip)
                <option value="{{ $tip->id }}"  @if($tip->id==$habitacion->habitacion_tipo_id)
                        selected='selected' @endif> {{ $tip->nombre }}   </option>
             @endforeach
         </select>
      </div>
    </div>

    <div class="form-group">
      <label for="titulo" class="col-sm-2 control-label">Área de la Habitacion</label>
        <div class="col-sm-10">
            <select id="habitacion_area_id" class="form-control input-sm" name="habitacion_area_id">
              <option value="0" selected="true" disabled="true">Seleccione un Área</option>
                @foreach ($habarea as $ar)
                  <option value="{{ $ar->id }}"  @if($ar->id==$habitacion->habitacion_area_id)
                          selected='selected' @endif> {{ $ar->nombre }}   </option>
                @endforeach
           </select>
        </div>
      </div>

      <div class="col-lg-6">
         <div class="form-group">
           <label for="titulo" class="col-sm-3 control-label">Comentarios</label>
           <div class="col-sm-8">
             <textarea class="form-control" rows="3" name="comentario">{{$habitacion->comentario}}</textarea>
           </div>
         </div>
      </div>


    <div class="col-sm-4" style="float:right;">
      <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
       <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
    </div>

</form>

@endsection
