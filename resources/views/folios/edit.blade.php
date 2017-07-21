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


<form class="form-horizontal" role="form" method="POST" action="{{ route('folios.update', $folio->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

 <h1 class="titulo folio"> Modificar Folio </h1>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-10">
        <p style="padding-top: 7px;">
          @foreach ($entidadactual as $dad)
             {{$dad->nombres}} {{$dad->apellidos}}
          @endforeach
        </p>
    </div>
  </div>

  <!-- Cambio de dueño  -->
  <div class="panel panel-primary">

     <div class="panel-heading"> <h4>Cambio del Dueño</h4> </div>

      <div class="panel-body">

            <div class="col-lg-12">
              <div class="form-group">
                <label for="titulo" class="col-sm-2 control-label">Nombre</label>
                <div class="col-sm-10">
                  <select  class="form-control input-sm" name="entidadrole_id">
                   <option value="0" selected="true" disabled="true">Seleccione un nombre</option>
                    @endverbatim
                      @foreach ($entidad as $cl)
                        <option value="{{$cl->id}}">{{$cl->nombres}} {{$cl->apellidos}}</option>
                      @endforeach
                    @verbatim
                  </select>
                </div>
              </div>
             </div>

        </div>

   </div>

  <!-- end cambio de dueño -->


  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Crédito</label>
    <div class="col-sm-10">
      <select class="form-control" name="credito">
          <option @if($folio->credito==1)
                  selected='selected' @endif value="1">Si</option>
          <option @if($folio->credito==0)
                  selected='selected' @endif value="0">No</option>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Exoneración</label>
    <div class="col-sm-10">
      <select class="form-control" name="exoneracion">
          <option @if($folio->exoneracion==1)
                  selected='selected' @endif value="1">Si</option>
          <option @if($folio->exoneracion==0)
                  selected='selected' @endif value="0">No</option>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Documento</label>
    <div class="col-sm-10">
      <select class="form-control" name="documento">
          <option @if($folio->documento==1)
                  selected='selected' @endif value="1">Si</option>
          <option @if($folio->documento==0)
                  selected='selected' @endif value="0">No</option>
      </select>
    </div>
  </div>


  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Comentarios</label>
    <div class="col-sm-10">
      <textarea class="form-control" rows="3" name="comentario">{{$folio->comentario}}</textarea>
    </div>
  </div>



<div class="col-sm-4" style="float:right;">
  <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
</div>

</form>



@endsection
