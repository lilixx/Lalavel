<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Nombre</th>
  <th>Precio</th>
  <th>Categoría</th>
  <th>Descripción</th>
  <th></th>
</thead>

@foreach($servicio as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      {{ $n->nombreservicio }}
    </td>
    <td>
    $  {{ $n->precio }}
    </td>
    <td>
      {{ $n->categoria->nombre }}
    </td>
    <td>
      {{ $n->descripcion }}
    </td>
    <td>

      <a href="servicios/{{ $n->id }}/edit" class="btn btn-primary" title="Editar">
     <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>

     <a href="#" class="btn btn-danger" title="Dar de baja">
     <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>

    </td>
  </tr>
@endforeach

</table>
