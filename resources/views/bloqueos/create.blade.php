<?php
 use Illuminate\Support\Facades\Input; ?>
<!--vue -->
<script src="{{asset('js/vue.min.js')}}"></script>
<script src="{{asset('js/vue-resource.min.js')}}"></script>

<!-- Jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.8.14/themes/smoothness/jquery-ui.css">

<!-- Datepicker Files -->
<link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker3.css')}}">
<link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker.standalone.css')}}">

<!-- Languaje -->
<script src="{{asset('datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>



<link href="/css/step.css" rel="stylesheet">
@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


<meta name="csrf-token" content="{{ csrf_token() }}">
 <h1 class="titulo bloqueo"> Agregar Bloqueo </h1>


  <div class="content">

     <form action="{{URL::current()}}">


             <div class="col-lg-12">
               <div class="form-group">
                 <label for="titulo" class="col-sm-2 control-label">Tipo de Habitación</label>
                     <div class="col-sm-8">
                         <select name="tipohab" class="form-control" value="{{Input::get('tipohab')}}">
                            <option value="0" selected="true" disabled="true">Seleccione un Tipo de habitación</option>
                                @foreach ($tipohab as $th)
                                  <option value="{{ $th->id }}"  @if($th->id==$valth)
                                          selected='selected' @endif> {{ $th->nombre }}   </option>
                                @endforeach
                          </select>
                       </div>
                     </div>
                  </div>



                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="titulo" class="col-sm-2 control-label">Fecha de Inicio</label>
                        <div class="col-sm-8" style="margin-bottom:1em;">
                          <div class="input-group">
                              <input id="dateofchange" track-by="date" v-model="film2"
                               v-on:change="GetActors()" v-bind:disabled="disableWhenSelect" class="form-control datepicker" name="fechaentrada"
                               value="{{Input::get('fechaentrada')}}">
                              <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                              </div>
                          </div>
                        </div>
                    </div>
                  </div>


                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="titulo" class="col-sm-2 control-label">Fecha Fin</label>
                        <div class="col-sm-8">
                          <div class="input-group">
                              <input id="EffectiveDate" type="text" class="form-control datepicker" name="fechasalida"
                              value="{{Input::get('fechasalida')}}">
                              <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                              </div>
                          </div>
                        </div>
                    </div>
                  </div>


                  <div class="col-sm-4" style="float:right;">
                    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
                     <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar</button>
                  </div>


                <div class="col-lg-12">
                   <hr>
               </div>

              </form>



            <form class="form-horizontal" role="form" method="POST" action="{{ url('bloqueoadd') }}" enctype="multipart/form-data">
             {{ csrf_field() }}


                 <div class="col-lg-12">
                    <label for="titulo" class="col-sm-2 control-label">Seleccione la Habitación</label>
                      <div class="col-sm-8">
                        <select  class="form-control" name="habitacione_id">
                         <option value="0" selected="true" disabled="true">Seleccione una Habitación</option>
                            @foreach ($hablibres as $es)
                            <option value="{{$es->id}}">  Num. {{$es->numero}} - {{$es->nombre}}</option>
                            @endforeach
                        </select>
                     </div>
                  </div>


                  <div class="col-lg-12">
                      <div class="form-group">
                    <label for="titulo" class="col-sm-2 control-label">Razón del Bloqueo</label>
                    <div class="col-sm-8">
                       <select  class="form-control" name="razonbloqueo_id">
                       <option value="0" selected="true" disabled="true">Seleccione una razón</option>
                         @foreach ($razonbloqueo as $sp)
                           <option value="{{$sp->id}}">{{$sp->nombre}}</option>
                         @endforeach
                        </select>
                      </div>
                     </div>
                    </div>


                    <div class="col-lg-8">
                       <div class="form-group">
                         <label for="titulo" class="col-sm-2 control-label">Comentarios</label>
                         <div class="col-sm-8">
                           <textarea class="form-control" rows="3" name="comentario"  placeholder="Comentarios"></textarea>
                         </div>
                       </div>
                    </div>



         <input type="hidden" name="fechafin" value="{{Input::get('fechasalida')}}">

         <input type="hidden" name="fechainicio" value="{{Input::get('fechaentrada')}}">










             <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
              <span class="glyphicon glyphicon-send" aria-hidden="true"></span>  Finalizar</button>



     </form>


      </div>






<script type="text/javascript">
function addDays(date) {
    var d = new Date(date);
    d.setDate(d.getDate() + 1);
    return d;
}
function addYear(date){
    var d = new Date(date);
    d.setFullYear(d.getFullYear() + 2);
    return d;
}

$('#dateofchange').datepicker({
    showButtonPanel: true,
    dateFormat: 'yy-mm-dd',
    minDate: new Date(),

    // change EffectiveDate minDate and maxDate when the user selects a date in #dateofchange
    onSelect:function(dateText, inst) {
        var d = new Date(dateText);
        $("#EffectiveDate").datepicker( "option", "minDate", addDays(d));
        $("#EffectiveDate").datepicker( "option", "maxDate", addYear(d));
    }
});

$('#EffectiveDate').datepicker({
    showButtonPanel: true,
    minDate: addDays(new Date()),
    maxDate: addYear(new Date()),
    dateFormat: 'yy-mm-dd',
    locale: 'es',
});


</script>




@endsection
