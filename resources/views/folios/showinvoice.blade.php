@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

  <form class="form-horizontal" role="form" method="POST" action="{{ route('folios.invoicepdf', $count) }}" enctype="multipart/form-data">
  <input name="_method" type="hidden" value="PUT">
   {{ csrf_field() }}


  <h1 class="titulo folio"> Factura de:
    @foreach ($entidad as $en)
            <input type="text" style="width:80%;" name="nombre" value="{{$en->nombres}} {{$en->apellidos}}">
    @endforeach
  </h1>



Fecha: {{$now = \Carbon\Carbon::now()->format('Y-m-d')}}

<input type="hidden" class="form-control" name="fecha" value="{{$now = \Carbon\Carbon::now()->format('Y-m-d')}}">


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
                  <th style="text-align:right;">Importe/Amount</th>

              </tr>
          </thead>

          <tbody>

          @foreach ($categoria as $cat)
            <tr>
              <td><input type="text" class="form-control" name="date[]" value="{{$cat->date}}"></td>
              <td><input type="text" class="form-control" name="cargo[]" value="{{$cat->nombre}}"></td>



             <td style="text-align:right;">
               $  <input type="text" class="form-control-2" name="importe[]" value="{{$cat->total}}">
             </td>
             </tr>
             <?php $count = $count+1; ?>
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

   <input type="hidden" class="form-control" name="subtotal" value="{{$subtotal}}">
   <input type="hidden" class="form-control" name="iva" value="{{$iva}}">
   <input type="hidden" class="form-control" name="intur" value="{{$intur}}">
   <input type="hidden" class="form-control" name="total" value="{{$total}}">

   <div class="col-sm-4" style="float:right;">
     <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
      <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  pdf</button>
   </div>

 </form>

@endsection
