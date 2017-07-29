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
        {{$rh->fechaentrada}}<br/>
      @endforeach
    </td>

    <td>
      @foreach($h->reservacionhabitaciones as $rh)
        {{$rh->fechasalida}}<br/>
      @endforeach
    </td>
    <td>
      @foreach($h->reservacionhabitaciones as $rh)
        {{$rh->habitacione->numero}} ({{$rh->habitacione->habitaciontipo->nombre}}) <br/>
      @endforeach
    </td>

    <td>
      <a href="reservaciones/{{ $h->id }}/show" class="btn btn-primary" title="Ver">
      <span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>

      <a href="/reservaciones/{{$h->id}}/createadicional" class="btn btn-success" title="Agregar Habitacion a la Reserva">
      <span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>

      <a href="/reservaciones/{{$h->id}}/estadia" class="btn btn-purple" title="Pasar a Estadía">
      <span class="glyphicon glyphicon-bell" aria-hidden="true"></span></a>

      <a href="#" class="btn btn-danger" title="Dar de baja">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>

    </td>
  </tr>
@endforeach

</table>
