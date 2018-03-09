<?php
 use Illuminate\Support\Facades\Input; ?>
<!--vue -->
<script src="{{asset('js/vue.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
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


@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

  <h1 class="titulo estadia"> Modificar Estadía </h1>
  <form action="{{URL::current()}}">

    Tipo de Habitación: {{$estadiahab->habitacione->habitaciontipo->nombre}} <br/>
    Número de Habitacion: {{$estadiahab->habitacione->numero}} <br/>
    Tarifa: ${{$estadiahab->tarifa->valor}} <hr>


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
                           <input type="text" class="form-control datepicker" v-model="film2" readonly="true" name="fechaentrada"
                             @if(empty(Input::get('fechaentrada')))
                               value="{{$estadiahab->fechaentrada}}">
                             @else value="{{Input::get('fechaentrada')}}">
                             @endif
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
                           <input id="dateofchange" type="text" class="form-control datepicker" name="fechasalida"
                           @if(empty(Input::get('fechasalida')))
                             value="{{$estadiahab->fechasalida}}">
                           @else value="{{Input::get('fechasalida')}}">
                           @endif

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



           <form class="form-horizontal" role="form" method="POST" action="{{ route('estadiahab.update', $estadiahab->id ) }}" enctype="multipart/form-data">
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

});

</script>


@endsection
