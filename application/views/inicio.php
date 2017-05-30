<?php $this->load->helper('url'); ?>
<?php echo form_open_multipart('inicio/importar');?>


<!DOCTYPE html>

<head>
	<script src="/js/jquery-3.2.1.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 

</head>

	<body>
	
  		
	<div class="container">
  		<h1>Prueba Técnica eClass</h1>  
  		<div class="panel-body">
    	</div>



    	<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#herramientas">Herramientas</button>
    	<div id="herramientas" class="collapse">
		    <ul>
			  <li>Framework MVC CodeIgniter 3.1.4 </li>
			  <li>PHP  7.0 </li>
			  <li>Bootstrap </li>
			  <li>MySql</li>
			  <li>Chart.js</li>
			</ul> 
		</div>


		<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#configuracion">Configuración</button>
    	<div id="configuracion" class="collapse">
		    <ul>
			  <li>PHP:  <i>php/7.0/apache2/conf.d/php.ini</i>: Las variables <b>post_max_size</b> y <b>upload_max_filesize</b> poseen un valor de 50M. </li>
			  <li>MySql:
					<ul><li> <b>Usuario</b>: prueba_eclass    &nbsp;&nbsp;    	<b>Password</b>:"" (vacío)</li>
						<li> Base de datos: prueba_eclass </li>
						<li> Tabla: atenciones

						<ul>
							<li>id (int) Clave Primaria</li>
							<li>fecha (date)</li>
							<li>id_forma_ingreso (int)</li>
							<li>id_contacto_crm (int)</li>
							<li>id_coordinadora_crm (int)</li>
							<li>id_producto_agrupador (int)</li>
							<li>id_oficina_comercial_crm (int)</li>
							<li>deleted (bool)</li>
						</ul>
						</li>

					</ul>
			  </li>

			  <li>La carpeta <b>uploads</b> posee permisos necesarios para subir y eliminar archivos.</li>
			</ul> 
		</div>

		
		<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#suposiciones">Suposiciones y Consideraciones</button>
    	<div id="suposiciones" class="collapse">
		    <ul>
		    	<li>Ya existen tablas de las cuales existen los atributos:
		    	<ul>
		    		<li>id_forma_ingreso</li>
					<li>id_contacto_crm</li>
					<li>id_coordinadora_crm</li>
					<li>id_producto_agrupador</li>
					<li>id_oficina_comercial_crm</li>
		    	</ul>

		    	Estríctamente estos atributos deberían ser claves foráneas, pero en esta ocasión se dejarán sólo como INT.


		    	<li> Se considerará como <b>cantidad de atenciones</b> la cantidad de contactos crm únicos asignados a cada id_producto_agrupador.</li>
		    	<li> Se considerará como <b>cantidad de coordinadoras</b> la cantidad de coordinadoras crm únicas asignadas a cada id_producto_agrupador.</li>
		    	<li> Como prueba técnica se dio la facilidad de subir los archivos CSV para sean exportados a la base de datos.</li>
		    	<li> El archivo CSV debe ser otorgado con la misma estructura solicitada (separado con ";"" y con los mismos atributos).</li>



		    </ul>
		</div>


		<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#detalle_tecnico">Detalle Técnico</button>
    	<div id="detalle_tecnico" class="collapse">
    		<ul>
    		<li>Archivos utilizados:
	    		<ul>
				  <li> Modelo: Atenciones.php</li>
				  <li> Controlador: Inicio.php</li>
				  <li> Vistas: inicio.php, vista_1.php, vista_2.php</li>
				</ul> 
    		</li>	

    		<li>Cálculo mejor/peor vendedora:
				<ul>
				  <li> Se calcula la suma y los  promedios a nivel de consulta de base de datos.</li>
				  <li> El detalle de las consultas se encuentra en el modelo Atenciones.php, función: <i>get_detalle_atenciones_mes</i> </li>
				</ul>     			
    		</li>

    		</ul>
		    
		</div>

	</div>


  	<div class="container">
		<h3>Importando archivo CSV</h3>
		<div class="panel panel-default">
    		<div class="panel-body">
    		<ul>
    		<li>Esta sección es para subir archivos CSV. </li>
    		<li>Al momento de subir el archivo, los datos que están en la tabla <b>atenciones</b> son reemplazados por los nuevos datos, es decir, se realiza un DELETE y un INSERT. </li>
    		<li>La operación INSERT es realizada en modalidad de paquétes (insert_batch). </li>
    		<li>Se elige una capacidad máxima de 50MB por archivo para  no desbordar la memoria que permite utilizar PHP. </li>
    		<li> <b>Para poder ingresar a las vistas debe haber al menos 1 registro en la base de datos.</b></li>
    		</ul>
    		</div>
  		</div>

	  	<form action="<?php echo site_url('inicio/importar'); ?>" method='post' enctype="multipart/form-data">
	  	<label>Cantidad de registros actuales: <?php echo $cantidad_datos[0]['cantidad_datos'];?> </label>
		  	<div class="input-group">


	        	<label class="input-group-btn">
	            	<span class="btn btn-primary">
	                    Archivo CSV (máximo 50MB)&hellip; <input type='file'  name='archivo_csv' size='50'>
	                </span>
	            </label>
	        </div> 		
	        <br>
		   	<input type='submit' class="btn btn-primary" name='submit' value='Subir Archivo'>
		</form>
	</div>

	

	<div class="container">
  		<h3>Vista 1: Mejores y peores coordinadoras por mes</h3>
  		<div class="panel panel-default">
    		<div class="panel-body">
    		<ul>
    			<li> Para esta sección se utilizaron  tablas que muestran el ID de la mejor y peor coordinadora dentro de los meses considerando 3 criterios distintos:

	    			<ul>
	    				<li>Criterio 1: Cantidad de atenciones realizadas en el mes.</li>
						<li>Criterio 2: Cantidad de atenciones realizadas en promedio considerando los días trabajados.</li>
						<li>Criterio 3: Cantidad de atenciones realizadas en promedio considerando los productos atendidos.</li>
	    			</ul>
    			</li>

    			<li>Se considera que todos los registros son del mismo año.</li>    		
    			<li>Solamente  se mostrarán los meses que tengan disponibles registros de coordinadoras para ser calificadas.</li>


    			
    		</ul>
    		</div>
  		</div>
  		<form action="<?php echo site_url('inicio/calificacion_empleados'); ?>" method='post' enctype="multipart/form-data">
    		
    		<input class="btn btn-primary" type='submit' name='submit' value='Ver Calificaciones' id="calificaciones">
  		</form>

   	</div>	
  	










  
  	<div class="container">
	  	<h3>Vista 2: Coordinadoras asignadas y  cantidad de atenciones</h1>
	  	<div class="panel-body">
	    		<ul>
	    			<li>Para ayudar a determinar si la cantidad de coordinadoras asociadas a un producto refleja la cantidad de atenciones que se hacen en este producto se crearon 3 tipos de visualizaciones de datos distintas:
	    			<ul>
	    				<li>Tabla de  datos</li>
	    				<li>Gráfico de Linea</li>
	    				<li>Gráfico de Burbujas</li>
	    			</ul>
	    			<li> Se considerará como <b>cantidad de atenciones</b> la cantidad de contactos crm únicos asignados a cada id_producto_agrupador.</li>
		    		<li> Se considerará como <b>cantidad de coordinadoras</b> la cantidad de coordinadoras crm únicas asignadas a cada id_producto_agrupador.</li>

	    			</li>
	    		</ul>
	    </div>

	    
		<form action="<?php echo site_url('inicio/coordinadoras_asignadas_cantidad'); ?>" method='post' enctype="multipart/form-data">
			<input class="btn btn-primary" type='submit' name='submit' value='Ver Gráficos' id="graficos">
		</form>
  	</div>


   


  


  
 </body>
</html>

<style>
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
</style>



<script type="text/javascript">
	var cantidad_datos = <?php echo $cantidad_datos[0]['cantidad_datos'];?>;
	if (cantidad_datos > 0){
		document.getElementById("calificaciones").disabled = false; 
		document.getElementById("graficos").disabled = false;

	}
	else{
		document.getElementById("calificaciones").disabled = true; 
		document.getElementById("graficos").disabled = true; 	
	}
	
</script>
