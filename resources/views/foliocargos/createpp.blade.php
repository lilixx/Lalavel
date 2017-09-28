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

<form class="form-horizontal" role="form" method="POST" action="{{ url('foliocargos') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

 <h1 class="titulo folio"> Cargos al Folio </h1>


 <!--////////////////////////// Cargos ////////////////////////// -->
 <div class="col-lg-12">

     <div class="col-lg-5">
        <div class="form-group">
           <label for="titulo" class="col-sm-4 control-label">Nombre</label>
           <div class="col-sm-8">
             <select v-model="find.value2" id="cargo_id"  class="form-control input-sm" name="servicio_id[]" value="cargo_id">
               @foreach ($cargo as $tip)
                 <option value="{{$tip->id}}">{{ $tip->nombreservicio}}</option>
              @endforeach
            </select>
          </div>
         </div>
      </div>

      <div class="col-lg-3">
         <div class="form-group">
           <label for="titulo" class="col-sm-4 control-label">Cantidad</label>
           <div class="col-sm-8">
              <input v-model="find.value" type="number" class="form-control" name="cantidad[]"  placeholder="Cantidad" value="cantidad">
          </div>
         </div>
       </div>

       <div class="col-lg-3">
          <div class="form-group">
             <label for="titulo" class="col-sm-4 control-label">Descuento</label>
             <div class="col-sm-8">
               <select v-model="find.value3" id="descuento_id"  class="form-control input-sm" name="descuento_id[]" value="descuento_id">
               <option value="0" selected="true" disabled="true">Descuento</option>
                 @foreach ($descuento as $desc)
                   <option value="{{$desc->id}}">{{ $desc->porcentaje}}%</option>
                @endforeach
              </select>
            </div>
           </div>
        </div>


    @verbatim
    <div id="app">

     <div v-for="find in finds">
       <div class="col-lg-5">
          <div class="form-group">
             <label for="titulo" class="col-sm-4 control-label">Nombre</label>
             <div class="col-sm-8">
               <select v-model="find.value2" id="cargo_id"  class="form-control input-sm" name="servicio_id[]" value="cargo_id">
     @endverbatim
              @foreach ($cargo as $tip)
                <option value="{{$tip->id}}">{{ $tip->nombreservicio}}</option>
              @endforeach
     @verbatim
              </select>
            </div>
           </div>
        </div>

      <div class="col-lg-3">
         <div class="form-group">
           <label for="titulo" class="col-sm-4 control-label">Cantidad</label>
           <div class="col-sm-8">
              <input v-model="find.value" type="number" class="form-control" name="cantidad[]"  placeholder="Cantidad" value="cantidad">
          </div>
         </div>
       </div>

       <div class="col-lg-3">
          <div class="form-group">
             <label for="titulo" class="col-sm-4 control-label">Descuento</label>
             <div class="col-sm-8">
               <select v-model="find.value3" id="descuento_id"  class="form-control input-sm" name="descuento_id[]" value="descuento_id">
            @endverbatim
                 @foreach ($descuento as $desc)
                   <option value="{{$desc->id}}">{{ $desc->porcentaje}}%</option>
                @endforeach
            @verbatim
              </select>
            </div>
           </div>
        </div>

       <div class="col-lg-1">
          <a href="#" @click.prevent="todoDelete2(find)" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></a>
       </div>

     </div> <!--end v-for -->

     <div class="col-lg-12">
       <a href="#" @click.prevent="addFind" class="btn btn-primary">
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Cargo</a>
    </div>

    @endverbatim

  </div><!--end div app -->
 </div>


  <input type="hidden" name="folio_id" value="{{$folioid}}">

  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
  </div>


</form>


<script type="text/javascript">

new Vue({
  el: '#app',
  data: {
    docs: [],
    tels: [],
    finds: []
  },
  methods: {
    addFind2: function () {
      this.docs.push({ value: '' });
    },
    addFind3: function () {
      this.tels.push({ value: '' });
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
    todoDelete3(tel) {
     this.tels.$remove(tel);
    }
  }
});
</script>

@endsection
