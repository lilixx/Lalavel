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
 <h1 class="titulo estadia"> Modificar Precio y Observaciones </h1>


  <div class="content">


    <form class="form-horizontal" role="form" method="POST" action="{{ route('estadiahab.update', $estadiahab->id ) }}" enctype="multipart/form-data">
    <input name="_method" type="hidden" value="PUT">
     {{ csrf_field() }}

                  <input type="hidden" name="reservacione_id" value="">

                  <div class="col-lg-12">
                    <div class="form-group">
                     <label for="titulo" class="col-sm-2 control-label">Tarifa</label>
                     <div class="col-sm-8">
                       <select  class="form-control" name="tarifa_id" style="margin-bottom: 1em;">
                        <option value="0" selected="true" disabled="true">Seleccione una Tarifa</option>
                          @foreach ($tarifa as $tar)
                             <option value="{{ $tar->id }}"  @if($tar->id==$estadiahab->tarifa_id)
                                     selected='selected' @endif> {{ $tar->nombre }}   </option>
                          @endforeach
                       </select>
                    </div>
                   </div>
                 </div>


             <div class="col-lg-8">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Observaciones</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="3" name="comentario">{{$estadiahab->comentario}}</textarea>
                  </div>
                </div>
             </div>

             <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
              <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>


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
