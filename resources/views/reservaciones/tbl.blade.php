<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Entrada</th>
  <th>Salida</th>
  <th>Numero de Hab.</th>
  <th>Acciones</th>
  <th></th>
</thead>

@foreach($reserva as $h)
  <tr>
    <td>{{ $h->id }}</td>

        <td>
          @foreach($h->reservacionhabitaciones as $rh)
            @if($rh->cancelada == 0)
              {{$rh->fechaentrada}}<br/>
            @endif
          @endforeach
        </td>

        <td>
          @foreach($h->reservacionhabitaciones as $rh)
            @if($rh->cancelada == 0)
              {{$rh->fechasalida}}<br/>
            @endif
          @endforeach
        </td>
        <td>
          @foreach($h->reservacionhabitaciones as $rh)
            @if($rh->cancelada == 0)
              {{$rh->habitacione->numero}} ({{$rh->habitacione->habitaciontipo->nombre}}) <br/>
            @endif
          @endforeach
        </td>

    <td>
      <a href="reservaciones/{{ $h->id }}/show" class="btn btn-primary" title="Ver">
      <span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>

      @foreach($h->reservacionhabitaciones as $rh)
          @if($datetoday <= $rh->fechaentrada)
            <a href="/reservaciones/{{$h->id}}/createadicional" class="btn btn-success" title="Agregar Habitacion a la Reserva">
            <span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>
          @else
             <form class="form-horizontal" role="form" method="POST" action="{{ route('reservaciones.noshow', $h->id ) }}" enctype="multipart/form-data"
                onsubmit="return confirm('¿Está seguro de No show?')">
               <input name="_method" type="hidden" value="PUT">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-warning" title="No Show">
                  <span class="fa fa-bell-slash" aria-hidden="true"></span>
                </button>
             </form>

          @endif
          @if($datetoday == $rh->fechaentrada)
            <a href="/reservaciones/{{$h->id}}/estadia" class="btn btn-purple" title="Pasar a Estadía">
            <span class="glyphicon glyphicon-bell" aria-hidden="true"></span></a>
          @endif
         @break

      @endforeach

    </td>
  </tr>
@endforeach

</table>
