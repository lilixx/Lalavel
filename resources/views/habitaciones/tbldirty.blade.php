<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Área</th>
  <th>Número de Habitación</th>
  <th>Tipo</th>
  <th>Acciones</th>
</thead>

@foreach($habitacione as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>{{ $n->habitacionarea->nombre }}</td>

    <td>
      {{ $n->numero }}
    </td>
    <td>
      {{ $n->habitaciontipo->nombre }}
    </td>
    <td>

      <form class="form-horizontal" role="form" method="POST" action="{{route('habitaciones.update', $n->id)}}" enctype="multipart/form-data">
       <input name="_method" type="hidden" value="PUT">
       {{ csrf_field() }}
       <input type="hidden" name="limpia" value="1">
        <button type="submit" class="btn btn-purple" title="pasar a limpia">
          <span class="fa fa-magic fa-lg" aria-hidden="true"></span>
        </button>
     </form>


    </td>
  </tr>
@endforeach

</table>
