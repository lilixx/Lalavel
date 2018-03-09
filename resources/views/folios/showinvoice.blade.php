@extends('layouts.app')

@section('content')

  @if(Session::has('download.in.the.next.request'))
       <meta http-equiv="refresh" content="5;url={{ Session::get('download.in.the.next.request') }}">
  @endif

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

  <form target="_blank" class="form-horizontal" role="form" method="POST" action="{{ route('folios.invoicepdf', $count) }}" enctype="multipart/form-data">
  <input name="_method" type="hidden" value="PUT">
   {{ csrf_field() }}


  <h1 class="titulo folio"> Factura de:
    @foreach ($entidad as $en)
            <input type="text" style="width:80%;" name="nombre" value="{{$en->nombres}} {{$en->apellidos}}">
            <input type="hidden" class="form-control" name="role_id" value="{{$en->role_id}}">
    @endforeach
  </h1>



Fecha: {{$now = \Carbon\Carbon::now()->format('Y-m-d')}}

<input type="hidden" class="form-control" name="fecha" value="{{$now = \Carbon\Carbon::now()->format('Y-m-d')}}">

<input type="hidden" class="form-control" name="folio_id" value="{{$id}}">


<div class="col-lg-12">
  <hr>
</div>


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
               C$  <input type="text" class="form-control-2" name="importe[]" value="{{$cat->total}}">
             </td>
             </tr>
             <?php $count = $count+1; ?>
          @endforeach

          </tbody>
      </table>
      <table style="float:right; margin-right: 2.5em;">
        <tr><th>Subtotal: </th><td style="text-align:right;">C${{$subtotal}}</td></tr>
        <tr><th style="min-width:150px;">Impuesto/TAX: </th><td style="text-align:right;">C${{$iva}}</td></tr>
        <tr><th>INTUR: </th><td style="text-align:right;">C${{$intur}}</td></tr>
        <tr><th>Total: </th><td style="text-align:right;">C${{$total}}</td></tr>

      </table>
     </div>


   <input type="hidden" class="form-control" name="subtotal" value="{{$subtotal}}">
   <input type="hidden" class="form-control" name="iva" value="{{$iva}}">
   <input type="hidden" class="form-control" name="intur" value="{{$intur}}">
   <input type="hidden" class="form-control" name="total" value="{{$total}}">

   @if($folio->activo ==1)

     <div class="col-sm-4" style="float:right;">
       <button onclick="doTheThing()" type="submit" name="contado" value="1" class="btn btn-edit" style="float:right; margin-bottom:1em; margin-top:2em;">
        <span class="fa fa-hourglass-end" aria-hidden="true"></span> Factura de Contado</button>
     </div>


      @foreach ($entidad as $en)
         @if($en->role_id == 2)
               <div class="col-sm-4" style="float:right;">
                 <button onclick="doTheThing()" type="submit" name="credito" value="1" class="btn btn-primary" style="float:right; margin-bottom:1em; margin-top:2em;">
                  <span class="fa fa-hourglass-start" aria-hidden="true"></span> Factura de Crédito</button>
               </div>

         @endif
      @endforeach

    @elseif($folio->activo == 0 && $folio->estadia_id != null)
     <div class="col-sm-4" style="float:right; margin-top:2em;">
      <a href="/folios/{{ $folio->id }}/checkout" class="btn btn-success" title="Factura">
      <span class="fa fa-rocket" aria-hidden="true"> Check out</span></a>
    </div>

    @endif

    </form>



@endsection

<script>
function doTheThing(){
  setTimeout(function(){
  location.reload();
},6000);
}
</script>
