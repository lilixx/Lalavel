@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


@if($folio->foliopadre_id == NULL)
  <h1 class="titulo folio"> Folio de:
    @foreach ($entidad as $en)
            {{$en->nombres}} {{$en->apellidos}}
    @endforeach
  </h1>
@else
  <h1 class="titulo folio"> Folio Extra de:
    @foreach ($entidad as $en)
            {{$en->nombres}} {{$en->apellidos}}
    @endforeach
  </h1>
@endif

<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Credito</label>
    <div class="col-sm-8">
      <p style="padding-top: 7px;">
        @if ($folio->credito == 1)
          Si
          @else
            No
        @endif
     </p>
    </div>
  </div>
</div>

<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Exoneración</label>
    <div class="col-sm-8">
      <p style="padding-top: 7px;">
        @if ($folio->exoneracion == 1)
          Si
          @else
            No
        @endif
      </p>
    </div>
  </div>
</div>

<div class="col-lg-3">
  <div class="form-group">
    <label for="titulo" class="col-sm-5 control-label">Documento</label>
    <div class="col-sm-7">
      <p style="padding-top: 7px;">
        @if ($folio->documento == 1)
          Si
          @else
            No
        @endif
      </p>
    </div>
  </div>
</div>

<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-5 control-label">Comentarios</label>
      <div class="col-sm-7">
           <p style="padding-top: 7px;">{{ $folio->comentario }}</p>
      </div>
    </div>
</div>

<div class="col-lg-10">

 @if((!($cargo->isEmpty()) || (!empty($folio->estadia_id))) && $foliohijo->isEmpty())
  <a style="float:right; margin-left: 0.5em;" href="<?php echo  url('/');?>/folios/{{ $folio->id }}/showinvoice" class="btn btn-danger">
  <span class="fa fa-print" aria-hidden="true"></span> Factura</a>
 @endif

 @if(($cargo->isEmpty() && (empty($folio->estadia_id))))

   <form class="form-horizontal baja" role="form" method="POST" action="{{ route('folios.baja', $folio->id ) }}" enctype="multipart/form-data"
     onsubmit="return confirm('¿Está seguro de dar de baja al Folio?')">
    <input name="_method" type="hidden" value="PUT">
    {{ csrf_field() }}
     <button type="submit" class="btn btn-warning">
       <span class="fa fa-level-down" aria-hidden="true"> Dar de Baja</span>
     </button>
  </form>

 @endif

  <a style="float:right; margin-left: 0.5em;" href="<?php echo  url('/');?>/folios/{{ $folio->id }}/showstatus" class="btn btn-edit">
  <span class="fa fa-star-half-o" aria-hidden="true"></span> Estado de Cuenta</a>

    @if($folio->foliopadre_id == NULL)
      <td>
        <a style="float:right; margin-left: 0.5em;" href="<?php echo  url('/');?>/folios/{{ $folio->id }}/createchild" class="btn btn-info">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Folio extra</a>
      </td>
    @endif

    <a style="float:right;" href="<?php echo  url('/');?>/folios/{{ $folio->id }}/edit" class="btn btn-success">
    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modificar</a>


</div>

<div class="col-lg-12">
  <hr>
</div>




<div class="col-lg-12">
<table class="table table-striped">
    <thead>
        <tr>
          <th>Habitaciones</th>
          <th><a href="<?php echo  url('/');?>/dochuespede//create" class="btn btn-info" title="Agregar">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
          </th>
        </tr>
        <tr>
            <th>Número</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
      <tr>
         <td>
            @if (!empty($folio->estadia_id))
              @foreach ($folio->estadia->estadiahabitaciones as $esthab)
                {{$esthab->habitacione->numero}},
              @endforeach
            @endif
         </td>
      </tr>
    </tbody>
</table>
</div>

@if($folio->foliopadre_id == NULL)
        <div class="col-lg-6">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th>Folio Extras</th>
                  <th><a href="<?php echo  url('/');?>/folios/{{ $folio->id }}/createchild" class="btn btn-info" title="Agregar">
                      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                  </th>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
              @foreach ($foliohijo as $fl)
              <tr>
                <td> <span>{{-- {{ $fl->entidadrole->entidade->nombres }} {{ $fl->entidadrole->entidade->apellidos }} --}}
                  @foreach ($entidadhijo as $ent)
                    @if ($ent->id == $fl->entidadrole_id)
                      {{$ent->nombres}} {{$ent->apellidos}}
                    @endif
                  @endforeach
                </span> </td>

                 <td>
                    <a href="<?php echo  url('/');?>/folios/{{ $fl->id }}/show" class="btn btn-primary" title="Ver">
                     <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </a>

                     <a href="<?php echo  url('/');?>/foliocargos/{{ $fl->id }}/create" class="btn btn-warning" title="Agregar Cargo">
                       <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
                     </a>
                 </td>
               </tr>
               @endforeach
            </tbody>
        </table>
        </div>
  @endif

@if($folio->padre_id == NULL)
  <div class="col-lg-6">
@else
  <div class="col-lg-12">
@endif

   @if($folio->credito == 1)
    <table class="table table-striped">
        <thead>
            <tr>
              <th>Restrincción de Categorias </th>
              <th><a href="<?php echo  url('/');?>/restrinccioncat/{{ $folio->id }}/create" class="btn btn-info" title="Agregar">
                  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
              </th>
            </tr>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>

            @foreach ($categoria as $cat)
            <tr>
              <td> <span>{{ $cat->categoria->nombre }}</span> </td>

               <td>

                 <form class="form-horizontal" role="form" method="POST" action="{{ route('restrinccioncat.update', $cat->id ) }}" enctype="multipart/form-data"
                   onsubmit="return confirm('¿Está seguro de borrar el registro?')">
                  <input name="_method" type="hidden" value="PUT">
                  {{ csrf_field() }}
                   <button type="submit" class="btn btn-danger">
                     <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                   </button>
                </form>


               </td>
             </tr>
             @endforeach

    </table>
   @endif

  </div>

@if($folio->credito == 1)
      <div class="col-lg-12">
      <table class="table table-striped">
          <thead>
              <tr>
                <th>Cargos</th>
                <th>
                    <a href="<?php echo  url('/');?>/foliocargos/{{ $folio->id }}/create" class="btn btn-info" title="Agregar">
                      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>

                  <a href="<?php echo  url('/');?>/foliocargos/{{ $folio->id }}/move" class="btn btn-danger" title="Mover cargos">
                      <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>

                 </th>
                </tr>
              <tr>
                  <th>Nombre</th>
                  <th>Cantidad</th>
                  <th>Descuento</th>
                  <th>Acciones</th>
              </tr>
          </thead>

          <tbody>

            @foreach ($cargo as $car)
            <tr>
              <td> <span>{{ $car->servicio->nombreservicio }} </span> </td>

              <td> <span>{{ $car->cantidad }}</span> </td>

              <td> <span> @if($car->descuento_id != NULL)
                              {{ $car->descuento->porcentaje }}%
                          @endif
                  </span> </td>

               <td>
                   <a href="<?php echo  url('/');?>/foliocargos/{{ $car->id }}/cubeta" class="btn btn-warning" title="Cubeta">
                     <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span>
                   </a>
               </td>

             </tr>
             @endforeach

          </tbody>
      </table>
     </div>
   @endif

@endsection
