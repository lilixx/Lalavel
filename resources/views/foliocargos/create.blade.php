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

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

<div class="col-lg-5">
   <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Nombre</label>
       <div class="col-sm-8">
        <input class="typeahead form-control" name="servicio_id[]" style="margin:0px auto" type="text">
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

  <div class="col-lg-5">
     <div class="form-group">
        <label for="titulo" class="col-sm-4 control-label">Nombre</label>
         <div class="col-sm-8">
          <input class="typeahead form-control" style="margin:0px auto" type="text">
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

    <div class="col-lg-5">
       <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Nombre</label>
           <div class="col-sm-8">
            <input class="typeahead form-control" style="margin:0px auto" type="text">
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

    <input type="hidden" name="folio_id" value="{{$folioid}}">


    <div class="col-sm-4" style="float:right;">
      <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
       <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
    </div>


  </form>


<script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    $('input.typeahead').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });
    $('.typeahead').on('typeahead:selected', function (e, datum) {
    console.log(datum);
    $('#id').val(datum.id);
});
</script>


@endsection
