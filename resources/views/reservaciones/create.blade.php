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
 <h1 class="titulo estadia"> Agregar Reservación </h1>


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



            <form class="form-horizontal" role="form" method="POST" action="{{ url('reservacionesadd') }}" enctype="multipart/form-data">
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

                  <input type="hidden" name="reservacione_id" value="">

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




         <div id="app">
        <div class="col-lg-12">

      <!--- Folio --------------------------------------------------------------------->
        <h3 class="titulo">Reservación</h3>

          <div class="form-group">
            <label for="titulo" class="col-sm-2 control-label">Reserva de</label>
              <div class="col-sm-7">
                  <select v-model="vue.exp" class="form-control input-sm">
                    <option value="1" v-bind:value="true">Cliente</option>
                    <option value="2" v-bind:value="false">Huésped</option>
                  </select>
              </div>
          </div>


          <!--  true  -->
          <div v-if="vue.exp==true" class="form-group">

          <div class="col-lg-12">
            <div class="form-group">
              <label for="titulo" class="col-sm-2 control-label">Cliente</label>
              <div class="col-sm-9">
                <select  class="form-control input-sm" name="entidadrole_id">
                 <option value="0" selected="true" disabled="true">Seleccione un cliente</option>
                     @endverbatim
                      @foreach ($rol->entidades as $cl)
                        <option value="{{$cl->pivot->id}}">{{$cl->nombres}} {{$cl->apellidos}}</option>
                      @endforeach
                     @verbatim
                </select>
              </div>
            </div>
          </div>


           </div>




          <!--  end true -->

           <div v-if="vue.exp == false" class="form-group">

             <div class="col-lg-5">
               <div class="form-group">
                <label for="titulo" class="col-sm-4 control-label">Nombres</label>
                  <div class="col-sm-8">
                      <input  type="text" class="form-control" name="nombres[]"  placeholder="Ingrese los nombres">
                    </div>
                  </div>
               </div>



               <div class="col-lg-6">
                  <label for="titulo" class="col-sm-4 control-label">Apellidos</label>
                    <div class="col-sm-8">
                       <input type="text" class="form-control" name="apellidos[]"  placeholder="Ingrese los apellidos">
                    </div>
                </div>






          </div> <!--end false -->

          </div>

          <!-- end vue -->




  <!--HUespedes-------------------------------------------------------------------------->

        <div class="col-lg-12">

        <div v-if="vue.exp==false"><h3 class="titulo">Huéspedes Adicionales</h3></div>
        <div v-if="vue.exp==true"><h3 class="titulo">Huéspedes</h3>



             </div>

            </div>

           <div v-for="doc in docs">

           <div class="col-lg-12">
              <div class="col-lg-5">
                <div class="form-group">
                 <label for="titulo" class="col-sm-4 control-label">Nombres</label>
                   <div class="col-sm-8">
                      <input v-model="doc.tipohab" type="text" class="form-control" name="nombres[]"  placeholder="Ingrese los nombres">
                     </div>
                   </div>
                </div>

                <div class="col-lg-6">
                   <label for="titulo" class="col-sm-4 control-label">Apellidos</label>
                     <div class="col-sm-8">
                        <input v-model="doc.valordocumento" type="text" class="form-control" name="apellidos[]"  placeholder="Ingrese los apellidos">
                      </div>
                 </div>

                 <input type="hidden" name="encargado[]" value="0">

                 <div class="col-lg-1">
                    <a href="#" @click.prevent="todoDelete(doc)" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></a>
                 </div>

            </div>

            </div> <!--end div v-for-->

             <div class="col-lg-12">
                <a href="#" @click.prevent="addFind2" class="btn btn-primary">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Huéspedes</a>
             </div>

             <div class="col-lg-8">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Observaciones</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="3" name="comentario"  placeholder="Comentarios"></textarea>
                  </div>
                </div>
             </div>

             <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
              <span class="glyphicon glyphicon-send" aria-hidden="true"></span>  Finalizar</button>






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


<script type="text/javascript">

new Vue({
  el:"#app",
  data:{
    vue:{
      exp: null,
     },
     disableWhenSelect:false,
     film: [],
     habitacione: [],
     tarifa: [],
     actorsShow:true,
     actorsShow2:false,
     actors:[],
     actors2:[],
     docs: [],
     value: [],
     value2: [],
     itemList: [],

  },
  methods: {
    addFind2: function () {
      this.docs.push({ value: '' });
    },
    todoDelete(doc) {
     this.docs.$remove(doc);
    },
    GetActors: function() {
      if(this.film !== ''){
        this.disableWhenSelect = false;
        this.getAllactorFormDataBse(this.film);
        this.actorsShow = true;
        this.actorsShow2 = true;
        this.disableWhenSelect = false;

      }else{
        this.actorsShow = false;
        alert('Please select Film')
      }
    },
    getAllactorFormDataBse:function(id, index){
      this.$http.get('/film/'+ id).then(function(response){
        //done
        //back with data
        //back with out data
        if(response.body[0].habitacione.length > 0){
           this.actors = response.body[0].habitacione;
        }else{
          this.actorsShow = false;
        }

        if(response.body[0].tarifa.length > 0){
           this.actors2 = response.body[0].tarifa;
        }

      },
       function(){
        //error
        alert('unknow error call the developer')
      });
    }
  }
});


</script>






@endsection
