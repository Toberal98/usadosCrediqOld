<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* +-----------------------------------------+
* |              WEB-INFORMATICA            |
* |-----------------------------------------|
* | @subject : Sistema de Venta             |
* | @owner   : Credi Q                      |
* |                                         |
* | @author  : Web-Informatica              |
* | @package : cqventa                      |
* | @copy    : Web-Informatica              |
* +-----------------------------------------+
* http://web-informatica.com
**/
class Savedata_model extends CI_Model
{
	function save_image($datos)
	{
		return $this->db->insert('imagenes', $datos);
	}
	
	

	function guardar($tabla, $datos){
		$this->db->insert($tabla, $datos);
		return $this->db->insert_id();
	}
	function guardar_buscado($mark, $model,$year){
		//$this->db->query("INSERT INTO cq_buscados VALUES('', NOW(), '".$mark."', '".$model."', '".$year."');");
                //$this->db->query("INSERT INTO cq_buscados VALUES('',NOW(), '".$mark."', '".$model."', '".$year."');");
		//return $this->db->insert_id();
	}
	function actualizar($where, $tabla, $datos){
		$this->db->where($where);
		$this->db->update($tabla,$datos);
	}

	function aprobarCar($id, $var){
		$this->db->query("UPDATE cq_automovil SET estado='Aprobado', justi_solicitud = '".$var."' WHERE id_automovil = '".$id."' ");
	}	

	function updateData($whereCamp,$valor, $tabla, $datos){//solo para una condicion
		$this->db->where($whereCamp,$valor);
		$this->db->update($tabla,$datos);
	}
	function delTelefono($id_telefono){
		$this->db->delete('cq_telefonos', array('id_telefono' => $id_telefono )); 
	}
	function delEquipo($id_auto){
		$this->db->delete('cq_auto_x_equipamiento', array('id_auto' => $id_auto )); 
	}
	function delimagen($id_auto,$tipo){
		$this->db->query("DELETE  FROM imagenes WHERE codigo_vehiculo='".$id_auto."' AND codigo_tipo_foto='0000".$tipo."' "); 
	}
	function GuardarRec($tipo){
		$this->db->query("INSERT INTO cq_recomendaciones VALUES('', NOW(), '".$tipo."' ) ");
		return $this->db->insert_id();
		
	}

	function update_image($datos,$where){
		$this->db->where($where);
		return $this->db->update('imagenes', $datos);
	}
	

}