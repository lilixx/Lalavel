<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Nombre</th>
  <th>Pais</th>

  <th></th>
</thead>

@foreach($cliente as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      {{ $n->nombres }} {{ $n->apellidos }}
    </td>
    <td>
      {{ $n->nombre }}
    </td>


    <td>
      <a href="clientes/{{ $n->id }}/show" class="btn btn-primary" title="Ver">
      <span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>

      <a href="#" class="btn btn-danger" title="Dar de baja">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>

    </td>

  </tr>
@endforeach

</table>
