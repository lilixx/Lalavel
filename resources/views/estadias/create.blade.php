<!--vue -->
<script src="{{asset('js/vue.min.js')}}"></script>
<script src="https://unpkg.com/vue"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.3.4"></script>

<!-- Jquery -->
<script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>
<!-- Datepicker Files -->
<link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker3.css')}}">
<link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker.standalone.css')}}">
<script src="{{asset('datepicker/js/bootstrap-datepicker.js')}}"></script>
<!-- Languaje -->
<script src="{{asset('datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>



<link href="/css/step.css" rel="stylesheet">
@extends('layouts.app')

@section('content')

  <body>
   <div id="app">

  <form class="form-horizontal" role="form" method="POST" action="{{ url('estadiaadd') }}" enctype="multipart/form-data">
   {{ csrf_field() }}

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


<meta name="csrf-token" content="{{ csrf_token() }}">
 <h1 class="titulo estadia"> Agregar Estadía - Walking </h1>

 <div class="steps">
  <input id="step_1" type="radio" name="steps" checked="checked"/>
  <label class="step" for="step_1" data-title="Habitación y precio"><span>1</span></label>
  <input id="step_2" type="radio" name="steps"/>
  <label class="step" for="step_2" data-title="Folio y Huéspedes"><span>2</span></label>

  <div class="content">

      <div class="content_1">


          @verbatim

            <div class="col-lg-12">
               <div class="col-lg-6">
                 <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Tipo de Hab.</label>
                    <div class="col-sm-8">
                        <select name="tipohab" track-by="id"  class="form-control" v-model="film"
                         v-on:change="GetActors()" v-bind:disabled="disableWhenSelect">
                           <option value="0" selected="true" disabled="true">Seleccione un Tipo de habitación</option>
                             @endverbatim
                                 @foreach($tipohab as $th)
                                   <option value="{{$th->id}}">{{$th->nombre}}</option>
                                 @endforeach
                             @verbatim
                         </select>
                      </div>
                    </div>
                 </div>


                 <div class="col-lg-12">
                   <div class="form-group">
                     <label for="titulo" class="col-sm-2 control-label">Fecha de Salida</label>
                       <div class="col-sm-8">
                         <div class="input-group">
                             <input id="dateofchange" type="text" track-by="date"  class="form-control" v-model="film2"
                              v-on:change="GetActors()" v-bind:disabled="disableWhenSelect" class="form-control datepicker" name="fechasalida">
                             <div class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                             </div>
                         </div>
                       </div>
                   </div>
                 </div>

                <div class="col-lg-6">
                   <label for="titulo" class="col-sm-4 control-label">Núm. de Hab.</label>
                     <div class="col-sm-8">
                       <select name="habitacione_id" id="habitacione" class="form-control" v-model="habitacione" v-show="actorsShow"
                        value="habitacione_id">
                          <option v-for="a in actors" v-bind:value="a.id">{{a.numero}}</option>
                       </select>
                    </div>
                 </div>

                 <div class="col-lg-6">
                    <label for="titulo" class="col-sm-2 control-label">Tarifa</label>
                      <div class="col-sm-8">
                        <select name="tarifa_id" id="tarifa" class="form-control" v-model="tarifa" v-show="actorsShow2"
                         value="tarifa_id">
                           <option v-for="a in actors2" v-bind:value="a.id">{{a.nombre}}</option>
                        </select>
                     </div>
                  </div>




             </div> <!-- End div col 12 -->



            @endverbatim


       <div class="col-lg-12" style="margin-top:4em;">
          <label class="next" for="step_2">
            <span class="glyphicon glyphicon-arrow-right"aria-hidden="true"></span>
            Siguiente
          </label>
      </div>


      </div> <!--end content 1 -->


      <div class="content_2">

        <div class="content_2">

              @verbatim
               <div id="app">
              <div class="col-lg-12">

            <!--- Folio --------------------------------------------------------------------->
              <h3 class="titulo">Folio</h3>
                <div class="form-group">
                  <label for="titulo" class="col-sm-2 control-label">Folio de</label>
                    <div class="col-sm-7">
                        <select v-model="vue.exp" class="form-control input-sm">
                          <option value="1" v-bind:value="true">Cliente</option>
                          <option value="2" v-bind:value="false">Huésped</option>
                        </select>
                    </div>
                </div>
                 <input type="hidden" name="reservacione_id" value="">
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

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="titulo" class="col-sm-3 control-label">Crédito</label>
                    <div class="col-sm-8">
                      <select  class="form-control input-sm" name="credito">
                          <option value="0">No</option>
                          <option value="1">Si</option>
                      </select>
                    </div>
                  </div>
                </div>



        <!--HUespedes-------------------------------------------------------------------------->

              <div class="col-lg-12">

              <div v-if="vue.exp==false"><h3 class="titulo">Huéspedes Adicionales</h3></div>
              <div v-if="vue.exp==true"><h3 class="titulo">Huéspedes</h3>

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

                   </div>

                  </div>

                 <div v-for="(doc, index) in docs"
                 :itemdata="itemList"
                 :doc="doc">

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

                    <div class="col-lg-1">
                       <a href="#" @click.prevent="removeDoc(index)" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></a>
                    </div>

                  </div>

                  </div> <!--end div v-for-->

                   <div class="col-lg-12">
                      <a href="#" @click.prevent="addFind2" class="btn btn-primary">
                      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Huéspedes</a>
                   </div>

                   <div class="col-lg-8">
                      <div class="form-group">
                        <label for="titulo" class="col-sm-4 control-label">Comentarios</label>
                        <div class="col-sm-8">
                          <textarea class="form-control" rows="3" name="comentario"  placeholder="Comentarios"></textarea>
                        </div>
                      </div>
                   </div>

                   <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
                    <span class="glyphicon glyphicon-send" aria-hidden="true"></span>  Finalizar</button>


               </div><!--end div app-->

               @endverbatim


            </div>
          </div>



      </div>

      </form>


      </div><!--end div app-->


      </body>


<script type="text/javascript">
require('fullcalendar')
  export default {
      mounted() {
          $('#calendar').fullCalendar()
      }
  }
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
     film2: [],
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
      this.docs.push({tipohab: '', valordocumento: ''});
    },
    removeDoc: function(index) {
     Vue.delete(this.docs, index);
   },
    GetActors: function() {
      if(this.film != '' && this.film2 != ''){
        this.disableWhenSelect = false;
        //this.getAllactorFormDataBse(this.film);
        this.getAllactorFormDataBse(this.film, this.film2);
        this.actorsShow = true;
        this.actorsShow2 = true;
        this.disableWhenSelect = false;

      }
    },
    getAllactorFormDataBse:function(id, date, index){
      this.$http.get('/film/'+ id + '/' + date).then((response)=>{
        //done
        //back with data
        //back with out data
        if(response.body.habitacione.length > 0){
           this.actors = response.body.habitacione;
        }else{
          this.actorsShow = false;
        }

        if(response.body.tarifa.length > 0){
           this.actors2 = response.body.tarifa;
        }

      },
      );
    }
  }
});


</script>


@endsection
