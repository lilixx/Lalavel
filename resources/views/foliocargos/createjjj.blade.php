

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
   src="https://code.jquery.com/jquery-3.2.1.min.js"
   integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
   crossorigin="anonymous"></script>

   <script
     src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
     integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
     crossorigin="anonymous"></script>

<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" />

 <h1 class="titulo folio"> Cargos al Folio </h1>




    <input type="hidden" name="folio_id" value="{{$folioid}}">


    <div class="input_fields_wrap">
      <div class="col-lg-12">
        <button id="AddMore" class="add_field_button btn btn-primary" type="button">  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Cargo</button>
      </div>

        <div class="col-lg-5">
           <div class="form-group">
              <label for="titulo" class="col-sm-4 control-label">Nombre</label>
              <div class="col-sm-8">
              <div><input id="cargo" type="text" class="form-control" name="cargo[]"></div>
          </div>
         </div>
      </div>

      <div class="col-lg-3">
         <div class="form-group">
           <label for="titulo" class="col-sm-4 control-label">Cantidad</label>
           <div class="col-sm-8">
              <input v-model="find.value" type="number" class="form-control" name="cantidad[]"  placeholder="Cantidad" value="cantidad">
          </div>
         </div>
       </div>

       <div class="col-lg-3">
          <div class="form-group">
             <label for="titulo" class="col-sm-4 control-label">Descuento</label>
             <div class="col-sm-8">
               <select v-model="find.value3" id="descuento_id"  class="form-control input-sm" name="descuento_id[]" value="descuento_id">
               <option value="0" selected="true" disabled="true">Descuento</option>
                 @foreach ($descuento as $desc)
                   <option value="{{$desc->id}}">{{ $desc->porcentaje}}%</option>
                @endforeach
              </select>
            </div>
           </div>
        </div>


    </div>

  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
  </div>

  </form>



<script type="text/javascript">
var path = "{{ route('autocomplete') }}";
bindAutoComplete('form-control');
var max_fields      = 10; //maximum input boxes allowed
  var wrapper         = $(".input_fields_wrap"); //Fields wrapper
  var add_button      = $(".add_field_button"); //Add button ID
  var ini = '<span>';
  var ca = '</span';
  var content = $('#content');


  var x = 1; //initlal text box count
  $(add_button).click(function(e){ //on add input button click
      e.preventDefault();
      if(x < max_fields){ //max input box allowed
          x++; //text box increment
          $(wrapper).append('<div><input id="cargo" class="form-control" type="text" name="cargo[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
          bindAutoComplete('form-control');

      }
  });

  $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
      e.preventDefault(); $(this).parent('div').remove(); x--;
  })

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
                            /*  category =  element.id + '<br>' + element.name;
                              return content.append(category);*/

                              return element.name + ' (' + "cond."+ element.id + ')';

                              //  element.setAttribute('span')
                            }))


                        }
                        else {
                            //response([{ label: 'No Existe' }]);
                            alert("No Existe");
                          //  $("#cargo").val('');
                        }
                    }
               }
          })
      },
    /*  focus : function(event, ui) {
               $("#MessageTo").val(ui.item.id);
              // return false;
           },
      select: function(event, ui) {
           $("#MessageTo").val(ui.item.id);
           //return false;
      } */
 });

}

</script>

@endsection
