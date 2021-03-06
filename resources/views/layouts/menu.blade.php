<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
<dropdown>
  <input id="toggle1" type="checkbox" checked>
  <label for="toggle1" class="animate">Menú<i class="fa fa-list float-right"></i></label>

  <ul class="animate">

    <a class="m10" href="<?php echo  url('/');?>/users">
      <li class="animate">
        Usuarios<i class="fa fa-users float-right"></i>
      </li>
    </a>

    <a class="m9" href="<?php echo  url('/');?>/reservaciones">
      <li class="animate">
        Reservas<i class="fa fa-address-card float-right"></i>
      </li>
    </a>

    <a class="m11" href="<?php echo  url('/');?>/bloqueos">
      <li class="animate">
        Bloqueos<i class="fa fa-lock  float-right"></i>
      </li>
    </a>
    <ul><a class="m11" href="<?php echo  url('/');?>/razonbloqueos">
       <li class="subm"><i class="fa fa-unlock-alt float-right"></i>Razón de Bloqueo</li></a>
    </ul>

      <a class="m8" href="<?php echo  url('/');?>/estadias">
        <li class="animate">
          Estadías<i class="fa fa-sign-in float-right fa-3"></i>
        </li>
      </a>

     <a class="m1" href="<?php echo  url('/');?>/huespedes">
       <li class="animate">
         Huéspedes<i class="fa fa-user-circle float-right fa-3"></i>
       </li>
     </a>


     <a class ="m2" href="<?php echo  url('/');?>/clientes">
       <li class="animate">
          Clientes<i class="fa fa-user-circle-o float-right"></i>
       </li>
     </a>

     <a class="m3" href="<?php echo  url('/');?>/habitaciones">
       <li class="animate">
          Habitaciones<i class="fa fa-bed float-right"></i>
       </li>
     </a>
     <ul><a class="m3" href="<?php echo  url('/');?>/month">
        <li class="subm"><i class="fa fa-calendar float-right"></i>Ver el mes</li></a>
     </ul>
     <ul><a class="m3" href="<?php echo  url('/');?>/dirty">
        <li class="subm"><i class="fa fa-recycle float-right"></i>Sucias</li></a>
     </ul>
     <ul><a class="m3" href="<?php echo  url('/');?>/habitaciontipos">
        <li class="subm"><i class="fa fa-bath float-right"></i>Tipos</li></a>
     </ul>
     <ul><a class="m3" href="<?php echo  url('/');?>/habitacionareas">
        <li class="subm"><i class="fa fa-arrows float-right"></i>Areas</li></a>
     </ul>
     <ul><a class="m3" href="<?php echo  url('/');?>/tarifas">
        <li class="subm"><i class="fa fa-usd float-right"></i>Tarifa</li></a>
     </ul>

     <a class="m4" href="<?php echo  url('/');?>/folios">
       <li class="animate">
         Folios<i class="fa fa-folder-open float-right"></i>
       </li>
     </a>
         <ul><a class="m4" href="<?php echo  url('/');?>/foliocargos">
            <li class="subm"><i class="fa fa-archive float-right"></i>Cubeta</li></a>
         </ul>

     <a class="m5" href="<?php echo  url('/');?>/servicios">
       <li class="animate">
          Servicios<i class="fa fa-money float-right"></i>
        </li>
      </a>

      <ul><a class="m5" href="<?php echo  url('/');?>/categorias">
         <li class="subm"><i class="fa fa-outdent float-right"></i>Categorías</li></a>
      </ul>

      <ul><a class="m5" href="<?php echo  url('/');?>/supercategorias">
         <li class="subm"><i class="fa fa-object-ungroup float-right"></i>Super Categorías</li></a>
      </ul>

      <ul><a class="m5" href="<?php echo  url('/');?>/tasacambios">
         <li class="subm"><i class="fa fa-balance-scale float-right"></i>Tasa de Cambio</li></a>
      </ul>

      <ul><a class="m5" href="<?php echo  url('/');?>/descuentos">
         <li class="subm"><i class="fa fa-gift float-right"></i>Descuentos</li></a>
      </ul>

     <a class="m6" href="<?php echo  url('/');?>/categorias">
       <li class="animate">
          Reportes<i class="fa fa-file-text float-right"></i>
        </li>
      </a>

     <a class="m7" href="<?php echo  url('/');?>/paises">
       <li class="animate">
         Países<i class="fa fa-flag float-right"></i>
       </li>
     </a>

  </ul>
</dropdown>
