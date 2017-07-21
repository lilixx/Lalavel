<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Nombre</th>
  <th>Tarifa Inicial</th>
  <th>Imagen</th>
  <th></th>
</thead>

@foreach($habtipo as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      {{ $n->nombre }}
    </td>
    <td>
      {{ $n->tarifainicial }}
    </td>
    <td>
       @if (!empty($n->urlimg))
        <img src="imgHabitaciones/{{ $n->urlimg }}" class="img-responsive" alt="Responsive image" style="max-width: 100px;">
       @endif
    </td>
    <td>

      <a href="<?php echo  url('/');?>/habitaciontipos/{{ $n->id }}/edit" class="btn btn-primary" title="Modificar">
       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
      </a>

      <a href="#" class="btn btn-danger" title="Dar de baja">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>

    </td>
  </tr>
@endforeach

</table>
