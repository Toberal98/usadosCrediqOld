<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
 * */
class Filter_model extends CI_Model {

    function getProducts($limite){
        $pais = $this->session->userdata('pais');
        $orden = $this->session->userdata('orden_actual');

        $estado = " AND auto.visible = 'si' AND auto.estado = 'completado'";
        $order_by = "auto.id_automovil DESC";

        $queryToExecute = "SELECT 	auto.id_automovil,
                        marca.nombre AS marca,
                        model.nombre AS modelo,
                        tipo.nombre AS tipo,
                        ca.cuota_mensual as cuota_compra,
                        ra.cuota_diaria AS cuota_renting,
                        ra.aplica AS renting_aplica
                        FROM cq_automovil AS auto,
                        cq_marca AS marca,
                        cq_modelo AS model,
                        cq_tipo_vehiculo AS tipo,
                        compra_auto AS ca,
                        renting_auto AS ra
                        WHERE 
                        auto.marca = marca.id_marca AND
                        auto.modelo = model.id_modelo AND
                        auto.tipo_vehiculo = tipo.id_tipo_vehiculo AND
                        auto.id_automovil = ca.id_automovil AND
                        auto.id_automovil = ra.id_automovil AND
                        auto.pais = '".$pais."' ".$estado."
		                ORDER BY " . $order_by." ".$limite;

        $this->session->set_userdata('queryDebug', $queryToExecute);

        $query = $this->db->query($queryToExecute);

        return $query->result_array();
    }

    function filtrarVehiculos($cat, $tipoCuo, $cuoMin, $cuoMax, $marca, $limit){
        $catSQL = "";
        $cuoSQL = "";
        $marcaSQL = "";

        $pais = $this->session->userdata('pais');
        $estado = " AND auto.visible = 'si' AND auto.estado = 'completado'";

        $orderby = " ORDER BY auto.id_automovil DESC";

        if($marca != ""){
            $marcaSQL = " AND auto.marca IN (".$marca.")";
        }
        if($cat !="" ){
            $catSQL = " AND auto.tipo_vehiculo='".$cat."'";
        }

        if($tipoCuo == "compra"){
            if($cuoMin != "" && $cuoMax != ""){
                $cuoSQL = " AND ca.cuota_mensual BETWEEN ".$cuoMin." AND ".$cuoMax."";
            }elseif($cuoMin != "" && $cuoMax == ""){
                $cuoSQL = " AND ca.cuota_mensual >= ".$cuoMin."";
            }elseif($cuoMin == "" && $cuoMax != ""){
                $cuoSQL = " AND ca.cuota_mensual <= ".$cuoMax."";
            }
        }elseif($tipoCuo == "renting"){
            if($cuoMin != "" && $cuoMax != ""){
                $cuoSQL = " AND ra.cuota_diaria BETWEEN ".$cuoMin." AND ".$cuoMax."";
            }elseif($cuoMin != "" && $cuoMax == ""){
                $cuoSQL = " AND ra.cuota_diaria >= ".$cuoMin."";
            }elseif($cuoMin == "" && $cuoMax != ""){
                $cuoSQL = " AND ra.cuota_diaria <= ".$cuoMax."";
            }
        }

        $sql = "SELECT 	auto.id_automovil,
                marca.nombre AS marca,
                model.nombre AS modelo,
                tipo.nombre AS tipo,
                ca.cuota_mensual as cuota_compra,
                ra.cuota_diaria AS cuota_renting,
                ra.aplica AS renting_aplica
                FROM cq_automovil AS auto,
                cq_marca AS marca,
                cq_modelo AS model,
                cq_tipo_vehiculo AS tipo,
                compra_auto AS ca,
                renting_auto AS ra
                WHERE 
                auto.marca = marca.id_marca AND
                auto.modelo = model.id_modelo AND
                auto.tipo_vehiculo = tipo.id_tipo_vehiculo AND
                auto.id_automovil = ca.id_automovil AND
                auto.id_automovil = ra.id_automovil AND 
                auto.pais = '".$pais."' ".$estado."
                ".$catSQL. $cuoSQL. $marcaSQL. $orderby. $limit;

        return $this->db->query($sql);
    }

    function getImageUrl($id){
        $url = "http://www.usadoscrediq.com/public/images/no_disponible.jpg";
        $imageQuery = $this->db->get_where('imagenes', array('codigo_vehiculo' => $id));

        if($imageQuery->num_rows() > 0){
            $row = $imageQuery->row_array();
            $url = base_url() ."imagenes/cars/". $row['imagen_path'];
        }
        return $url;
    }

    function getPathImg($id){
        $path ="";
        $pathSql = $this->db->get_where('imagenes', array('codigo_vehiculo' => $id));
        if ($pathSql->num_rows() > 0){
            $row = $pathSql->row_array();
            $path = $row['imagen_path'];
        }
        return $path;
    }

    function esRentingEspecial($tasa_r, $plazo_r){
        $id_pais = $this->session->userdata('pais');
        $this->db->select('*');
        $this->db->from('cq_planes_renting');
        $this->db->where('pais', $id_pais);
        $query = $this->db->get();
        $row = $query->row_array();
        $tasa_default = $row['tasa_anual'];
        $plazo_default = $row['plazo'];
        $valid = "no"; //no es especial

        if ($tasa_default != $tasa_r){  $valid="si"; }
        if ($plazo_default != $plazo_r){  $valid="si"; }
        return $valid;
    }
    function esCompraEspecial($tasa_c, $plazo_c, $prima_c, $recargo_c){
        $id_pais = $this->session->userdata('pais');
        $this->db->select('*');
        $this->db->from('cq_planes_compra');
        $this->db->where('pais', $id_pais);
        $query = $this->db->get();
        $row = $query->row_array();
        $tasa_default = $row['tasa_anual'];
        $plazo_default = $row['plazo'];
        $prima_default = $row['prima'];
        $recargo_default = $row['recargo'];
        $valid = "no"; //no es especial

        if ($tasa_default != $tasa_c){  $valid="si"; }
        if ($plazo_default != $plazo_c){  $valid="si"; }
        if ($prima_default != $prima_c){  $valid="si"; }
        if ($recargo_default != $recargo_c){  $valid="si"; }
        return $valid;
    }

}
