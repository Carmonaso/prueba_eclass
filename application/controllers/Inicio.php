<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {


	public function index()
	{	

		$this->load->helper('form');
		$this->load->view('inicio');
	}


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
            $this->load->view('debug', $error);
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
        	while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
             {
             	

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
        }

        
		//$data['name'] =  "Felipe";
		//$this->load->view('debug',$data);
	}
}

?>
