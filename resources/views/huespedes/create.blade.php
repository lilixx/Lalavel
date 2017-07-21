<!--vue -->
<script src="{{asset('js/vue.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
<script src="{{asset('js/vue-resource.min.js')}}"></script>
<!-- Jquery -->
<script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>
<!-- Datepicker Files -->
<link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker3.css')}}">
<link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker.standalone.css')}}">
<script src="{{asset('datepicker/js/bootstrap-datepicker.js')}}"></script>
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

<form class="form-horizontal" role="form" method="POST" action="{{ url('huespedadd') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

 <h1 class="titulo huesped"> Agregar Huésped </h1>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Nombres</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="nombres"  placeholder="Nombres">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Apellidos</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="apellidos"  placeholder="Apellidos">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Dirección</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="direccion"  placeholder="Dirección">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Profesión u oficio</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="profesion"  placeholder="Profesión">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Fecha de Nacimiento</label>
      <div class="col-sm-8">
        <div class="input-group">
            <input type="text" class="form-control datepicker" name="fecha_nac">
            <div class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </div>
        </div>
      </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Sexo</label>
    <div class="col-sm-8">
       <label class="radio-inline"><input type="radio" name="sexo" value="F">F</label>
       <label class="radio-inline"><input type="radio" name="sexo" value="M">M</label>
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Estado civil</label>
    <div class="col-sm-8">
      <select class="form-control" name="estado_civil">
          <option>------</option>
          <option>Soltero</option>
          <option>Casado</option>
          <option>Divorciado</option>
          <option>Viudo</option>
      </select>

    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Nacionalidad</label>
    <div class="col-sm-8">
      <select  class="form-control input-sm" name="paise_id">
       <option value="0" selected="true" disabled="true">Seleccione un país</option>
         @foreach ($pais as $pa)
           <option value="{{$pa->id}}">{{$pa->nombre}}</option>
         @endforeach
        </select>
    </div>
  </div>
</div>

<input type="hidden" class="form-control" name="tipoentidade_id" value="1">

<input type="hidden" class="form-control" name="role_id" value="1">


<!--////////////////////////// Identificacion ////////////////////////// -->
<div class="col-lg-12">

  <h3>Identificación</h3>
  <div class="col-lg-5">
    <div class="form-group">
     <label for="titulo" class="col-sm-4 control-label">Tipo de doc.</label>
       <div class="col-sm-8">
          <select class="form-control input-sm" name="tipodocumento_id[]" value="tipodocumento_id[]">
           <option value="0" selected="true" disabled="true">Seleccione un documento</option>
           @foreach ($tipodoc as $doc)
              <option value="{{$doc->id}}">{{ $doc->nombre}}</option>
           @endforeach
         </select>
         </div>
       </div>
    </div>

    <div class="col-lg-6">
       <label for="titulo" class="col-sm-4 control-label">Documento</label>
         <div class="col-sm-8">
            <input type="text" class="form-control" name="valordocumento[]"  placeholder="Número del Documento">
         </div>
     </div>

   </div>

 @verbatim
  <div id="app">

    <div v-for="doc in docs">
    <div class="col-lg-12">
       <div class="col-lg-5">
         <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Tipo de doc.</label>
            <div class="col-sm-8">
               <select v-model="doc.value2" id="tipodocumento_id"  class="form-control input-sm" name="tipodocumento_id[]" value="tipo_documento_id">
                 <option value="0" selected="true" disabled="true">Seleccione un documento</option>
                   @endverbatim
                                @foreach ($tipodoc as $doc)
                                   <option value="{{$doc->id}}">{{ $doc->nombre}}</option>
                                @endforeach
                   @verbatim
              </select>
              </div>
            </div>
         </div>

        <div class="col-lg-6">
           <label for="titulo" class="col-sm-4 control-label">Documento</label>
             <div class="col-sm-8">
                <input v-model="doc.value" type="text" class="form-control" name="valordocumento[]"  placeholder="Número del Documento">
              </div>
         </div>

      <div class="col-lg-1">
         <a href="#" @click.prevent="todoDelete(doc)" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></a>
      </div>

    </div>

     </div> <!--end div v-for-->

     <div class="col-lg-12">
        <a href="#" @click.prevent="addFind2" class="btn btn-primary">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Identificación</a>
     </div>


   @endverbatim
   </div> <!--end div app-->


<!--////////////////////////// Medio de Comunicacion ////////////////////////// -->
<div class="col-lg-12">
  <h3>Medio de Comunicación</h3>
</div>
   @verbatim
   <div id="app">

    <div v-for="find in finds">
      <div class="col-lg-12">
      <div class="col-lg-5">
         <div class="form-group">
            <label for="titulo" class="col-sm-4 control-label">Medio</label>
            <div class="col-sm-8">
              <select v-model="find.value2" id="mediocomunicacione_id"  class="form-control input-sm" name="mediocomunicacione_id[]">
              <option value="0" selected="true" disabled="true">Seleccione un medio</option>
              @endverbatim
                           @foreach ($medio as $med)
                              <option value="{{$med->id}}">{{ $med->nombre}}</option>
                           @endforeach
              @verbatim
             </select>

           </div>
          </div>
       </div>

     <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Valor</label>
          <div class="col-sm-8">
             <input v-model="find.value" type="text" class="form-control" name="valormediocomunicacion[]"  placeholder="Medio">
          </div>
        </div>
      </div>

      <div class="col-lg-1">
         <a href="#" @click.prevent="todoDelete2(find)" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></a>
      </div>

        </div>

    </div> <!--end v-for -->

    <div class="col-lg-12">
       <a href="#" @click.prevent="addFind" class="btn btn-primary">
       <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Medio de Comunicación</a>
    </div>

   @endverbatim
 </div><!--end div app -->


<!--////////////////////////// Fin de Medio de Comunicacion ////////////////////////// -->

<div class="col-lg-12">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Comentarios</label>
    <div class="col-sm-8">
      <textarea class="form-control" rows="3" name="comentario"  placeholder="Comentarios"></textarea>
    </div>
  </div>
</div>

    <div class="col-sm-4" style="float:right;">
      <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
       <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
    </div>


</form>

<script>
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true
    });

</script>

<script type="text/javascript">

new Vue({
  el: '#app',
  data: {
    docs: [],
    finds: []
  },
  methods: {
    addFind2: function () {
      this.docs.push({ value: '' });
    },
    addFind: function () {
      this.finds.push({ value: '' });
    },
    todoDelete(doc) {
     this.docs.$remove(doc);
    },
    todoDelete2(find) {
     this.finds.$remove(find);
    },
  }
});
</script>



@endsection
