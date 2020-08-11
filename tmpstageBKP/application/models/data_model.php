<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Data_model extends CI_Model {
    //Luis Flores - Datasoft

    function getMarcas($limite) {
        $order_by = "ORDER BY nombre ASC";
        $sql = "SELECT * FROM cq_marca ".$order_by." ".$limite;
     
        //$this->db->where('visible', 'si');
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //Luis Flores - Datasoft 2019
    function getCategories() {
        $query = $this->db->get('cq_tipo_vehiculo');
        return $query->result_array();
    }
    //Luis Flores - Datasoft 2019
    function getRentingDefault(){
        $id_pais = $this->session->userdata('pais');
        $this->db->select('*');
        $this->db->from('cq_planes_renting');
        $this->db->where('pais', $id_pais);
        $query = $this->db->get();
        return $query;
    }
    //Luis Flores - Datasoft 2019
    function getCompraDefault(){
        $id_pais = $this->session->userdata('pais');
        $this->db->select('*');
        $this->db->from('cq_planes_compra');
        $this->db->where('pais', $id_pais);
        $query = $this->db->get();
        return $query;
    }

    function getAllCompraAuto(){
        $query = $this->db->get('compra_auto');
        return $query->result_array();
    }

    function getAllRentingAuto(){
        $query = $this->db->get('renting_auto');
        return $query->result_array();
    }

    function getModelos($limite){
        $query = $this->db->query("SELECT m.id_modelo, m.nombre, ma.nombre AS marca, ma.id_marca AS id_marca
            FROM cq_modelo m, cq_marca ma
            WHERE m.marca = ma.id_marca ".$limite);
        return $query->result_array();
    }

    function getModelsByMarca($marca){
        $this->db->select('*');
        $this->db->from('cq_modelo');
        $this->db->where('marca', $marca);
        $query = $this->db->get();
        return $query->result();
    }

    function allCategories() {

        $query = $this->db->get('cq_tipo_vehiculo');
        return $query->result_array();
    }

    function getCategoria($id = 0) {
        $this->db->where('id_tipo_vehiculo', $id);
        $query = $this->db->get('cq_tipo_vehiculo');
        return $query->row_array();
    }

    function getMarcasExistentes() {
        $sql = "SELECT 
                marca.id_marca,
                marca.nombre,
                foto.imagen_path AS foto
                FROM 
                cq_marca AS marca,
                marca_fotos AS foto
                WHERE
                marca.id_marca = foto.id_marca
                ORDER BY foto.orden ASC";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getInfoCar($id){
        $sql = "SELECT
        distinct(auto.id_automovil), auto.marca, auto.modelo, auto.tipo_vehiculo,
        auto.visible,
        compra.id_compra as id_compra,
        compra.prima as prima_com,
        compra.cuota_mensual as cuota_com,
        compra.tasa as tasa_com,
        compra.plazo as plazo_com,
        compra.recargo as recargo_com,
        compra.valor_vehiculo as precio_compra,
        renting.valor_vehiculo as precio_renting,
        renting.id_renting as id_renting,
        renting.tasa_anual as tasa_ren,
        renting.plazo as plazo_ren,
        renting.valor_residual as residual_ren,
        renting.cargo_mantenimiento_mensual as mante_ren,
        renting.tipo_administrativo as tipo_administartivo,
        renting.porcentaje_administrativo_mensual as por_admin_ren,
        renting.cargo_administrativo_mensual as cargo_admin_ren,
        renting.cuota_mensual as cuota_ren,
        renting.aplica as aplica_renting,
        img.imagen_path as imagen
        FROM cq_automovil as auto,
        cq_marca as marca,
        cq_modelo as mdl,
        cq_tipo_vehiculo as tipo,
        imagenes as img,
        compra_auto as compra,
        renting_auto as renting
        WHERE
        auto.marca = marca.id_marca AND 
        auto.modelo = mdl.id_modelo AND
        auto.tipo_vehiculo = tipo.id_tipo_vehiculo AND
        auto.id_automovil = img.codigo_vehiculo AND
        auto.id_automovil = compra.id_automovil AND
        auto.id_automovil = renting.id_automovil AND 
        auto.id_automovil = '".$id."';";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    function getUsers($limite) {
        //$query = $this->db->query("SELECT * FROM cq_usuario WHERE tipo_usuario = 1 ");
        $query = $this->db->query("SELECT * FROM cq_usuario WHERE tipo_usuario=1 " . $limite);

        return $query->result_array();
    }

    function getPaises() {
        $query = $this->db->get('cq_pais');
        return $query->result_array();
    }

    /* OBTENIENDO DATA DE UNA TABLA ESPECIFICA */

    function getData($tabla) {
        $query = $this->db->get($tabla);
        return $query->result_array();
    }

    function getUser($id) {
        $query = $this->db->query("SELECT * FROM cq_usuario WHERE id_usuario='" . $id . "'  ");

        return $query->row_array();
    }

    function carsbystado($pais, $estado, $limite) {

        $query = $this->db->query("SELECT DISTINCT auto.id_automovil,
            auto.visible,
			modelo.nombre AS modelo,
			marca.nombre AS marca,
			tipo.nombre as tipo_vehiculo,
            re.id_renting AS idrenting,
            co.id_compra AS idcompra,
            re.cuota_diaria AS cuota_renting,
            co.cuota_mensual AS cuota_compra
			FROM
			cq_automovil auto,
			cq_modelo modelo,
			cq_marca marca,
            cq_tipo_vehiculo tipo,
            renting_auto re,
            compra_auto co
			WHERE
			auto.marca = marca.id_marca AND
			auto.modelo = modelo.id_modelo AND
            auto.tipo_vehiculo = tipo.id_tipo_vehiculo AND
            auto.id_automovil = re.id_automovil AND
            auto.id_automovil = co.id_automovil AND
			auto.pais = '". $pais ."' AND
			auto.estado = '". $estado ."' order by auto.id_automovil desc " . $limite);
        return $query->result_array();
    }

    function SetMoneda() {

        if ($this->session->userdata('pais')) {

            $pais = $this->session->userdata('pais');

            if ($pais == 1) {
                $this->session->set_userdata('moneda', '$');
            } elseif ($pais == 2) {
                $this->session->set_userdata('moneda', '₡');
            } elseif ($pais == 3) {
                $this->session->set_userdata('moneda', 'L');
            }
        } else {
            $this->session->set_userdata('moneda', '$');
        }
        return $this->session->userdata('moneda');
    }

    function getDataWhere($where, $tabla) {
        $this->db->where($where);
        $query = $this->db->get($tabla);
        return $query->result_array();
    }

    function RowDataWhere($where, $tabla) {
        $this->db->where($where);
        $query = $this->db->get($tabla);
        return $query->row_array();
    }

    function getTipoUser() {
        $query = $this->db->query("SELECT *  FROM cq_tipo_usuario ");

        return $query->result_array();
    }

    function getTipoVehiculo($id_tipo) {
        $query = $this->db->get('cq_tipo_vehiculo');
        return $query->row_array();
    }

    function getCategoriasExistentes() {//
        //$query = $this->db->query("SELECT nombre FROM cq_tipo_vehiculo WHERE id_tipo_vehiculo IN (SELECT tipo_vehiculo FROM cq_automovil WHERE estado='Aprobado') ORDER BY nombre ASC");
        $query = $this->db->query("SELECT DISTINCT c.* FROM cq_tipo_vehiculo c, cq_automovil a, imagenes i  WHERE c.id_tipo_vehiculo = a.tipo_vehiculo AND a.estado='Aprobado' AND i.codigo_vehiculo = a.id_automovil ORDER BY c.nombre ASC");
        return $query->row_array();
    }

    function get_estado_user($email) {
        $query = $this->db->query("SELECT estado  FROM  cq_usuario WHERE email='" . $email . "'	");
        return $query->row_array();
    }
}
?>