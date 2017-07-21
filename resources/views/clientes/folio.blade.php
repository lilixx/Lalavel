@extends('layouts.app')

@section('content')

  <div class="container">
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
          <ul>
          @foreach($folio as $fl)
             <li><strong>Tipo de Folio:</strong> {{ $fl->tipofolio }}
              <a href="{{ route('getEdit', $fl->id) }}">Editar</a>
             <ul>
               @foreach($fl->cargos as $ca)
                 <li>{{ $ca->nombre }}</li>
               @endforeach
             </ul>
           </li>
          @endforeach
        </ul>
          </div>
        </div>
    </div>

@endsection
