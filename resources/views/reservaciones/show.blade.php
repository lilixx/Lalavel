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
      <div class="col-lg-12">
        <div class="col-lg-8 reserva">
        Fecha: {{$rh->fechaentrada}} / {{$rh->fechasalida}} <br/>
        Habitación: {{$rh->habitacione->numero}} ({{$rh->habitacione->habitaciontipo->nombre}}) <br/>
      </div>
      <div class="col-lg-4">
        <a href="<?php echo  url('/');?>/reservahab/{{$rh->id}}/edit" class="btn btn-primary" title="Modificar">
         <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
      </div>

      <table class="table table-striped">
        <thead>
          <tr>
            <th>Huéspedes</th>
            <th><a href="<?php echo  url('/');?>/reservaentidad/{{$rh->id}}/createhuesped" class="btn btn-info" title="Agregar Huésped">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
            </th>
          </tr>
          <tr>
            <th>Nombre</th>
            <th>Acciones</th>
          </tr>
          </thead>

          <tbody>
             @foreach ($entidades as $en)
               @if($en->reservacion_habitacione_id == $rh->id)
                 <tr>
                       <td>
                           {{$en->nombres}} {{$en->apellidos}}
                       </td>
                    <td>
                      <a href="<?php echo  url('/');?>/huespedes/{{$en->id}}/edit" class="btn btn-primary" title="Modificar">
                       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                       <a href="#" class="btn btn-danger" title="Dar de baja">
                       <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                    </td>
                  </tr>
                @endif
              @endforeach
          </tbody>

        </table>
          <hr class="separador">

     </div>

  @endforeach

  <br/>


@endsection
