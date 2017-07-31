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


  <form class="form-horizontal" role="form" method="POST" action="{{ url('estadiaadd') }}" enctype="multipart/form-data">
   {{ csrf_field() }}

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


<meta name="csrf-token" content="{{ csrf_token() }}">
 <h1 class="titulo estadia"> Agregar Estadía desde la Reserva </h1>

 <div class="steps">
  <input id="step_1" type="radio" name="steps" checked="checked"/>
  <label class="step" for="step_1" data-title="Habitación y precio"><span>1</span></label>
  <input id="step_2" type="radio" name="steps"/>
  <label class="step" for="step_2" data-title="Folio y Huéspedes"><span>2</span></label>

  <div class="content">

      <div class="content_1">

        @foreach($reserva->reservacionhabitaciones as $rh)

           <div class="col-lg-12">

                <div class="col-lg-6">
                  <div class="form-group">
                   <label for="titulo" class="col-sm-4 control-label">Tipo de Hab.</label>
                     <div class="col-sm-8">
                        <select name="habitacionetipo" id="habitacione[]" class="form-control" value="habitacione_id">
                            <option selected="selected" disabled="disabled" value="volvo">{{$rh->habitacione->habitaciontipo->nombre}}</option>
                          </select>
                       </div>
                     </div>
                  </div>

                  <input type="hidden" name="reservacione_id" value="{{$id}}">

                 <div class="col-lg-6">
                   <div class="form-group">
                    <label for="titulo" class="col-sm-4 control-label">Número</label>
                      <div class="col-sm-8">
                          <select name="habitacione_id[]" class="form-control">
                            <option selected="selected" value="{{$rh->habitacione->id}}">{{$rh->habitacione->numero}}</option>
                          </select>
                      </div>
                    </div>
                  </div>


                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="titulo" class="col-sm-4 control-label">Fecha de Salida</label>
                        <div class="col-sm-8">
                          <div class="input-group">
                              <input type="text" class="form-control datepicker" name="fechasalida[]" value="{{ $rh->fechasalida }}">
                              <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                              </div>
                          </div>
                         </div>
                      </div>
                   </div>


                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="titulo" class="col-sm-4 control-label">Tarifa</label>
                        <div class="col-sm-8">
                          <select name="tarifa_id[]" class="form-control">
                               <option selected="selected" value="{{$rh->tarifa->id}}">${{$rh->tarifa->valor}} - {{$rh->tarifa->nombre}}</option>
                          </select>
                        </div>
                      </div>
                   </div>


             </div> <!-- End div col 12 -->

          <div class="col-lg-12">
             <hr class="separador">
           </div>

          @endforeach





       <div class="col-lg-12 bottom">
          <label class="next" for="step_2">
            <span class="glyphicon glyphicon-arrow-right"aria-hidden="true"></span>
            Siguiente
          </label>
      </div>


      </div> <!--end content 1 -->


      <div class="content_2">

        @verbatim
         <div id="app">
        <div class="col-lg-12">

      <!--- Folio --------------------------------------------------------------------->
        <h3 class="titulo">Folio</h3>

          <div class="form-group">
            <label for="titulo" class="col-sm-2 control-label">Encargado del Folio</label>
              <div class="col-sm-7">
                  <select v-model="vue.exp" class="form-control input-sm">
                    <option value="1" v-bind:value="true">Reserva</option>
                     @endverbatim
                        @foreach ($entidades as $en)
                           @if($en->encargado == 1 && $en->role_id == 1)
                              <option value="2" v-bind:value="false">Cliente</option>
                           @endif
                        @endforeach
                     @verbatim
                  </select>
              </div>
          </div>


          <!--  true  -->
          <div v-if="vue.exp==false" class="form-group">

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

           <div v-if="vue.exp == true" class="form-group">

             @endverbatim
               @foreach ($entidades as $en)
                 @if($en->encargado == 1 && $en->role_id == 1)

                   <div class="col-lg-12">
                     <div class="form-group">
                      <label for="titulo" class="col-sm-2 control-label">Nombres</label>
                        <div class="col-sm-9">
                          <select name="entidade_id[]" class="form-control">
                            <option selected="selected" value="{{$en->id}}">{{$en->nombres}} {{$en->apellidos}}</option>
                          </select>
                          </div>
                        </div>
                     </div>

                 <input type="hidden" name="habhuesped_id[]" value="{{$en->habitacione_id}}">

                  @elseif($en->encargado == 1 && $en->role_id == 2)
                    <div class="col-lg-12">
                      <div class="form-group">
                       <label for="titulo" class="col-sm-2 control-label">Nombres</label>
                         <div class="col-sm-9">
                           <select name="entidadrole_id" class="form-control">
                             <option selected="selected" value="{{$en->id}}">{{$en->nombres}}</option>
                           </select>
                           </div>
                         </div>
                      </div>
                @endif
              @endforeach
              @verbatim

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

        <div v-if="vue.exp==true"><h3 class="titulo">Huéspedes</h3>

              @endverbatim
                @foreach ($entidades as $en)
                  @if($en->encargado != 1)
                <div class="col-lg-12">
                    <div class="col-lg-9">
                      <div class="form-group">
                       <label for="titulo" class="col-sm-2 control-label">Nombre</label>
                         <div class="col-sm-10">
                           <select name="entidade_id[]" class="form-control">
                             <option selected="selected" value="{{$en->id}}">{{$en->nombres}} {{$en->apellidos}}</option>
                           </select>
                           </div>
                         </div>
                      </div>
                  </div>

                  <input type="hidden" name="habhuesped_id[]" value="{{$en->habitacione_id}}">



                   @endif
                 @endforeach

                @verbatim

        </div>


        <div v-if="vue.exp==false"><h3 class="titulo">Huéspedes</h3>

        @endverbatim
          @foreach ($entidades as $en)

          <div class="col-lg-12">
            <div class="col-lg-8">
              <div class="form-group">
               <label for="titulo" class="col-sm-2 control-label">Nombre</label>
                 <div class="col-sm-10">
                   <select name="entidade_id[]" class="form-control">
                     <option selected="selected" value="{{$en->id}}">{{$en->nombres}} {{$en->apellidos}}</option>
                   </select>
                   </div>
                 </div>
              </div>
            </div>

             <input type="hidden" name="habhuesped_id[]" value="{{$en->habitacione_id}}">

           @endforeach

          @verbatim

             </div>

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
