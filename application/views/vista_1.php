<?php $this->load->helper('url'); ?>
<?php echo form_open_multipart('inicio/importar');?>


<!DOCTYPE html>

<head>
<!-- Se importan módulos necesarios-->
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <script src="/js/jquery-3.2.1.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>

</head>


<body>

<h1>Vista 1: Mejores y peores empleados por mes</h1>


<!-- Para observar qué coordinadora es mejor, se propusieron 3 criterios:
Criterio 1: Cantidad de atenciones realizadas en el mes.
Criterio 2: Cantidad de atenciones realizadas en promedio considerando los días trabajados.
Criterio 3: Cantidad de atenciones realizadas en promedio considerando los productos atendidos.
-->


<!-- Por cada criterio se hace una tabla distinta. -->
<?php 
  $criterios = array(1,2,3);
  foreach ($criterios as $criterio){
    ?> 

    <div class="container"> 

    <?php

    if ($criterio  == 1){
      ?>  <h3>Criterio: Cantidad de atenciones realizadas</h3>    <?php
    }
    elseif ($criterio == 2) {
     ?> <h3>Criterio: Cantidad de atenciones realizadas en promedio considerando días trabajados</h3>    <?php 
    }

    elseif ($criterio == 3) {
      ?> <h3>Criterio: Cantidad de atenciones realizadas en promedio considerando productos atendidos</h3>    <?php 
    }



    ?>



    <table class="table">
    <thead>
      <tr>
        <th>Calificación</th>
        <th>Enero</th>
        <th>Febrero</th>
        <th>Marzo</th>
        <th>Abril</th>
        <th>Mayo</th>
        <th>Junio</th>
        <th>Julio</th>
        <th>Agosto</th>
        <th>Septiembre</th>
        <th>Octubre</th>
        <th>Noviembre</th>
        <th>Diciembre</th>
      </tr>
    </thead>



    <!-- La variable $atenciones contiene el TOP 1 y el último registro considerando la cantidad de atenciones realizadas según el criterio
         estructura atenciones[criterio][mes][0/1], 0 índica el mejor registro y 1 índica el peor registro. -->

    <tbody>
    <tr>
      <td class="success"><b> ID Mejor  Coordinadora</b> </td>
      <?php for($i=1; $i<=12; $i++){
        if (!empty($atenciones[$i])){?>
        <td class="success">  <?php echo  $atenciones[$criterio][$i][0]['id_coordinadora_crm'];?></td>
      <?php }
        else{?>
          <td> - </td>
        <?php }
      }?>
      </tr>
    </tbody>
   

     <tr>
      <td class="danger"><b> ID Peor Coordinadora </b> </td>
      <?php for($i=1; $i<=12; $i++){
        if (!empty($atenciones[$i])){?>
        <td class="danger">  <?php echo  $atenciones[$criterio][$i][1]['id_coordinadora_crm'];?></td>
      <?php }
        else{?>
          <td> - </td>
        <?php }
      }?>
      </tr>  

     </table>
    </div>
    <?php
  }

?>

 </body>
</html>


