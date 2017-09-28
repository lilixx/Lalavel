<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
<dropdown>
  <input id="toggle1" type="checkbox" checked>
  <label for="toggle1" class="animate">Menú<i class="fa fa-list float-right"></i></label>

  <ul class="animate">

    <a class="m9" href="<?php echo  url('/');?>/reservaciones">
      <li class="animate">
        Reservas<i class="fa fa-address-card float-right"></i>
      </li>
    </a>

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

     <a class="m4" href="<?php echo  url('/');?>/folios">
       <li class="animate">
         Folios<i class="fa fa-folder-open float-right"></i>
       </li>
     </a>
    
     <a class="m5" href="<?php echo  url('/');?>/servicios">
       <li class="animate">
          Servicios<i class="fa fa-money float-right"></i>
        </li>
      </a>

      <ul><a class="m5" href="<?php echo  url('/');?>/tasacambios">
         <li class="subm"><i class="fa fa-balance-scale float-right"></i>Tasa de Cambio</li></a>
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
