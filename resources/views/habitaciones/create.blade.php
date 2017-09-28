@extends('layouts.app')

@section('content')

<form class="form-horizontal" role="form" method="POST" action="{{ url('habitacionadd') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

<h1 class="titulo habitacion"> Agregar Habitación </h1>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Número de la Habitación</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="numero"  placeholder="Número de la habitacion">
    </div>
  </div>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Tipo de Habitacion</label>
      <div class="col-sm-10">
          <select id="habitacion_tipo_id" class="form-control input-sm" name="habitacion_tipo_id">
            <option value="0" selected="true" disabled="true">Seleccione un Tipo de Habitación</option>
              @foreach ($habtipo as $tip)
                <option value="{{ $tip->id }}"> {{ $tip->nombre }}   </option>
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
                  <option value="{{ $ar->id }}"> {{ $ar->nombre }}   </option>
               @endforeach
           </select>
        </div>
      </div>


      <div class="col-lg-6">
         <div class="form-group">
           <label for="titulo" class="col-sm-3 control-label">Comentarios</label>
           <div class="col-sm-8">
             <textarea class="form-control" rows="3" name="comentario"  placeholder="Comentarios"></textarea>
           </div>
         </div>
      </div>


    <div class="col-sm-4" style="float:right;">
      <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
       <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
    </div>

</form>
@endsection
