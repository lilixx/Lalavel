@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


  <h1 class="titulo reserva"> Reserva # {{$reserva->id}} </h1>

  @foreach ($entidades as $en)

    @if($en->encargado == 1)
    <h3 class="destacado">   Encargado de la Rerserva: {{$en->nombres}} {{$en->apellidos}}<br/> </h3>
    @endif
    @break
  @endforeach

  @foreach($reserva->reservacionhabitaciones as $rh)
  Fecha: {{$rh->fechaentrada}} / {{$rh->fechasalida}} <br/>
  Habitación: {{$rh->habitacione->numero}} ({{$rh->habitacione->habitaciontipo->nombre}}) <br/>
  @foreach ($entidades as $en)
    @if($en->encargado != 1 && $en->reservacion_habitacione_id == $rh->id)
      {{$en->nombres}} {{$en->apellidos}}<br/>
    @endif
  @endforeach
  <br/>

  @endforeach

  <br/>


@endsection
