<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Inicio</th>
  <th>Fin</th>
  <th>Numero de Hab.</th>
  <th>Razon</th>
  <th>Comentario</th>
  <th>Acciones</th>
  <th></th>
</thead>

@foreach($bloqueo as $h)
  <tr>
    <td>{{ $h->id }}</td>

        <td>{{$h->fechainicio}}</td>

        <td>{{$h->fechafin}}</td>

        <td>{{$h->habitacione->numero}}</td>

        <td>{{$h->razonbloqueo->nombre}}</td>

        <td>{{$h->comentario}}</td>

    <td>
      <a href="<?php echo  url('/');?>/bloqueos/{{ $h->id }}/edit" class="btn btn-primary" title="Modificar">
       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
      </a>

      <a href="#" class="btn btn-danger" title="Dar de baja">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>

    </td>
  </tr>
@endforeach

</table>
