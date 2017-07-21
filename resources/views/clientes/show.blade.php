@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


 {{ csrf_field() }}

 <h1 class="titulo cliente"> Cliente: {{ $cliente->nombres }} {{ $cliente->apellidos }} </h1>

 @if($cliente->tipoentidade_id!=1)
    <div class="col-lg-4">
      <div class="form-group">
        <label for="titulo" class="col-sm-4 control-label">Num. RUC</label>
        <div class="col-sm-8">
        <p style="padding-top: 7px;">{{ $cliente->num_ruc }}</p>
        </div>
      </div>
    </div>
 @endif


<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Dirección</label>
    <div class="col-sm-8">
      <p style="padding-top: 7px;">{{ $cliente->direccion }}</p>
    </div>
  </div>
</div>


<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">País</label>
    <div class="col-sm-8">
     <p style="padding-top: 7px;">
        @foreach ($pais as $pa)
            {{ $pa->nombre }}
        @endforeach
     </p>
    </div>
  </div>
</div>


<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Comentarios</label>
    <div class="col-sm-8">
    <p style="padding-top: 7px;">{{$cliente->comentario}}</p>
    </div>
  </div>
</div>

<div class="col-lg-10">
<a style="float:right;" href="<?php echo  url('/');?>/clientes/{{ $cliente->id }}/edit" class="btn btn-success">
<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modificar</a>
</div>

<div class="col-lg-12">
  <hr>
</div>

<!-- tabla de Medio de Comunicacion !-->

<div class="col-lg-12">
<table class="table table-striped">
    <thead>
        <tr>
          <th>Medio de Comunicación</th>
          <th><a href="<?php echo  url('/');?>/mediocomunicaciones/{{ $cliente->id }}/create" class="btn btn-info" title="Agregar">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
          </th>
        </tr>
        <tr>
            <th>Tipo</th>
            <th>Valor</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
       @foreach ($medio as $md)
       <tr>
          <td> <span>{{ $md->nombre }}</span> </td>
          <td> <span>{{ $md->valormediocomunicacion }}</span> </td>

          <td>
             <a href="<?php echo  url('/');?>/mediocomunicaciones/{{ $md->id }}/edit" class="btn btn-primary" title="Modificar">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
             </a>

              <a href="#" class="btn btn-danger" title="Dar de baja">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
              </a>
          </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<!-- tabla de contactos clientes !-->
@if($cliente->tipoentidade_id!=1)
      <div class="col-lg-12">
      <table class="table table-striped">
          <thead>
              <tr>
                <th>Contactos - Cliente</th>
                <th><a href="<?php echo  url('/');?>/contactoclientes/{{ $cliente->id }}/create" class="btn btn-info" title="Agregar">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                </th>
              </tr>
              <tr>

                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Teléfono</th>
                  <th>Cargo</th>
                  <th>Acciones</th>
              </tr>
          </thead>

          <tbody>
             @foreach ($contacto as $td)
             <tr>
                <td> <span>{{ $td->nombres }}</span> </td>
                <td> <span>{{ $td->email }}</span> </td>
                <td> <span>{{ $td->telefono }}</span> </td>
                <td> <span>{{ $td->cargo }}</span> </td>

                <td>
                   <a href="<?php echo  url('/');?>/contactoclientes/{{ $td->id }}/edit" class="btn btn-primary" title="Modificar">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                   </a>

                    <a href="#" class="btn btn-danger" title="Dar de baja">
                      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </a>
                </td>
              </tr>
              @endforeach
          </tbody>
      </table>
      </div>

@endif



@endsection
