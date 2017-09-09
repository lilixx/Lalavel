<html>
<head>
  <style>
    body{
      font-family: sans-serif;
    }
    @page {
      margin: 60px 50px;
    }
    header { position: fixed;
      left: 0px;
      top: -160px;
      right: 0px;
      height: 100px;
      background-color: #fff;
      text-align: center;
      height:4cm;
    }
    header h1{
      margin: 10px 0;
    }
    header h2{
      margin: 0 0 10px 0;
    }
    div#content{
      margin-left: 2.5cm;
      margin-top:0.7cm;
      line-height:0.35cm;
    }
    div#content detalle{
      margin-left: 0.5cm!important;
    }
    .detalle{
      left: 0px;
      right: 0px;
      height: 11cm;
      background-color: red;
    }
    .detalle p {
      margin-left:0.6cm;
    }
    p.pago{
      padding-right:2em;
      text-align:right;
      line-height:0.3cm;
      font-size: 14px;
    }

    .col_pago{
      float:right;
      width:40%;
    }

    .col_tasa{
      float:left;
      width:50%;
      margin-top:2.2cm;
      padding-left:17.4em;
    }

    p.pago.iva{
      margin-top:1em!important;
    }

    p.punto{
      line-height: 0;
      color:rgba(0,0,0,0);
    }

    .col1_of_4{
      width:2.3cm;
      float: left;
    }
    .col2_of_4{
      width:2.5cm;
      float: left;
    }
    .col3_of_4{
      width:8.2cm;
      float: left;
    }
    .col4_of_4{
      width:3.7cm;
      float: left;
    }
    footer {
      position: fixed;
      background-color: red;
      left: 0px;
      bottom: -50px;
      right: 0px;
      height: 10px;
      border-bottom: 2px solid #ff;
    }
    footer .page:after {
      content: counter(page);
    }
    footer table {
      width: 50%;
    }
    footer p {
      text-align: right;
    }
    footer .izq {
      text-align: left;
    }
    .tg{
      border-collapse:collapse;
      border-spacing:0;
    }
    .tg td {
      font-family:Arial, sans-serif;
      font-size:14px;padding:10px 5px;
      border-style:solid;border-width:0.5px;
      overflow:hidden;word-break:normal;
    }
   .tg th{
     font-family:Arial,
     sans-serif;
     height: 0.3cm;
     font-size:14px;
     font-weight:normal;
     padding:0px 5px;
     border-style:solid;
     border-width:0.5px;
     border-color:#fff;
     overflow:hidden;
     word-break:normal;
   }
   .tg .tg-yw4l{
     vertical-align:top;
   }
   .tg {
     height:14.5cm;
     padding-left:1.8em;
    }
   .tg-yw4l.four{
     text-align:right;

   }

.one{width:3.3cm; line-height: 0.25cm;}
.two{width:2.2cm; line-height: 0.25cm;}
.one{width:3.3cm; line-height: 0.25cm;}
.three{width:9.6cm; line-height: 0.25cm;}
.four{width:3.5cm; line-height: 0.25cm;}

  </style>
<body>
  <header>

  </header>
  <input name="_method" type="hidden" value="PUT">
   {{ csrf_field() }}


   <div id="content" class="col1_of_2">
     <p style="padding-left:32em; padding-top:2.5cm;">
       {{$request->fecha}}
     </p>

   </div>


   <div id="content" class="col2_of_2">
    <p style="text-align:left; margin-top:-17cm;">
    {{$request->nombre}}
    </p><p>

    </p>
   </div>

  <div style="clear:both"></div>

  <table class="tg">
    <tr>
      <th class="tg-yw4l one date" style="color:#fff; padding-bottom:3.5em;">FECHA/DATE</th>
      <th class="tg-yw4l three" style="color:#fff;">DESCRIPCION/DESCRIPTION</th>
      <th class="tg-yw4l four" style="color:#fff;">IMPORTE/AMOUNT</th>
    </tr>

   @foreach($request->cargo as $key=> $v)
    <tr>
      <th class="tg-yw4l one" style="padding-top:1em;"></th>
      <th class="tg-yw4l three" style="padding-top:1em;">{{$request->cargo[$key]}}</th>
      <th class="tg-yw4l four" style="padding-top:1em;">C$ {{$request->importe[$key]}}</th>
    </tr>
   @endforeach

  </table>

  <div class="col_pago">
   <p class="pago" style="margin-top:1cm;">C$ {{$request->subtotal}}</p>
   <p class="pago">C$ {{$request->intur}}</p>
   <p class="pago">C$ {{$request->iva}}</p>
   <p class="pago">C$ {{$request->total}}</p>
  </div>

  <div class="col_tasa">
    {{$equivalente}}
  </div>




</body>

</html>
