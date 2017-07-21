<!--vue -->
<script src="{{asset('js/vue.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
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

<form class="form-horizontal" role="form" method="POST" action="{{ url('folioadd') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

 @if(empty($folioextra))
    <h1 class="titulo folio"> Agregar Folio </h1>
  @else
   <h1 class="titulo folio"> Agregar Folio Extra </h1>
 @endif

<!-- Vue  -->
  @verbatim
<div id="app">

<div class="form-group">
  <label for="titulo" class="col-sm-2 control-label">Folio de</label>
    <div class="col-sm-7">
        <select v-model="vue.exp" class="form-control input-sm">
          <option v-bind:value="true">Cliente</option>
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
          @foreach ($cliente as $cl)
            <option value="{{$cl->id}}">{{$cl->id}} {{$cl->nombres}} {{$cl->apellidos}}</option>
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
       <label for="titulo" class="col-sm-2 control-label">Huésped</label>
       <div class="col-sm-9">
         <select  class="form-control input-sm" name="entidadrole_id">
          <option value="0" selected="true" disabled="true">Seleccione un huésped</option>
           @endverbatim
             @foreach ($huesped as $hp)
               <option value="{{$hp->id}}">{{$hp->nombres}} {{$hp->apellidos}}</option>
             @endforeach
           @verbatim
         </select>
       </div>
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
        <option value="1">Si</option>
        <option value="0">No</option>
      </select>
    </div>
  </div>
</div>

<input type="hidden" name="foliopadre_id" value="{{$folioextra}}">

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-3 control-label">Exoneración</label>
    <div class="col-sm-8">
      <select  class="form-control input-sm" name="exoneracion">
        <option value="0">No</option>
        <option value="1">Si</option>
      </select>
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-3 control-label">Entregó documento</label>
    <div class="col-sm-8">
      <select  class="form-control input-sm" name="documento">
        <option value="0">No</option>
        <option value="1">Si</option>
      </select>
    </div>
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


<div class="col-sm-12" style="float:right;">
  <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
   <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Crear</button>
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
