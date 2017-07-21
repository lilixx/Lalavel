@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('categorias.update', $categoria->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

<h1 class="titulo cargo"> Modificar Categoría </h1>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nombre" value="{{ $categoria->nombre }}">
    </div>
  </div>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Super Categoría</label>
    <div class="col-sm-10">
       <select  id="supercategoria_id" class="form-control input-sm" name="supercategoria_id">
       <option value="0" selected="true" disabled="true">Seleccione una Super Categoría</option>
         @foreach ($supercategoria as $cat)
              <option value="{{ $cat->id }}"  @if($cat->id==$categoria->supercategoria_id)
                      selected='selected' @endif> {{ $cat->nombre }} </option>
         @endforeach
        </select>
     </div>
    </div>

  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
  </div>

</form>

@endsection
