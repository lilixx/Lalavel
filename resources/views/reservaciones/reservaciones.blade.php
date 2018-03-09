
@extends('layouts.app')

@section('content')

  @if(isset($edit))
    @include('modificar')
  @else

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">No se puede pasar a Estadía, hay Habitaciones Sucias o que No están Disponibles.</div>
  @endif

<h1 class="titulo reserva"> Reservaciones </h1>

<a href="/reservaciones/create" class="btn btn-info">
  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar</a>

@include('reservaciones.tbl')

@endif

@endsection
