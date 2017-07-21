@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


  <h1 class="titulo estadia"> Estadía # {{$estadia->id}} </h1>

  @foreach($estadia->estadiahabitaciones as $eh)
  Número de Habitación: {{$eh->habitacione->numero}} ({{$eh->habitacione->habitaciontipo->nombre}}) <br/>
  Entrada:  {{$eh->fechaentrada}}  -  Salida: {{$eh->fechasalida}} <br/>
  Tarifa:  ${{$eh->tarifa->valor}} <br/>
  <h3>Huespedes:</h3>
  @foreach($entidades as $en)
    @if($eh->id == $en->idestadiahab)
      {{$en->nombres}} {{$en->apellidos}} <br/>
    @endif
  @endforeach

  <hr>
  @endforeach

@endsection
