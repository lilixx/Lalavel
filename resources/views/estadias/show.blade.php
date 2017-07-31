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
  <div class="col-lg-8 reserva">
        Número de Habitación: {{$eh->habitacione->numero}} ({{$eh->habitacione->habitaciontipo->nombre}}) <br/>
        Entrada:  {{$eh->fechaentrada}}  -  Salida: {{$eh->fechasalida}} <br/>
        Tarifa:  ${{$eh->tarifa->valor}}
   </div>
  <div class="col-lg-4">
    <a href="" class="btn btn-primary" title="Modificar">
     <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
  </div>

  <table class="table table-striped">
      <thead>
        <tr>
           <th>Huéspedes</th>
           <th><a href="" class="btn btn-info" title="Agregar Huésped">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
           </th>
        </tr>
        <tr>
            <th>Nombre</th>
            <th class="opciones">Acciones</th>
        </tr>
       </thead>

    <tbody>
      @foreach($entidades as $en)
        @if($eh->id == $en->idestadiahab)
            <tr>
              <td> {{$en->nombres}} {{$en->apellidos}} </td>
              <td class="opciones">
                <a href="" class="btn btn-primary" title="Modificar">
                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                 <a href="#" class="btn btn-success" title="Cambiar a otra Habitación">
                 <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>
                 <a href="#" class="btn btn-edit" title="Check out">
                 <span class="glyphicon glyphicon-paste" aria-hidden="true"></span></a>

              </td>
            </tr>
        @endif
     @endforeach
    </tbody>

  </table>

<hr class="separador">
  @endforeach

@endsection
