@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


  <h1 class="titulo folio"> Estado de Cuenta:
    @foreach ($entidad as $en)
            {{$en->nombres}} {{$en->apellidos}}
    @endforeach
  </h1>



Fecha: {{$now = \Carbon\Carbon::now()->format('Y-m-d')}}




<div class="col-lg-12">
  <hr>
</div>




@if($folio->credito == 1)
      <div class="col-lg-12">
      <table class="table table-striped">
          <thead>

              <tr>
                  <th>Fecha/Date</th>
                  <th>Descripcion</th>
                  <th>Cantidad</th>
                  <th>Descuento</th>
                  <th>Valor</th>

              </tr>
          </thead>

          <tbody>

            @foreach ($cargo as $car)
            <tr>
              <td>{{$car->created_at->format('Y-m-d')}}</td>
              <td> <span>{{ $car->servicio->nombreservicio }} </span> </td>

              <td> <span>{{ $car->cantidad }}</span> </td>

              <td> <span> @if($car->descuento_id != NULL)
                              {{ $car->descuento->porcentaje }}%
                          @endif
                  </span> </td>

              <td>
                @if($car->descuento_id != NULL)
                    <span>${{$car->servicio->precio * $car->cantidad - (($car->servicio->precio * $car->cantidad) * ($car->descuento->porcentaje /100))}} </span>
                @else
                    <span>${{$car->servicio->precio * $car->cantidad}} </span>
                @endif
              </td>

             </tr>


             @endforeach

          </tbody>
      </table>
      <table style="float:right; margin-right: 2.5em;">
        <tr><th>Subtotal: </th><td style="text-align:right;">${{$subtotal}}</td></tr>
        <tr><th style="min-width:150px;">Impuesto/TAX: </th><td style="text-align:right;">${{$iva}}</td></tr>
        <tr><th>INTUR: </th><td style="text-align:right;">${{$intur}}</td></tr>
        <tr><th>Total: </th><td style="text-align:right;"> ${{$total}}</td></tr>

      </table>
     </div>
   @endif

@endsection
