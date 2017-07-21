<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Valor</th>
  <th></th>
</thead>

@foreach($descuento as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      {{ $n->porcentaje }}%
    </td>
    <td>
      <a href="<?php echo  url('/');?>/descuentos/{{ $n->id }}/edit" class="btn btn-primary" title="Modificar">
       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
      </a>

      <a href="#" class="btn btn-danger" title="Dar de baja">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>

    </td>
  </tr>
@endforeach

</table>
