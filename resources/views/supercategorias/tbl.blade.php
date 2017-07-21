<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Nombre</th>
  <th></th>
</thead>

@foreach($supercategoria as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      {{ $n->nombre }}
    </td>
    <td>
      <a href="<?php echo  url('/');?>/supercategorias/{{ $n->id }}/edit" class="btn btn-primary" title="Modificar">
       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
      </a>

      <a href="#" class="btn btn-danger" title="Dar de baja">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>

    </td>
  </tr>
@endforeach

</table>
