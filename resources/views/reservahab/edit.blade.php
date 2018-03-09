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

  <h1 class="titulo reserva"> Modificar Reservación </h1>
  <form action="{{URL::current()}}">

   <div class="col-lg-12" style="margin-bottom: 2em;">
    <div class="col-lg-6">
      Tipo de Habitación: {{$reservahab->habitacione->habitaciontipo->nombre}} <br/>
      Número de Habitacion: {{$reservahab->habitacione->numero}} <br/>
   </div>
   <div class="col-lg-6">
      Fecha Entrada: {{$reservahab->fechaentrada}}<br/>
      Fecha Salida: {{$reservahab->fechasalida}}<br/>
      Tarifa: ${{$reservahab->tarifa->valor}} <hr>
   </div>
 </div>


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
                   <label for="titulo" class="col-sm-2 control-label">Fecha de Entrada</label>
                     <div class="col-sm-8">
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
                   <label for="titulo" class="col-sm-2 control-label">Fecha de Salida</label>
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



           <form class="form-horizontal" role="form" method="POST" action="{{ route('reservahab.update', $reservahab->id ) }}" enctype="multipart/form-data">
           <input name="_method" type="hidden" value="PUT">
            {{ csrf_field() }}


              <div class="col-lg-6">
                 <label for="titulo" class="col-sm-4 control-label">Seleccione la Habitación</label>
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
                  <label for="titulo" class="col-sm-2 control-label">Tarifa</label>
                  <div class="col-sm-8">
                    <select  class="form-control" name="tarifa_id">
                     <option value="0" selected="true" disabled="true">Seleccione una Tarifa</option>
                      @foreach ($tarifa as $tr)
                          <option value="{{$tr->id}}">{{$tr->nombre}} - ${{$tr->valor}} </option>
                      @endforeach
                    </select>
                 </div>
                </div>



      <input type="hidden" name="fechasalida" value="{{Input::get('fechasalida')}}">

      <input type="hidden" name="fechaentrada" value="{{Input::get('fechaentrada')}}">

      <input type="hidden" name="reservacionprocedencia_id" value="1">





<div class="col-sm-4" style="float:right;">
  <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
</div>

</form>

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
