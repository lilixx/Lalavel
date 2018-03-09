
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
          @if($hab->numero == $k["numhab"] && $dy == $k["diaentrada"] && $mes == $k["mesentrada"] && ($k["activo"] == 1 || $k["tipo"] == 1 ||  $k["noshow"] == 1 ||  $k["tipo"] == 2))

          {{-- Si es una Reserva --}}
            @if($k["tipo"] == 0)
              <div class="titulo_rsb reserva"><div style="margin-bottom:0.2em;">Reserva #{{$k["numero"]}}</div>

                 {{-- No show --}}
                  @if($diactual > $k["diaentrada"] && ($k["activo"] == 1 || $k["noshow"] == 1))
                    <div class="icon_rsb noshow" title="Mantenimiento">
                    <span class="fa fa-snapchat-ghost fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                  @endif

                 {{-- Si es un grupo --}}
                 @if($k["grupo"] > 1)
                    <div class="icon_rsb group" title="Grupo">
                    <span class="fa fa-users fa-1x float-right" style="color:#fff;" aria-hidden="true"></span></div>
                 @endif

                 {{-- Promoción --}}
                  @if($k["nombretar"] != "Rack" && ($k["tarifa"] != 0))
                    <div class="icon_rsb promo"  title="Tarifa Promo">
                    <span class="fa fa-tag fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                  @endif

                  {{-- Cortesia --}}
                   @if($k["tarifa"] == 0)
                     <div class="icon_rsb cortesia"  title="Cortesia">
                     <span class="fa fa-gift fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                   @endif

                 {{-- Entran el dia de hoy --}}
                  @if($diactual==$k["diaentrada"]  && $k["activo"] == 1)
                    <div class="icon_rsb checkint"  title="Hoy es el Check in">
                    <span class="fa fa-clock-o fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                  @endif
                </div>

                <div style="background:#333333; color:#fff;">
                    <div style="margin-left:0.5em;     padding-top: 2em;
                    padding-bottom: 0.5em;">
                    Entrada: {{$k["fechaentrada"]}} <br/>
                    Salida: {{$k["fechasalida"]}} <br/>
                    Núm. de Hab: {{$k["numhab"]}}<br/>
                    Tipo de Hab: {{$k["tipohab"]}}<br/>
                    Tarifa: ${{$k["tarifa"]}}<br/>
                    Reservado por:<br/>
                    Comentario: <br/>
                    Recepcionista: <br/>

                   </div>
               </div>
           @endif

           {{--Estadia--}}
          @if($k["tipo"] == 1)
           <div class="titulo_rsb estadia"><div style="margin-bottom:0.2em;">Estadía #{{$k["numero"]}}</div>
            {{-- Si es un grupo --}}
            @if($k["grupo"] > 1)
               <div class="icon_rsb group" title="Grupo">
               <span class="fa fa-users fa-1x float-right" style="color:#fff;" aria-hidden="true"></span></div>
            @endif

            {{-- Promoción --}}
             @if($k["nombretar"] != "Rack" && ($k["tarifa"] != 0))
               <div class="icon_rsb promo"  title="Tarifa Promo">
               <span class="fa fa-tag fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
             @endif

             {{-- Cortesia --}}
              @if($k["tarifa"] == 0)
                <div class="icon_rsb cortesia"  title="cortesia">
                <span class="fa fa-gift fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
              @endif


             {{--Estadia Walking --}}
             @if(empty($k["walking"]))
               <div class="icon_rsb walking"  title="Walking">
               <span class="fa fa-calendar-check-o fa-1x float-right" style="color:#fff;" aria-hidden="true"></span></div>
             @endif

            </div>

             <div style="background:#333333; color:#fff;">
                 <div style="margin-left:0.5em;     padding-top: 2em;
                 padding-bottom: 0.5em;">
                 Día de Entrada: {{$k["diaentrada"]}} <br/>
                 Día de Salida: {{$k["diasalida"]}} <br/>
                 Núm. de Hab: {{$k["numhab"]}}<br/>
                 Tipo de Hab: {{$k["tipohab"]}}<br/>
                 Tarifa: {{$k["tarifa"]}}<br/>
                 NombreTar: {{$k["nombretar"]}}<br/>
                 Reservahab: {{$k["idreservahab"]}}<br/>
                </div>
            </div>

          @endif

            {{--Bloqueo --}}
          @if($k["tipo"] == 2)
            <div class="titulo_rsb bloqueo"><div style="margin-bottom:0.2em;">Bloqueo #{{$k["numero"]}}</div>

            {{--Mantenimiento --}}
            @if($k["idrazonbloqueo"] == 1)
              <div class="icon_rsb mantenimiento"  title="{{$k["bloqueadopor"]}}">
                <span class="fa fa-wrench fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
              </div>
            @endif

            {{--Futura venta --}}
            @if($k["idrazonbloqueo"] == 2)
              <div class="icon_rsb mantenimiento"  title="{{$k["bloqueadopor"]}}">
                <span class="fa fa-shopping-basket fa-1x float-right" style="color:#fff;" aria-hidden="true"></span></div>
              </div>
            @endif

            {{--Late check out --}}
            @if($k["idrazonbloqueo"] == 3)
              <div class="icon_rsb mantenimiento"  title="{{$k["bloqueadopor"]}}">
                <span class="fa fa-clock-o fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
              </div>
            @endif

            {{--Prestamo --}}
            @if($k["idrazonbloqueo"] == 4)
              <div class="icon_rsb mantenimiento"  title="{{$k["bloqueadopor"]}}">
                <span class="fa fa-key fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
              </div>
            @endif


              <div style="background:#333333; color:#fff;">
                <div style="margin-left:0.5em; padding-top: 2em;
                padding-bottom: 0.5em;">
                Día de Entrada: {{$k["diaentrada"]}} <br/>
                Día de Salida: {{$k["diasalida"]}} <br/>
                Núm. de Hab: {{$k["numhab"]}}<br/>
                Tipo de Hab: {{$k["tipohab"]}}<br/>
                Tarifa: {{$k["tarifa"]}}<br/>
                NombreTar: {{$k["nombretar"]}}<br/>
                Reservahab: {{$k["idreservahab"]}}<br/>
               </div>
             </div>

         @endif

        <div style="padding:0.5em 6em;"></div>


          {{-- Muestra el ultimo dia de la reserva y la reserva o la estadia estan activa --}}
        @elseif($hab->numero == $k["numhab"] && $dy == $k["diasalida"] && $mes == $k["messalida"] && ($k["activo"] == 1|| $k["tipo"] == 1 || $k["tipo"] == 2 ||  $k["noshow"] == 1))

            {{-- Si es una Reserva --}}
              @if($k["tipo"] == 0)
                <div class="titulo_rsb reserva"><div style="margin-bottom:0.2em;">Reserva #{{$k["numero"]}} </div>

                   {{-- No show --}}
                    @if($diactual > $k["diaentrada"] && ($k["activo"] == 1 || $k["noshow"] == 1))
                      <div class="icon_rsb noshow" title="No Show">
                      <span class="fa fa-snapchat-ghost fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                    @endif

                   {{-- Si es un grupo --}}
                   @if($k["grupo"] > 1)
                      <div class="icon_rsb group" title="Grupo">
                      <span class="fa fa-users fa-1x float-right" style="color:#fff;" aria-hidden="true"></span></div>
                   @endif

                   {{-- Promoción --}}
                    @if($k["nombretar"] != "Rack" && ($k["tarifa"] != 0))
                      <div class="icon_rsb promo"  title="Tarifa Promo">
                      <span class="fa fa-tag fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                    @endif

                    {{-- Cortesia --}}
                     @if($k["tarifa"] == 0)
                       <div class="icon_rsb cortesia"  title="Cortesia">
                       <span class="fa fa-gift fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                     @endif

                   {{-- Entran el dia de hoy --}}
                    @if($diactual==$k["diaentrada"]  && $k["activo"] == 1)
                      <div class="icon_rsb checkint"  title="Hoy es el Check in">
                      <span class="fa fa-clock-o fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                    @endif
                  </div>
               @endif

               {{--Estadia--}}
              @if($k["tipo"] == 1)
               <div class="titulo_rsb estadia"><div style="margin-bottom:0.2em;">Estadía # {{$k["numero"]}}</div>
                {{-- Si es un grupo --}}
                @if($k["grupo"] > 1)
                   <div class="icon_rsb group" title="Grupo">
                   <span class="fa fa-users fa-1x float-right" style="color:#fff;" aria-hidden="true"></span></div>
                @endif

                {{-- Promoción --}}
                 @if($k["nombretar"] != "Rack" && ($k["tarifa"] != 0))
                   <div class="icon_rsb promo"  title="Tarifa Promo">
                   <span class="fa fa-tag fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                 @endif

                 {{-- Cortesia --}}
                  @if($k["tarifa"] == 0)
                    <div class="icon_rsb cortesia"  title="cortesia">
                    <span class="fa fa-gift fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                  @endif


                 {{--Estadia Walking --}}
                 @if(empty($k["walking"]))
                   <div class="icon_rsb walking"  title="Walking">
                   <span class="fa fa-calendar-check-o fa-1x float-right" style="color:#fff;" aria-hidden="true"></span></div>
                 @endif

                </div>
              @endif


              {{--Bloqueo --}}
            @if($k["tipo"] == 2)
              <div class="titulo_rsb bloqueo"><div style="margin-bottom:0.2em;">Bloqueo #{{$k["numero"]}}</div>
              <div class="icon_rsb mantenimiento"  title="Hoy es el Check in">
              <span class="fa fa-wrench fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
              </div>
            @endif


            <div style="padding:1em 6em; margin-bottom:1em; background-color:#333333"></div>


          {{-- Muestra los dias que estan entre la reserva --}}
        @elseif($hab->numero == $k["numhab"] && $dy > $k["diaentrada"] && $dy < $k["diasalida"] && ($k["activo"] == 1|| $k["tipo"] == 2 || $k["tipo"] == 1 ||  $k["noshow"] == 1))

          {{-- Si es una Reserva --}}
            @if($k["tipo"] == 0)
              <div class="titulo_rsb reserva"><div style="margin-bottom:0.2em;">Reserva #{{$k["numero"]}} </div>

                 {{-- No show --}}
                  @if($diactual > $k["diaentrada"] && ($k["activo"] == 1 || $k["noshow"] == 1))
                    <div class="icon_rsb noshow" title="No Show">
                    <span class="fa fa-snapchat-ghost fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                  @endif

                 {{-- Si es un grupo --}}
                 @if($k["grupo"] > 1)
                    <div class="icon_rsb group" title="Grupo">
                    <span class="fa fa-users fa-1x float-right" style="color:#fff;" aria-hidden="true"></span></div>
                 @endif

                 {{-- Promoción --}}
                  @if($k["nombretar"] != "Rack" && ($k["tarifa"] != 0))
                    <div class="icon_rsb promo"  title="Tarifa Promo">
                    <span class="fa fa-tag fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                  @endif

                  {{-- Cortesia --}}
                   @if($k["tarifa"] == 0)
                     <div class="icon_rsb cortesia"  title="cortesia">
                     <span class="fa fa-gift fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                   @endif

                 {{-- Entran el dia de hoy --}}
                  @if($diactual==$k["diaentrada"]  && $k["activo"] == 1)
                    <div class="icon_rsb checkint"  title="Hoy es el Check in">
                    <span class="fa fa-clock-o fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                  @endif
                </div>
             @endif

             {{--Estadia--}}
            @if($k["tipo"] == 1)
             <div class="titulo_rsb estadia"><div style="margin-bottom:0.2em;">Estadía # {{$k["numero"]}}</div>
              {{-- Si es un grupo --}}
              @if($k["grupo"] > 1)
                 <div class="icon_rsb group" title="Grupo">
                 <span class="fa fa-users fa-1x float-right" style="color:#fff;" aria-hidden="true"></span></div>
              @endif

              {{-- Promoción --}}
               @if($k["nombretar"] != "Rack" && ($k["tarifa"] != 0))
                 <div class="icon_rsb promo"  title="Tarifa Promo">
                 <span class="fa fa-tag fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
               @endif

               {{-- Cortesia --}}
                @if($k["tarifa"] == 0)
                  <div class="icon_rsb cortesia"  title="Tarifa Promo">
                  <span class="fa fa-gift fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                @endif

               {{--Estadia Walking --}}
               @if(empty($k["walking"]))
                 <div class="icon_rsb walking"  title="Walking">
                 <span class="fa fa-calendar-check-o fa-1x float-right" style="color:#fff;" aria-hidden="true"></span></div>
               @endif

              </div>
            @endif


            {{--Bloqueo --}}
          @if($k["tipo"] == 2)
            <div class="titulo_rsb bloqueo"><div style="margin-bottom:0.2em;">Bloqueo #{{$k["numero"]}}</div>
            <div class="icon_rsb mantenimiento"  title="Hoy es el Check in">
            <span class="fa fa-wrench fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
            </div>
          @endif

        <div style="padding:1em 6em; margin-bottom:1em; background-color:#333333"></div>

        {{-- Si es una reserva procedente de un mes anterior  --}}
        @elseif($hab->numero == $k["numhab"] && $k["mesentrada"] < $mes && $dy < $k["diasalida"] && $mes == $k["messalida"])

             {{-- Si es una Reserva --}}
               @if($k["tipo"] == 0)
                 <div class="titulo_rsb reserva"><div style="margin-bottom:0.2em;">Reserva #{{$k["numero"]}} </div>

                    {{-- No show --}}
                     @if($k["activo"] == 1 || ($k["activo"] == 0 && $k["noshow"] == 1))
                       <div class="icon_rsb noshow" title="No Show">
                       <span class="fa fa-snapchat-ghost fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                     @endif

                    {{-- Si es un grupo --}}
                    @if($k["grupo"] > 1)
                       <div class="icon_rsb group" title="Grupo">
                       <span class="fa fa-users fa-1x float-right" style="color:#fff;" aria-hidden="true"></span></div>
                    @endif

                    {{-- Promoción --}}
                     @if($k["nombretar"] != "Rack" && ($k["tarifa"] != 0))
                       <div class="icon_rsb promo"  title="Tarifa Promo">
                       <span class="fa fa-tag fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                     @endif

                     {{-- Cortesia --}}
                      @if($k["tarifa"] == 0)
                        <div class="icon_rsb cortesia"  title="Tarifa Promo">
                        <span class="fa fa-gift fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                      @endif

                    {{-- Entran el dia de hoy --}}
                     @if($diactual==$k["diaentrada"]  && $k["activo"] == 1)
                       <div class="icon_rsb checkint"  title="Hoy es el Check in">
                       <span class="fa fa-clock-o fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                     @endif
                   </div>
                @endif

                {{--Estadia--}}
               @if($k["tipo"] == 1)
                <div class="titulo_rsb estadia"><div style="margin-bottom:0.2em;">Estadía # {{$k["numero"]}}</div>
                 {{-- Si es un grupo --}}
                 @if($k["grupo"] > 1)
                    <div class="icon_rsb group" title="Grupo">
                    <span class="fa fa-users fa-1x float-right" style="color:#fff;" aria-hidden="true"></span></div>
                 @endif

                 {{-- Promoción --}}
                  @if($k["nombretar"] != "Rack" && ($k["tarifa"] != 0))
                    <div class="icon_rsb promo"  title="Tarifa Promo">
                    <span class="fa fa-tag fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                  @endif

                  {{-- Cortesia --}}
                   @if($k["tarifa"] == 0)
                     <div class="icon_rsb cortesia"  title="Cortesia">
                     <span class="fa fa-gift fa-lg float-right" style="color:#fff;" aria-hidden="true"></span></div>
                   @endif

                  {{--Estadia Walking --}}
                  @if(empty($k["walking"]))
                    <div class="icon_rsb walking"  title="Walking">
                    <span class="fa fa-calendar-check-o fa-1x float-right" style="color:#fff;" aria-hidden="true"></span></div>
                  @endif

                @endif

            <div style="padding:1em 6em; margin-bottom:1em; background-color:#333333"></div>


          @endif
        @endforeach

    </td>

    @endforeach

</tr>


@endforeach
@endforeach



</table>

@endsection
