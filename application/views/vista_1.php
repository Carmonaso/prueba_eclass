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
<div class="container">
  <h1>Vista 1: Mejores y peores coordinadoras por mes</h1>  


<!-- Por cada criterio se hace una tabla distinta. -->
<?php 
  $criterios = array(1,2,3);
  foreach ($criterios as $criterio){
    ?> 


    <div class="container"> 

    <?php

    if ($criterio  == 1){
      ?>  <h3><b>Criterio 1:</b> Cantidad de atenciones realizadas</h3>    <?php
    }
    elseif ($criterio == 2) {
     ?> <h3><b>Criterio 2:</b> Cantidad de atenciones realizadas en promedio considerando días trabajados</h3>    <?php 
    }

    elseif ($criterio == 3) {
      ?> <h3><b>Criterio 3:</b> Cantidad de atenciones realizadas en promedio considerando productos atendidos</h3>    <?php 
    }



    ?>
    <table class="table">
    <thead>
      <tr>
        <th>Calificación</th>

        <?php foreach ($meses as $mes) {
          if ($mes['mes']==1){
            ?>  <th>Enero</th> <?php    
          }

          elseif ($mes['mes']==2) {
            ?> <th>Febrero</th>   <?php
          }


          elseif ($mes['mes']==3) {
            ?> <th>Marzo</th>   <?php
          }
          
          elseif ($mes['mes']==4) {
            ?><th>Abril</th>   <?php
          }

          elseif ($mes['mes']==5) {
            ?><th>Mayo</th>   <?php
          }

          elseif ($mes['mes']==6) {
            ?><th>Junio</th>   <?php
          }

          elseif ($mes['mes']==7) {
            ?><th>Julio</th>   <?php
          }

          elseif ($mes['mes']==8) {
            ?><th>Agosto</th>   <?php
          }

          elseif ($mes['mes']==9) {
            ?><th>Septiembre</th>   <?php
          }

          elseif ($mes['mes']==10) {
            ?><th>Octubre</th>   <?php
          }

          elseif ($mes['mes']==11) {
            ?><th>Noviembre</th>   <?php
          }

          elseif ($mes['mes']==12) {
            ?><th>Diciembre</th>   <?php
          }
        } ?>
        
      </tr>
    </thead>



    <!-- La variable $atenciones contiene el TOP 1 y el último registro considerando la cantidad de atenciones realizadas según el criterio
         estructura atenciones[criterio][mes][0/1], 0 índica el mejor registro y 1 índica el peor registro. -->

    <tbody>
    <tr>
      <td class="success"><b> ID Mejor  Coordinadora</b> </td>
      <?php for($i=1; $i<=12; $i++){
        if (!empty($atenciones[$criterio][$i])){?>
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
        if (!empty($atenciones[$criterio][$i])){?>
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




</div>



<!-- Para observar qué coordinadora es mejor, se propusieron 3 criterios:
Criterio 1: Cantidad de atenciones realizadas en el mes.
Criterio 2: Cantidad de atenciones realizadas en promedio considerando los días trabajados.
Criterio 3: Cantidad de atenciones realizadas en promedio considerando los productos atendidos.
-->



 </body>
</html>


