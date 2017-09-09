@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

  <form target="_blank" class="form-horizontal" role="form" method="POST" action="{{ route('folios.out', $idestadia) }}" enctype="multipart/form-data">
  <input name="_method" type="hidden" value="PUT">
  {{ csrf_field() }}

<h1 class="titulo folio"> Check out </h1>

  <input type="hidden" name="estadia_id" value="{{$idestadia}}">


@if (!empty($folio->estadia_id))
  @foreach ($folio->estadia->estadiahabitaciones as $esthab)
    Habitación: {{$esthab->habitacione->numero}}<br/>

    <input type="hidden" name="habitacion_id[]" value="{{$esthab->habitacione->id}}">

    @foreach($entidades as $en)
      @if($esthab->id == $en->idestadiahab)
        {{$en->nombres}} {{$en->apellidos}}<br/>
        <input type="hidden" name="estadia_hab_id[]" value="{{$esthab->id}}">
        <input type="hidden" name="entidad_id[]" value="{{$en->identidad}}">
        <input type="hidden" name="estadia_hab_entidad_id[]" value="{{$en->identidadesthab}}">
      @endif
    @endforeach
    <br/>
  @endforeach
@endif

  <div class="col-sm-12" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="fa fa-rocket" aria-hidden="true"></span>  Check out</button>
  </div>

</form>

@endsection
