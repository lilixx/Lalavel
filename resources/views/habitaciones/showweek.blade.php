
@extends('layouts.roomstatus')

@section('content')

<table class="table table-hover" style="width:100%">


@foreach ($habarea as $ar)
<tr>
  <th colspan="8"><h3 class="titulo" style="text-align:center;">{{$ar->nombre}}</h3></th>
</tr>

<tr>
<th style="border-style: solid; border-width: 1px;border-top:solid 1px;">Días</th>
@foreach ($ar->habitaciones as $hab)
  <th style="border-style: solid; border-width: 1px;border-top:solid 1px;">{{$hab->numero}}  {{$hab->comentario}}</th>
@endforeach
</tr>

@foreach($containers as $v=>$k )

<tr>


  <td style="border-style: solid; border-width: 1px;">
    {{$k["dia"]}}
  </td>

  @foreach($ar->habitaciones as $hab)

     @if($hab->numero == $k["numhab"] && $k["dia"] == $k["diaentrada"] && $mes == $k["mesentrada"])
       <td style="border-style: solid; border-width: 1px; background-color:#6f5499;">
       Día de Entrada: {{$k["diaentrada"]}} <br/>
       Número de Reserva: {{$k["numreserva"]}}<br/>
       Número de Hab: {{$k["numhab"]}}<br/>
       Tipo de Hab: {{$k["numhab"]}}<br/>
       Tarifa: {{$k["tarifa"]}}<br/>
      </td>
     @elseif($hab->numero == $k["numhab"] && $k["dia"] == $k["diasalida"] && $mes == $k["messalida"])
      <td style="border-style: solid; border-width: 1px; background-color:#6f5499;">
         {{$k["diasalida"]}}
      </td>
     @elseif($hab->numero == $k["numhab"] && $k["dia"] > $k["diaentrada"] && $k["dia"] < $k["diasalida"])
      <td style="border-style: solid; border-width: 1px; background-color:#6f5499;"></td>
    @else
      <td style="border-style: solid; border-width: 1px;"></td>
    @endif

 @endforeach

</tr>


@endforeach
@endforeach



</table>

@endsection
