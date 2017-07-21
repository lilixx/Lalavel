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

<form class="form-horizontal" role="form" method="POST" action="{{ url('clienteadd') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

 <h1 class="titulo cliente">Agregar Cliente </h1>

<!-- Vue  -->
  @verbatim
<div id="app">

<div class="form-group">
  <label for="titulo" class="col-sm-2 control-label">Tipo de Cliente</label>
    <div class="col-sm-7">
        <select v-model="vue.exp" class="form-control input-sm">
          <option v-bind:value="true" name="tipo_entidad" value="1">Empresa</option>
          <option value="2" v-bind:value="false" name="tipo_entidad"  value="2">Persona</option>
        </select>
    </div>
</div>

<input type="hidden" class="form-control" name="role_id" value="2">

<!--  true  -->
<div v-if="vue.exp==true" class="form-group">

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Num. RUC</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="num_ruc"  placeholder="Num. RUC">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Nombre de la Empresa</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="nombres"  placeholder="Nombre">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Teléfono</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="valormediocomunicacion[]"  placeholder="Teléfono">
      <input type="hidden" class="form-control" name="mediocomunicacione_id[]" value="1">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">País</label>
    <div class="col-sm-9">
      <select  class="form-control input-sm" name="paise_id">
       <option value="0" selected="true" disabled="true">Seleccione un país</option>
       @endverbatim
         @foreach ($pais as $pa)
           <option value="{{$pa->id}}">{{$pa->nombre}}</option>
         @endforeach
        @verbatim
      </select>
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="valormediocomunicacion[]"  placeholder="Email">
      <input type="hidden" class="form-control" name="mediocomunicacione_id[]" value="2">
    </div>
  </div>
</div>


<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Tour operadora</label>
    <div class="col-sm-9">
       <label class="radio-inline"><input type="radio" name="tipoentidade_id" value="3">Si</label>
       <label class="radio-inline"><input type="radio" name="tipoentidade_id" value="2">No</label>
    </div>
  </div>
</div>


<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Dirección</label>
    <div class="col-sm-9">
      <textarea type="text" class="form-control" name="direccion"  placeholder="Dirección"></textarea>
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

<!-- add Vue -->

<!--////////////////////////// Contactos de la empresa ////////////////////////// -->
<div class="col-lg-12">
  <h4>Contactos de la Empresa</h4>

 <div v-for="find in finds">

  <div class="col-lg-3">
     <div class="form-group">
       <label for="titulo" class="col-sm-4 control-label">Nombre</label>
       <div class="col-sm-12">
          <input v-model="find.value" type="text" class="form-control" name="nombrec[]"  placeholder="Nombre">
       </div>
     </div>
   </div>

   <div class="col-lg-3">
      <div class="form-group">
        <label for="titulo" class="col-sm-4 control-label">Email</label>
        <div class="col-sm-12">
           <input v-model="find.value2" type="text" class="form-control" name="emailc[]"  placeholder="Email">
        </div>
      </div>
    </div>

    <div class="col-lg-2">
       <div class="form-group">
         <label for="titulo" class="col-sm-4 control-label">Teléfono</label>
         <div class="col-sm-12">
            <input v-model="find.value3" type="text" class="form-control" name="telefonoc[]"  placeholder="Teléfono">
         </div>
       </div>
     </div>

     <div class="col-lg-2">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Cargo</label>
          <div class="col-sm-12">
             <input v-model="find.value4" type="text" class="form-control" name="cargo[]"  placeholder="Cargo" value="email_id">
          </div>
        </div>
      </div>


      <div class="col-lg-2">
       <div class="form-group">
         <a href="#" @click.prevent="todoDelete2(find)" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></a>
       </div>
      </div>

    </div> <!--end v-for -->

    <div class="col-lg-12">
      <a href="#" @click.prevent="addFind" class="btn btn-primary">
         <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Contactos</a>
   </div>


</div>


<!-- fin add Vue -->


</div>

<!--  end true -->

 <div v-if="vue.exp == false" class="form-group">

  <div class="col-lg-6">
   <div class="form-group">
     <label for="titulo" class="col-sm-2 control-label">Nombres</label>
     <div class="col-sm-9">
       <input type="text" class="form-control" name="nombres"  placeholder="Nombre">
     </div>
   </div>
 </div>

 <div class="col-lg-6">
   <div class="form-group">
     <label for="titulo" class="col-sm-2 control-label">Apellidos</label>
     <div class="col-sm-9">
       <input type="text" class="form-control" name="apellidos"  placeholder="Apellidos">
     </div>
   </div>
  </div>

  <input type="hidden" class="form-control" name="tipoentidade_id" value="1">

 <div class="col-lg-6">
   <div class="form-group">
     <label for="titulo" class="col-sm-2 control-label">Dirección</label>
     <div class="col-sm-9">
       <textarea type="text" class="form-control" name="direccion"  placeholder="Dirección"></textarea>
     </div>
   </div>
 </div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Teléfono</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="valormediocomunicacion[]"  placeholder="Teléfono">
      <input type="hidden" class="form-control" name="mediocomunicacione_id[]" value="1">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="valormediocomunicacion[]"  placeholder="Email">
      <input type="hidden" class="form-control" name="mediocomunicacione_id[]" value="2">
    </div>
  </div>
 </div>

<div class="col-lg-6">
   <div class="form-group">
     <label for="titulo" class="col-sm-2 control-label">País</label>
     <div class="col-sm-9">
       <select  class="form-control input-sm" name="paise_id">
        <option value="0" selected="true" disabled="true">Seleccione un país</option>
        @endverbatim
          @foreach ($pais as $pa)
            <option value="{{$pa->id}}">{{$pa->nombre}}</option>
          @endforeach
         @verbatim
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


 </div>

</div>
 @endverbatim

<!-- fin de vue -->



<div class="col-sm-4" style="float:right;">
  <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
   <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
</div>

</form>

<script type="text/javascript">
var demo =  new Vue({
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
