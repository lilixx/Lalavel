<!--vue -->
<script src="{{asset('js/vue.min.js')}}"></script>
<script src="{{asset('js/vue-resource.min.js')}}"></script>
<!-- Jquery -->
<script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>


@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


  <form class="form-horizontal" role="form" method="POST" action="{{ route('cargofolio.update', $f) }}" enctype="multipart/form-data">
  <input name="_method" type="hidden" value="PUT">
   {{ csrf_field() }}


<!-- Vue  -->
  @verbatim
<div id="app">

<div class="form-group">
  <label for="titulo" class="col-sm-2 control-label">Mover Cargos a</label>
    <div class="col-sm-7">
        <select v-model="vue.exp" class="form-control input-sm">
          <option v-bind:value="true">Folio Principal</option>
          <option value="2" v-bind:value="false">Folio Extra</option>
        </select>
    </div>
</div>

<!--  true  -->
<div v-if="vue.exp==true" class="form-group">

<div class="col-lg-12">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Folio Principal</label>
    <div class="col-sm-7">
          <select  class="form-control input-sm" name="folio_id" readonly="readonly">
            @endverbatim
              @foreach ($folioprincipal as $fp)
                <option value="{{$fp->id}}">{{$fp->nombre}} {{$fp->nombres}} {{$fp->apellidos}}</option>
              @endforeach
            @verbatim
          </select>
    </div>
  </div>
</div>



 </div>

 @endverbatim


<!--  end true -->

 <div v-if="vue.exp == false" class="form-group">

   <div class="col-lg-12">
     <div class="form-group">
       <label for="titulo" class="col-sm-2 control-label">Folio Extra</label>
       <div class="col-sm-7">
         <select  class="form-control input-sm" name="folioextra_id">
          <option value="0" selected="true" disabled="true">Seleccione un folio Extra</option>
           @endverbatim
             @foreach ($folioextra as $fe)
               <option value="{{$fe->id}}">{{$fe->nombre}} {{$fe->nombres}} {{$fe->apellidos}}</option>
             @endforeach
           @verbatim
         </select>
       </div>
     </div>
   </div>



</div> <!--end false -->

</div>

<!-- end vue -->



<div class="col-lg-8">
  <div class="form-group">
    <label for="titulo" class="col-sm-3 control-label">Cargos a mover</label>
    <div class="col-sm-9">
        @foreach ($cargo as $car)
          <label class="radio-inline"><input type="checkbox" name="id[]" value="{{$car->id}}">{{$car->nombre}}</label>
          @endforeach
     </div>
  </div>
</div>


<div class="col-sm-12" style="float:right;">
  <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
   <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Mover</button>
</div>

</form>

<script type="text/javascript">
var demo = new Vue({
  el: '#app',
  data:{
    vue:{
      exp: null,
    },
    finds: [],
    },
    methods: {
    addFind: function () {
      this.finds.push({ value: '' });
    },
    todoDelete2(find) {
     this.finds.$remove(find);
    }
  }
  });
</script>


@endsection
