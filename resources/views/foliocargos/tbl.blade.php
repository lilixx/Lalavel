<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Recepcionista</th>
  <th>Nombre del Cliente o Huesped</th>
  <th>Cargo</th>
  <th>Comentario</th>
  <th></th>
</thead>

@foreach($foliocargo as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td></td>
    <td>

    </td>
    <td>
      {{ $n->servicio->nombreservicio }} ({{ $n->cantidad }})
    </td>
    <td>
      {{ $n->comentariocubeta }}
    </td>
    <td>

      <form class="form-horizontal" role="form" method="POST" action="{{route('foliocargos.update', $n->id)}}" enctype="multipart/form-data">
       <input name="_method" type="hidden" value="PUT">
       {{ csrf_field() }}
       <input type="hidden" name="activo" value="0">
        <button type="submit" class="btn btn-warning">
          <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
        </button>
     </form>


    </td>
  </tr>
@endforeach

</table>
