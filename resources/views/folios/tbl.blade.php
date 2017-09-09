<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Nombre</th>
  <th>Habitaciones</th>
  <th>Folio extras</th>
  <th>Acciones</th>
  <th></th>
</thead>

@foreach($folio as $h)
  <tr>
    <td>{{ $h->id }}</td>
    <td>
     {{$h->nombres}} {{$h->apellidos}}

    {{-- {{ $h->entidadrole->entidade->nombres}} {{ $h->entidadrole->entidade->apellidos }} --}}
    </td>
    <td>
      @foreach($habitaciones as $hb)
        @if ($h->estadia_id == $hb->estadia->id)
          {{$hb->habitacione->numero}},
        @endif
      @endforeach
    </td>
    <td>
      @foreach($foliohijo as $fl)
        @if ($h->id == $fl->foliopadre_id)
            <a href="folios/{{ $fl->id }}/show">
              {{$fl->nombres}} {{$fl->apellidos}}
              {{-- {{ $fl->entidadrole->entidade->nombres }} {{ $fl->entidadrole->entidade->apellidos }} --}} </a>
        @endif
      @endforeach
    </td>
    <td>
      <a href="folios/{{ $h->id }}/show" class="btn btn-primary" title="Ver">
      <span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>

      <a href="folios/{{ $h->id }}/showstatus" class="btn btn-warning" title="Estado de Cuenta">
      <span class="fa fa-star-half-o" aria-hidden="true"></span></a>

      <a href="folios/{{ $h->id }}/showinvoice" class="btn btn-danger" title="Factura">
      <span class="fa fa-print" aria-hidden="true"></span></a>


    </td>
  </tr>
@endforeach

</table>
