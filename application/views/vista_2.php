<?php $this->load->helper('url'); ?>
<?php echo form_open_multipart('inicio/importar');?>

<!DOCTYPE html>

<head>


  <script src="/js/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <script src="/js/bootstrap.min.js"></script>
  <script src="/dist/Chart.js"></script>


<!-- Para observar si existe una relación proporcional entre la cantidad de coordinadoras y cantidad de atenciones,
  se proponen 3 métodos de visualización.
  El primer método es una tabla donde resume el ID del producto, Cantidad de coordinadoras y cantidad de atenciones.
  El segundo método es un gráfico lineal que  muestra la relación entre la cantidad de atenciones v/s la cantida de coordinadoras.
  El tercer método es un bubble chart que muestra los productos y la cantidad de coordinadoras. El tamaño de las burbujas índica una relación de la cantidad de atenciones.
 -->
  



<!--Código para observara la tabla -->
  <div class="container"> 
  <h1>Vista 2: Coordinadoras asignadas y cantidad de atenciones</h1>
  <h3> Datos en tabla </h3>
  <table class="table">
    <thead>
      <tr>
        <th>ID producto agrupador</th>
        <th>Cantidad coordinadoras asignadas</th>
        <th>Cantidad de atenciones</th>

      </tr>
    </thead>

    <tbody>

   <?php foreach ($registros as $registro) {

    ?> <tr> <?php
    foreach ($registro as $elemento) {
      ?>  <td> <?php echo $elemento; ?>  </td><?php 
    }
    ?> </tr> <?php
        
    } ?>

    </tbody>
    </table>
</div>


<!--Contenedor del gráfico de Linea -->

<div class="container"> 
  <h3> Gráfico de Linea</h3>
  <canvas id="LineChart"></canvas>

<!--Contenedor del gráfico de Burbuja -->
<div class="container"> 
  <h3> Gráfico de Burbujas</h3>
  <canvas id="BubbleChart"></canvas>









<script>
  

  var datasets_array  = <?php echo json_encode($registros); ?>;
  var array_datasets_array = datasets_array.length;



  //
  data_bubble=[];
  data_line = [];
  for (var i = 0; i < array_datasets_array; i++){
    data_line.push({x:datasets_array[i]['cantidad_contactos'],y:datasets_array[i]['cantidad_coordinadoras']});
    data_bubble.push({x:datasets_array[i]['id_producto_agrupador'], r:datasets_array[i]['cantidad_contactos']/1000, y:datasets_array[i]['cantidad_coordinadoras']});
  }


  // Configuración para el gráfico de  linea.
  var ctx = document.getElementById("LineChart");
  var LineChart = new Chart(ctx, {
      type: 'line',
      data: {
          datasets: [{
              label: 'Cantidad de coordinadoras',
              data: data_line,
              fill:false,
              borderColor: "rgba(193,46,12,1)",
          }]
      },
      options: {
          title:{
            display:false,
            text:'Relación entre cantidad de atenciones y cantidad de coordinadoras'
          },
          scales: {
              xAxes: [{
                  type: 'linear',
                  position: 'bottom',
                  scaleLabel:{
                    display: true,
                    labelString: "Cantidad de atenciones"
                  }
              }],
              yAxes: [{
                  type: 'linear',
                  position: 'bottom',
                  scaleLabel:{
                    display: true,
                    labelString: "Cantidad de coordinadoras"
                  }
              }]
          }
      }
  });



  // Configuración para el gráfico de  burbuja.
  var ctx = document.getElementById("BubbleChart");
  var BubbleChart = new Chart(ctx, {
      type: 'bubble',
      data: {
          datasets: [{
              label: 'Producto',
              backgroundColor: "rgba(193,46,12,0.2)",
              borderColor: "rgba(193,46,12,1)",
              data: data_bubble
          }]
      },
      options: {
          title:{
            display:false,
            text:'Cantidad de atenciones por producto'
          },
          scales: {
              xAxes: [{
                  type: 'linear',
                  position: 'bottom',
                  scaleLabel:{
                    display: true,
                    labelString: "Producto agrupador"
                  }
              }],
              yAxes: [{
                  type: 'linear',
                  position: 'bottom',
                  scaleLabel:{
                    display: true,
                    labelString: "Cantidad de coordinadoras"
                  }
              }]
          }
      }
  });






</script>






</head>








