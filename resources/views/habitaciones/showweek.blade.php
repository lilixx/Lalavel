
@extends('layouts.roomstatus')

@section('content')

  @foreach ($habarea as $ar)
   <a style="padding:1em; background-color: #007F86; color: #fff; margin-right: 2em;" href="#{{$ar->nombre}}">{{$ar->nombre}}</a>
  @endforeach

<table class="table table-hover" style="margin-top: 1em; width:100%">


@foreach ($habarea as $ar)
<tr>
  <th colspan="8"><a name="{{$ar->nombre}}"><h3 class="titulo" style="text-align:center;">{{$ar->nombre}}</h3></a></th>
</tr>

<tr>
<th style="border-style: solid; border-width: 1px;border-top:solid 1px;">Días</th>
@foreach ($ar->habitaciones as $hab)
  <th style="border-style: solid; border-width: 1px;border-top:solid 1px; text-align:center;">{{$hab->numero}}  {{$hab->comentario}}</th>
@endforeach
</tr>

@foreach($day as $dy)


<tr>


  <td style="border-style: solid; border-width: 1px;">
    {{$dy}}
  </td>


    @foreach($ar->habitaciones as $hab)

    <td style="border-style: solid; border-width: 1px; width:100">

        @foreach($containers as $v=>$k )

        {{-- Muestra los datos y el mes actual es = al mes de entrada, Reserva activa o Estadia --}}
          @if($hab->numero == $k["numhab"] && $dy == $k["diaentrada"] && $mes == $k["mesentrada"] && ($k["activo"] == 1 || $k["estadia"] == 1 ||  $k["noshow"] == 1))
            {{-- Las reservas que entran hoy, si el dia de entrada es = al dia actual --}}
            @if($diactual==$k["diaentrada"]  && $k["activo"] == 1)
              <div class="cont_booking" style="background-color:#337ab7; color:#fff; padding: 4px;">
                Núm. de Reserva: {{$k["numero"]}}<br/>
            {{-- Si el dia actual es < al dia de entrada --}}
            @elseif($diactual < $k["diaentrada"]  && $k["activo"] == 1)
            <div class="cont_booking" style="background-color:#F5A514; color:#fff; padding: 4px;">
              Núm. de Reserva: {{$k["numero"]}}<br/>
            {{-- No show, Si el dia actual es > al dia de entrada --}}
            @elseif($diactual > $k["diaentrada"] && ($k["activo"] == 1 || $k["noshow"] == 1))
              <div class="cont_booking" style="background-color:#6b15a1; padding:4px; color:#fff;">
                Núm. de Reserva: {{$k["numero"]}}<br/>
            {{-- En casa, Muestra los datos de la estadia,  --}}
            @else
              <div class="cont_booking" style="background-color:#398439; color:#fff; padding: 4px;">
                Núm. de Estadia: {{$k["numero"]}}<br/>
            @endif
              Día de Entrada: {{$k["diaentrada"]}} <br/>
              Día de Salida: {{$k["diasalida"]}} <br/>
              Núm. de Hab: {{$k["numhab"]}}<br/>
              Tipo de Hab: {{$k["tipo"]}}<br/>
              Tarifa: {{$k["tarifa"]}}<br/>
              NombreTar: {{$k["nombretar"]}}<br/>
              Grupo: {{$k["grupo"]}}<br/>
              Reservahab: {{$k["idreservahab"]}}<br/>
            </div>
            @if($k["grupo"] > 1)
             <div style="padding:1em 6em; background-color:#143373;"></div>
            @endif
            @if($k["nombretar"] != "Rack")
             <div style="padding:1em 6em; background-color:#F61E8F;"></div>
            @endif


          {{-- Muestra el ultimo dia de la reserva y la reserva o la estadia estan activa --}}
        @elseif($hab->numero == $k["numhab"] && $dy == $k["diasalida"] && $mes == $k["messalida"] && ($k["activo"] == 1|| $k["estadia"] == 1 ||  $k["noshow"] == 1))
              {{-- Las reservas que entran hoy, si el dia de entrada es = al dia actual --}}
              @if($diactual==$k["diaentrada"] && $k["activo"] == 1 )
                <div class="cont_booking" style="background-color:#337ab7; color:#fff; padding: 4px;">
                  Núm. de Reserva: {{$k["numero"]}}
              {{-- no show, reserva esta activa o marcada como no show--}}
              @elseif($diactual > $k["diaentrada"] && ($k["activo"] == 1 || $k["noshow"] == 1))
                <div class="cont_booking" style="background-color:#6b15a1; padding:4px; color:#fff;">
                  Núm. de Reserva: {{$k["numero"]}}
              @elseif($mes > $k["mesentrada"] && ($k["activo"] == 1 || $k["noshow"] == 1))
                  <div class="cont_booking" style="background-color:#6b15a1; padding:4px; color:#fff;">
                    Núm. de Reserva: {{$k["numero"]}}
              {{-- Si el dia actual es < al dia de entrada --}}
              @elseif($diactual < $k["diaentrada"]  && $k["activo"] == 1)
               <div class="cont_booking" style="background-color:#F5A514; padding:4px; color:#fff;">
                 Núm. de Reserva: {{$k["numero"]}}
               {{-- En casa, Muestra los datos de la estadia,  --}}
               @else
               <div class="cont_booking" style="background-color:#398439; color:#fff; padding: 4px;">
                   Núm. de Estadia: {{$k["numero"]}}<br/>
              @endif

              </div>
              <div style="padding:0.5em 6em;"></div>


          {{-- Muestra los dias que estan entre la reserva --}}
        @elseif($hab->numero == $k["numhab"] && $dy > $k["diaentrada"] && $dy < $k["diasalida"] && ($k["activo"] == 1|| $k["estadia"] == 1 ||  $k["noshow"] == 1))
            {{-- Las reservas que entran hoy, si el dia de entrada es = al dia actual --}}
            @if($diactual==$k["diaentrada"] && $k["activo"] == 1 )
              <div class="cont_booking" style="background-color:#337ab7; color:#fff; padding: 4px;">
                Núm. de Reserva: {{$k["numero"]}}
            {{-- no show, reserva esta activa o marcada como no show--}}
              @elseif($diactual > $k["diaentrada"] && ($k["activo"] == 1 || $k["noshow"] == 1))
                <div class="cont_booking" style="background-color:#6b15a1; padding:4px; color:#fff;">
                  Núm. de Reserva: {{$k["numero"]}}

            {{-- Si el dia actual es < al dia de entrada --}}
              @elseif($diactual < $k["diaentrada"])
               <div class="cont_booking" style="background-color:#F5A514; padding:4px; color:#fff;">
                 Núm. de Reserva: {{$k["numero"]}}
             {{-- En casa, Muestra los datos de la estadia,  --}}
              @elseif($diactual > $k["diaentrada"])
             <div class="cont_booking" style="background-color:#398439; color:#fff; padding: 4px;">
                 Núm. de Estadia: {{$k["numero"]}}<br/>
             @endif
             </div>
             <div style="padding:0.5em 6em;"></div>

        {{-- Si es una reserva procedente de un mes anterior  --}}
        @elseif($hab->numero == $k["numhab"] && $k["mesentrada"] < $mes && $dy < $k["diasalida"] && $mes == $k["messalida"])
           @if($k["activo"] == 1)
            <div class="cont_booking" style="background-color:#6b15a1; padding:4px; color:#fff;">
           @elseif($k["activo"] == 0 && $k["noshow"] == 1)
             <div class="cont_booking" style="background-color:#6b15a1; padding:4px; color:#fff;">
            @elseif($k["activo"] == 0 && $k["noshow"] == 0)
             <div class="cont_booking" style="background-color:#398439; padding:4px; color:#fff;">
          @endif
                   Núm. de Reserva: {{$k["numero"]}}
             </div>
             <div style="padding:0.5em 6em;"></div>


          @endif
        @endforeach

    </td>

    @endforeach

</tr>


@endforeach
@endforeach



</table>

@endsection
