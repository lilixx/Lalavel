<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Valor</th>
  <th></th>
</thead>

@foreach($tasa as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      ${{ $n->valorventa }}
    </td>

  </tr>
@endforeach

</table>
