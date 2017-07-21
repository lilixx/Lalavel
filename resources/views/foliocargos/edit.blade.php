@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('emailhuespede.update', $emailhuespede->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

 <div class="form-group">
   <label for="titulo" class="col-sm-2 control-label">Tipo de Correo</label>
   <div class="col-sm-10">
     <select class="form-control input-sm" name="tipoemail_id" value="tipoemail_id">
      @foreach ($tipoemail as $tm)
        <option value="{{$tm->id}}"  @if($tm->id==$emailhuespede->tipoemail_id)
                selected='selected' @endif>{{ $tm->nombre}}</option>
      @endforeach
    </select>
   </div>
 </div>

 <div class="form-group">
   <label for="titulo" class="col-sm-2 control-label">Email</label>
   <div class="col-sm-10">
       <input  type="text" class="form-control" name="email" value="{{ $emailhuespede->email }}">
   </div>
 </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-warning">Modificar</button>
    </div>
  </div>

</form>

@endsection
