<?php
 use Illuminate\Support\Facades\Input; ?>
<!--vue -->
<script src="{{asset('js/vue.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
<script src="{{asset('js/vue-resource.min.js')}}"></script>

<!-- Jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.8.14/themes/smoothness/jquery-ui.css">

<!-- Datepicker Files -->
<link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker3.css')}}">
<link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker.standalone.css')}}">

<!-- Languaje -->
<script src="{{asset('datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>



<link href="/css/step.css" rel="stylesheet">
@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


<meta name="csrf-token" content="{{ csrf_token() }}">
 <h1 class="titulo estadia"> Agregar Húesped a la Estadía </h1>


  <div class="content">

         <form class="form-horizontal" role="form" method="POST" action="{{ url('estadiaentidadadd') }}" enctype="multipart/form-data">
             {{ csrf_field() }}


        <div class="col-lg-12">



          <!--  end true -->


             <div class="col-lg-5">
               <div class="form-group">
                <label for="titulo" class="col-sm-4 control-label">Nombres</label>
                  <div class="col-sm-8">
                      <input  type="text" class="form-control" name="nombres"  placeholder="Ingrese los nombres">
                    </div>
                  </div>
               </div>

               <input type="hidden" name="estadia_habitacione_id" value="{{$id}}">



               <div class="col-lg-6">
                  <label for="titulo" class="col-sm-4 control-label">Apellidos</label>
                    <div class="col-sm-8">
                       <input type="text" class="form-control" name="apellidos"  placeholder="Ingrese los apellidos">
                    </div>
                </div>


          </div>


          <div class="col-sm-4" style="float:right;">
            <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
             <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
          </div>





                  </form>

      </div>



@endsection
