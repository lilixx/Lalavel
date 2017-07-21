<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Nombre</th>
  <th>Valor</th>
  <th>Tipo Hab.</th>
  <th></th>
</thead>

@foreach($tarifa as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      {{ $n->nombre }}
    </td>
    <td>
      ${{ $n->valor }}
    </td>
    <td>
    @if (!empty($n->habitaciontipo->nombre))
      {{$n->habitaciontipo->nombre}}
    @endif
    </td>
    <td>
      <a href="<?php echo  url('/');?>/categorias/{{ $n->id }}/edit" class="btn btn-primary" title="Modificar">
       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
      </a>
      <a href="#" class="btn btn-danger" title="Dar de baja">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
    </td>

  </tr>
@endforeach

</table>
