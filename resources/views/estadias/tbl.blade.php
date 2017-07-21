<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Entrada</th>
  <th>Salida</th>
  <th>Numero de Hab.</th>
  <th>Acciones</th>
  <th></th>
</thead>

@foreach($estadia as $h)
  <tr>
    <td>{{ $h->id }}</td>
    <td>
     @foreach($h->estadiahabitaciones as $eh)
       {{$eh->fechaentrada}} <br/>
     @endforeach
    </td>
    <td>
      @foreach($h->estadiahabitaciones as $eh)
        {{$eh->fechasalida}}  <br/>
      @endforeach
    </td>
    <td>
      @foreach($h->estadiahabitaciones as $m)
        {{$m->habitacione->numero}} ({{$m->habitacione->habitaciontipo->nombre}})  <br/>
      @endforeach
    </td>

    <td>
      <a href="estadias/{{ $h->id }}/show" class="btn btn-primary" title="Ver">
      <span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>

      <a href="/estadias/{{$h->id}}/createadicional" class="btn btn-success" title="Agregar Habitacion">
      <span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>

      <a href="#" class="btn btn-danger" title="Dar de baja">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>

    </td>
  </tr>
@endforeach

</table>
