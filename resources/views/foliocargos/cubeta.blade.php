@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


  <form class="form-horizontal" role="form" method="POST" action="{{ route('foliocargos.update', $foliocargo->id ) }}" enctype="multipart/form-data">
  <input name="_method" type="hidden" value="PUT">
   {{ csrf_field() }}


 <h1 class="titulo folio"> Cargo a cubeta :  {{$foliocargo->servicio->nombreservicio}} </h1>


 <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-3 control-label">Comentario:</label>
      <div class="col-sm-8">
        <textarea class="form-control" rows="3" name="comentariocubeta"  placeholder="Comentarios"></textarea>
      </div>
    </div>
 </div>

<input type="hidden" name="cubeta" value="1">

 <div class="col-sm-4" style="float:right;">
   <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Enviar</button>
 </div>

</form>

@endsection
