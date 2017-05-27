<?php
class Atenciones extends CI_Model{
	

	function __construct()
	{
		parent::__construct();
	}



	//Función para agregar los datos de las atenciones llegadas desde un archivo CSV	
	function insert_atenciones($id,$fecha,$id_forma_ingreso,$id_contacto_crm,$id_coordinadora_crm,$id_producto_agrupador,$id_oficina_comercial_crm,$deleted){

		$data = array(
			'id' => $id,
			'fecha' => $fecha,
			'id_forma_ingreso' => $id_forma_ingreso,
			'id_contacto_crm' => $id_contacto_crm,
			'id_coordinadora_crm' => $id_coordinadora_crm,
			'id_producto_agrupador' => $id_producto_agrupador,
			'id_oficina_comercial_crm' => $id_oficina_comercial_crm,
			'deleted' => $deleted,
			);	
		
		$this->db->insert('atenciones',$data);		

	}

	function  insert_atenciones_batch($array){

		$this->db->insert_batch('atenciones',$array);	
	}
	

	function delete_all_atenciones(){
		$sql = "DELETE FROM atenciones";
		$this->db->query($sql);
	}




}
?>
