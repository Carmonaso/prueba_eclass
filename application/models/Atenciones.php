<?php
class Atenciones extends CI_Model{
	

	function __construct()
	{
		parent::__construct();
	}



	//Función para agregar los datos de las atenciones llegadas desde un archivo CSV.
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

	// Función para agregar los datos de las atenciones  por lotes. 
	function  insert_atenciones_batch($array){

		$this->db->insert_batch('atenciones',$array);	
	}
	


	// Elimina todos los registros de la tabla atenciones.
	function delete_all_atenciones(){
		$sql = "DELETE FROM atenciones";
		$this->db->query($sql);
	}


	


	function get_años_disponibles(){
		$sql = "SELECT YEAR(fecha) as año FROM atenciones GROUP BY (año)";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
	      return $query->result_array();
	    }
	    return array();
	}




	// Considerando un mes en particular, se obtiene los contactos realizados, los días trabajados y los productos atendidos.
	// Solicitada en la Vista 1
	function get_detalle_atenciones_mes($mes=0){

		$this->db->select('id_coordinadora_crm, count(id_contacto_crm)  AS contactos_realizados, count(DISTINCT DAY(fecha))  AS dias_trabajados,count(DISTINCT id_producto_agrupador) as productos_atendidos');
		
		$this->db->where('MONTH(fecha)',$mes);
		$this->db->where('deleted',0);

		$this->db->group_by("id_coordinadora_crm");

		$query = $this->db->get('atenciones');

		
		if($query->num_rows() > 0){
		    return $query->result_array();
		}
		return array();
	}


	function get_cantidad_asociadas_productos_atenciones(){
		$this->db->select('id_producto_agrupador, count(DISTINCT id_coordinadora_crm)  AS cantidad_coordinadoras, count(id_contacto_crm)  AS cantidad_contactos');
		$this->db->where('deleted',0);
		$this->db->group_by("id_producto_agrupador");
		$query = $this->db->get('atenciones');

		if($query->num_rows() > 0){
		    return $query->result_array();
		}
		return array();
	}

}
?>
