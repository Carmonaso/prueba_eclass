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


	function  get_all_rows(){
		$sql ="SELECT COUNT(*) as cantidad_datos FROM  atenciones";
		$query=$this->db->query($sql);
		if($query->num_rows() > 0){
		   	return $query->result_array();
	    }
	    return array();
	}	


	/*Considerando un mes en particular, se obtiene los contactos realizados, los días trabajados y los productos atendidos.
	Solicitada en la Vista 1.
	Para observar qué coordinadora es mejor, se propusieron 3 criterios:
	Criterio 1: Cantidad de atenciones realizadas en el mes.
	Criterio 2: Cantidad de atenciones realizadas en promedio considerando los días trabajados.
	Criterio 3: Cantidad de atenciones realizadas en promedio considerando los productos atendidos.*/
	function get_detalle_atenciones_mes($mes=0,$criterio=1){

			
		// Por  cada criterio  se realiza una consuta distinta.
		if ($criterio==1){
			$select_criterio = "count(id_contacto_crm)  AS contactos_realizados";
			$order_by_criterio = "contactos_realizados";
		}
		elseif ($criterio==2) {
			$select_criterio = "count(id_contacto_crm)/count(DISTINCT DAY(fecha)) AS promedio_por_dias_trabajados";
			$order_by_criterio = "promedio_por_dias_trabajados";
		}
		elseif ($criterio==3) {
			$select_criterio = "count(id_contacto_crm)/count(DISTINCT id_producto_agrupador) as promedio_por_productos_atendidos";
			$order_by_criterio = "promedio_por_productos_atendidos";
		}



		// Se obtiene el mejor registro considerando criterio.
		$this->db->select('id_coordinadora_crm,'.$select_criterio);
		$this->db->where('MONTH(fecha)',$mes);
		$this->db->where('deleted',0);
		$this->db->limit(1);
		$this->db->group_by("id_coordinadora_crm");


		$result_final  = array();

		$this->db->order_by($order_by_criterio,"asc");
		$query = $this->db->get('atenciones');
		if($query->num_rows() > 0){
		   	$result_final =  $query->result_array();
		}



		// Se obtiene el peor registro considerando criterio.
		$this->db->select('id_coordinadora_crm,'.$select_criterio);
		$this->db->where('MONTH(fecha)',$mes);
		$this->db->where('deleted',0);
		$this->db->limit(1);
		$this->db->group_by("id_coordinadora_crm");
		$this->db->order_by($order_by_criterio,"desc");
		$query = $this->db->get('atenciones');
		if($query->num_rows() > 0){
		   	$result_final =  array_merge($query->result_array(),$result_final);
		}


		// Se devuelve un array que contiene ambos  registros
		// 0 -> Mejor registro
		// 1 -> Peor registro. 
		return $result_final;
	}

		
	
	// Solicitada en la Vista 2.
	/* Se considerará como cantidad de atenciones la cantidad de contactos únicos asignados a cada id_producto_agrupador.
	   Se considerará como cantidad de coordinadoras la cantidad de coordinadoras únicas asignados a cada id_producto_agrupador*/
	function get_cantidad_asociadas_productos_atenciones(){
		$this->db->select('id_producto_agrupador, count(DISTINCT id_coordinadora_crm)  AS cantidad_coordinadoras, count(id_contacto_crm)  AS cantidad_contactos');
		$this->db->where('deleted',0);
		$this->db->group_by("id_producto_agrupador");
		$this->db->order_by("cantidad_contactos", "DESC");
		$query = $this->db->get('atenciones');

		if($query->num_rows() > 0){
		    return $query->result_array();
		}
		return array();
	}


	// Función para limitar la cantidad de meses que se mostrarán en la vista 2.
	function get_meses_maximos(){
		$sql = "SELECT MONTH(fecha) as mes FROM atenciones WHERE deleted=0 GROUP BY (mes) ORDER BY mes asc";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
	      return $query->result_array();
	    }
	    return array();

	}
		

		
		
}
?>
