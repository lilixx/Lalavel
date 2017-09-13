<table class="table table-hover">

<thead>
  <th>Numero de Habitación</th>
  <th>Tipo de Habitación</th>
  <th>Disponible</th>
  <th>Limpia</th>
  <th>Acciones</th>
</thead>

@foreach($habitacion as $n)
  <tr>
    <td>{{ $n->numero }}</td>
    <td>
      {{ $n->habitaciontipo->nombre }}
    </td>
    <td> @if ( $n->disponible  == 1) Si @else No @endif </td>
    <td>@if ( $n->limpia  == 1) Si @else No @endif </td>

    <td>

      @foreach (Auth::user()->roles as $rl)
        @if($rl->nombre == 'Admin')
         <a href="habitaciones/{{ $n->id }}/edit" class="btn btn-primary" title="Editar">
          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>

          <a href="#" class="btn btn-danger" title="Dar de baja">
          <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
        @endif
      @endforeach    

    </td>
  </tr>
@endforeach

</table>
