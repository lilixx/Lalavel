@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('foliocargos') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

 <script
   src="https://code.jquery.com/jquery-2.0.2.min.js"
   integrity="sha256-TZWGoHXwgqBP1AF4SZxHIBKzUdtMGk0hCQegiR99itk="
   crossorigin="anonymous"></script>

 <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

 <h1 class="titulo folio"> Cargos al Folio </h1>




    <input type="hidden" name="folio_id" value="{{$folioid}}">

    <table id="maintable" class="order-list">
       <thead>

        </thead>
        <tbody>
            <tr>
               <td style="width: 100%;">
                 <input type="text" class="form-control" name="cargo[]" style="width:300px;">
                 <input type="number" class="form-control" name="cantidad[]"  placeholder="Cantidad" value="cantidad">
                 <select v-model="find.value3" id="descuento_id"  class="form-control" name="descuento_id[]" value="descuento_id">
                   <option value="0" selected="true" disabled="true">Descuento</option>
                     @foreach ($descuento as $desc)
                        <option value="{{$desc->id}}">{{ $desc->porcentaje}}%</option>
                     @endforeach
                 </select>
                 <input type="hidden" id="MessageTo" name="idcargo[]"/>
                 <button id="AddMore" class="ibtnDel btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></button>

               </td>
            </tr>
         </tbody>

  <button id="AddMore" class="btn btn-primary add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Cargo</button>
  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
  </div>

  </form>



<script type="text/javascript">
var path = "{{ route('autocomplete') }}";
var tds = '<tr>';
bindAutoComplete('form-control');
$("#AddMore").click(function () {

    $("#maintable").each(function () {

        var tds = '<tr>';

        jQuery.each($('tr:last td', this), function () {
            tds += '<td>' + $(this).html() + '</td>';
        });
        tds += '</tr>';

        if ($('tbody', this).length > 0) {

            $('tbody', this).append(tds);
            bindAutoComplete('form-control');

        }

        else {
            $(this).append(tds);
            bindAutoComplete('form-control');
        }
    });
});

$("table.order-list").on("click", ".ibtnDel", function () {
      $(this).closest("tr").remove();
});


function bindAutoComplete(classname){
$("."+classname).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: 'http://127.0.0.1:8000/autocomplete',
                type: "GET",
                dataType: "json",
                data: { term: request.term },
                success: function (data) {
                    if (data != null) {
                        if (data.length > 0) {
                            response($.map(data, function (element) {
                                return element.name + ' ('+ "cod." + element.id + ')';

                            }))
                        }
                      /*  else {
                            response([{ label: 'No results found.' }]);
                        } */
                    }
               }
          })
      },
      select: function (event, ui) {
        var name = ui.item.value;
        var v = ui.item.id;
        $("#MessageTo").val(ui.item.id);
       }


 });

}

</script>

@endsection
