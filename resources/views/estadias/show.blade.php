@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


  <h1 class="titulo estadia"> Estadía # {{$estadia->id}} </h1>

   @if(isset($estadia->comentario))
    <div class="col-lg-12">
      Comentario General: {{$estadia->comentario}} <br/>
    </div>
  @endif    

  @foreach($estadia->estadiahabitaciones as $eh)
  <div class="col-lg-8 reserva">
        Número de Habitación: {{$eh->habitacione->numero}} ({{$eh->habitacione->habitaciontipo->nombre}}) <br/>
        Entrada:  {{$eh->fechaentrada}}  -  Salida: {{$eh->fechasalida}} <br/>
  </div>
  <div class="col-lg-4">
    <a href="<?php echo  url('/');?>/estadiahab/{{$eh->id}}/edit" class="btn btn-primary" title="Modificar">
     <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
  </div>

  <div class="col-lg-12">
     <hr>
  </div>

<div class="col-lg-8">
  Tarifa:  ${{$eh->tarifa->valor}} ({{$eh->tarifa->nombre}}) <br/>
  Observaciones: {{$eh->comentario}}
 </div>

 <div class="col-lg-4">
     <a href="<?php echo  url('/');?>/estadiahab/{{$eh->id}}/editcomentari" class="btn btn-primary" title="Modificar">
      <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
  </div>

  <div class="col-lg-12">
     <hr>
  </div>

  <table class="table table-striped">
      <thead>
        <tr>
           <th>Huéspedes</th>
           <th><a href="<?php echo  url('/');?>/estadiaentidad/{{$eh->id}}/createhuesped" class="btn btn-info" title="Agregar Huésped">
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

                <form method="POST" action="{{ route('estadiahab.update', $en->identidadesthab) }}">
                  <input name="_method" type="hidden" value="PUT">
                   {{ csrf_field() }}
                    <input type="hidden" name="fechasalidaout" value="{{date("Y-m-d")}}">
                    <input type="hidden" name="activo" value="0">
                    <button type="submit" class="btn btn-edit"  title="check out del Huesped" onclick="return confirm('¿Esta seguro de hacer Check out?')">
                      <span class="glyphicon glyphicon-paste" aria-hidden="true"></span>
                   </button>
                </form>

                <a href="<?php echo  url('/');?>/estadiahab/{{$en->identidadesthab}}/move" class="btn btn-success" title="Cambiar a otra Habitación">
                <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>

                <a href="<?php echo  url('/');?>/huespedes/{{$en->identidad}}/edit" class="btn btn-primary" title="Modificar">
                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>




              </td>
            </tr>
        @endif
     @endforeach
    </tbody>

  </table>

<hr class="separador">
  @endforeach

@endsection
