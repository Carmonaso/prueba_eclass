<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	// Carga la página principal. 
	public function index()
	{	

		$this->load->helper('form');
		$this->load->model('atenciones');
		$data['cantidad_datos'] = $this->atenciones->get_all_rows();	
		$this->load->view('inicio',$data);
	}


	// Carga los datos del archivo CSV a la base de datos prueba_eclass. 
	public function  importar(){

		//Cargar librería upload con los siguientes parámetros
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'csv';
		$config['max_size'] = '1000000000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);	

		//Cargar modelo atenciones
		$this->load->model('atenciones');
		

		
		$filename = $_FILES['archivo_csv']['name'];	
		// En el caso  que se suba un archivo repetido se elimina el anterior. 
		if (!empty($filename)) {
			if (file_exists('./uploads/'.$filename)){
				unlink('./uploads/'.$filename);
			}	
		}
			
		// Se sube el archivo CSV
		 if (!$this->upload->do_upload('archivo_csv'))
        {
        	$error = array('error' => $this->upload->display_errors());
            //$this->load->view('debug', $error);
            //var_dump($error);
        }

        else{

        	// Se eliminan todos los registros anteroriores de la tabla atenciones.
        	$this->atenciones->delete_all_atenciones();

        	// Se lee el archivo subido y se agregan a la base de datos.
        	$handle = fopen('./uploads/'.$filename, "r");	
   	

        	//Variables para controlar cantidad de datos que van al batch para insertar.
        	$data_batch = array();
        	$limitador_batch = 100000;


        	// Se lee cada registro del archivo CSV.

        	// Se agrega esta linea para leer 
        	$flag_first = true;
        	while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
             {
             	if ($flag_first){
             		$flag_first = false;
             		continue;
             	}

             	// code  por si se desea agregar los registros por medio de batchs---
		        array_push($data_batch,array(
					'id' => $data[0],
					'fecha' => $data[1],
					'id_forma_ingreso' => $data[2],
					'id_contacto_crm' => $data[3],
					'id_coordinadora_crm' => $data[4],
					'id_producto_agrupador' => $data[5],
					'id_oficina_comercial_crm' => $data[6],
					'deleted' => $data[7],
					));


		        // Se agrega este limitador ya que agregar todos los registros en un lote genera desborde de memoria permitida en php. 
                if (count($data_batch) > $limitador_batch){
                	$this->atenciones->insert_atenciones_batch($data_batch);
             		$data_batch = array();
             	}



             	//code por si se desea insertar los registros unitariamente----

             	// //insert_atenciones($id,$fecha,$id_forma_ingreso,$id_contacto_crm,$id_coordinadora_crm,$id_producto_agrupador,$id_oficina_comercial_crm,$deleted)
                //$this->atenciones->insertar_atenciones($data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$data[6],$data[7]);




             }

             if (count($data_batch) > 0){
                	$this->atenciones->insert_atenciones_batch($data_batch);
             		$data_batch = array();
             }
        }

		$data['cantidad_datos'] = $this->atenciones->get_all_rows();	
		$this->load->view('inicio',$data);
	}


	// Carga y procesa los datos para generar  la vista referente  a la calificación de empleados.

	/*Para observar qué coordinadora es mejor, se propusieron 3 criterios:
			Criterio 1: Cantidad de atenciones realizadas en el mes.
			Criterio 2: Cantidad de atenciones realizadas en promedio considerando los días trabajados.
			Criterio 3: Cantidad de atenciones realizadas en promedio considerando los productos atendidos.*/
	public function calificacion_empleados(){
		$this->load->model('atenciones');
		$criterios = array(1,2,3);

		//Se agrega a la  variable $atenciones, la información del mejor y peor registro considerando  los 3 criterios.
		foreach ($criterios as $criterio) {
			for ($i = 1; $i <= 12; $i++){
				$atenciones[$i] = $this->atenciones->get_detalle_atenciones_mes($i,$criterio);
			}
			$data['atenciones'][$criterio] = $atenciones;
			
		}

		$data['meses'] = $this->atenciones->get_meses_maximos();
		$this->load->view('vista_1',$data);
	}




	// Carga y procesa los datos para generar la vista referente a la relación entre cantidad de atenciones y cantidad de  coordinadoras. 
	public function coordinadoras_asignadas_cantidad(){
		$this->load->model('atenciones');
		$data['registros'] = $this->atenciones->get_cantidad_asociadas_productos_atenciones();
		$this->load->view('vista_2',$data);
	}



}
?>
