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
class Solicitud extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('data_model');
        $this->load->model('function_model');
        $this->load->model('Savedata_model');
        $this->load->library('Session');
    }

    function index() {
        redirect(base_url());
    }

    function general() {
        //Categorias (Tipos de Vehiculo)
        $data['categories'] = $this->data_model->getCategories();
        //Publicidad
        $data['banners'] = $this->data_model->getBanners();

        $data['bannersPosition'] = $this->data_model->Banners();

        $data['paises'] = $this->data_model->getPaises();
        $data['moneda'] = $this->session->userdata('moneda');

        return $data;
    }

    function credito_natural($paso) {



        $data = $this->general();

        $data['tipo_solicitud'] = 'natural';
        $data['controlador'] = 'solicitud_save';

        if ($paso == 1) {

            $data['template'] = 'template/solicitud';
        } elseif ($paso == 2) {


            if ($this->session->userdata('paso1') == 'ok') {
                $data['template'] = 'template/solicitud-natural_2';
            } else {
                $tipo_solicitud = 'natural';
                $data['template'] = 'template/solicitud';
            }
        } elseif ($paso == 3) {

            if ($this->session->userdata('paso1') != 'ok' or $this->session->userdata('paso2') != 'ok') {
                $data['template'] = 'template/solicitud';
            } else {
                $data['template'] = 'template/solicitud-natural_3';
            }
        } else {
            $data['template'] = 'template/solicitud';
        }

        $this->load->view('template/masterpage.php', $data);
    }

    function credito_juridica($paso) {

        $data = $this->general();
        $data['tipo_solicitud'] = 'juridica';
        $data['controlador'] = 'juridica_save';

        if ($paso == 1) {
            $data['template'] = 'template/solicitud';
        } else
        if ($paso == 2) {
            if ($this->session->userdata('paso1') == "") {
                $data['template'] = 'template/solicitud';
            } else {
                $data['template'] = 'template/solicitud-juridica_2';
            }
        } else
        if ($paso == 3) {
            if ($this->session->userdata('paso1') == "" or $this->session->userdata('paso2') == "") {
                $data['template'] = 'template/solicitud';
            } else {
                $data['template'] = 'template/solicitud-juridica_3';
            }
        } else {
            $data['template'] = 'template/solicitud';
        }

        $this->load->view('template/masterpage.php', $data);
    }

    function lista($desde = '0') {
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1))) {
            redirect(base_url());
        } else {
            $data = $this->general();

            $limite = "LIMIT " . $desde . ", 12";

            $data['solicitudes'] = $this->data_model->GetSolicitudes($limite);

            $total = count($this->data_model->GetSolicitudes(''));

            if ($total > 12) {

                $this->load->library('pagination');

                $config['base_url'] = base_url() . 'index.php/solicitud/lista';
                $config['total_rows'] = $total;
                $config['per_page'] = 12;
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
            }

            $data['template'] = 'template/solicitud-list';
            $this->load->view('template/masterpage.php', $data);
        }
    }

    function ver($id) {
        if (!$this->session->userdata('user_id') and $this->session->userdata('user_perfil') != '1') {
            redirect(base_url());
        } else {
            $data = $this->general();

            $where = array('id' => $id);

            $data['solicitud'] = $this->data_model->RowDataWhere($where, 'cq_solicitud');
            $where = array('id_solicitud' => $id);
            $data['cliente'] = $this->data_model->RowDataWhere($where, 'cq_solicitud_cliente');
            $data['referencia'] = $this->data_model->RowDataWhere($where, 'cq_solicitud_ref');
            $data['template'] = 'template/solicitud_detalle';
            $this->load->view('template/masterpage', $data);
        }
    }

    function saved() {
        $data = $this->general();
        $data['tipo'] = '21';
        $data['template'] = 'template/aviso';
        $this->load->view('template/masterpage.php', $data);
    }

    function juridica_saved() {
        $data = $this->general();
        $data['tipo'] = '24';
        $data['template'] = 'template/aviso';
        $this->load->view('template/masterpage.php', $data);
    }

    function rechazar($id, $accion) {
        $data = $this->general();

        if ($accion == 'preguntar') {
            $data['tipo'] = '22';
            $data['id'] = $id;
            $data['template'] = 'template/aviso';
        }

        if ($accion == 'borrar') {

            $this->Savedata_model->actualizar(array('id' => $id), 'cq_solicitud', array('estado' => 'rechazada'));

            $data['tipo'] = '23';
            $data['template'] = 'template/aviso';
        }


        $this->load->view('template/masterpage.php', $data);
    }

    function ver_juridica($id) {

        $data = $this->general();

        $where = array('id_solicitud' => $id);

        $data['datos_generales'] = $this->data_model->RowDataWhere($where, 'cq_sol_solicitud');
        $data['solicitante'] = $this->data_model->RowDataWhere($where, 'cq_sol_solicitante_juridico');

        $data['ref_bank'] = $this->data_model->getDataWhere($where, 'cq_sol_referencia_bancaria');
        $data['ref_comercial'] = $this->data_model->getDataWhere($where, 'cq_sol_referencia_comercial');


        $data['representante'] = $this->data_model->RowDataWhere($where, 'cq_sol_representante_legal');
        $data['repre_laboral'] = $this->data_model->RowDataWhere($where, 'cq_sol_info-laboral');
        $data['repre_conyuge'] = $this->data_model->RowDataWhere($where, 'cq_sol_conyuge');
        $data['repre_vehiculo'] = $this->data_model->RowDataWhere($where, 'cq_sol_vehiculo');

        $where_re = array('id_solicitud' => $id, 'tipo_info' => 'representante');
        $data['repre_ref_financiera'] = $this->data_model->RowDataWhere($where_re, 'cq_sol_referencia_financiera');
        $data['repre_ref_tarjeta'] = $this->data_model->RowDataWhere($where_re, 'cq_sol_referencia_tarjeta_credito');


        $data['repre_ref_comercial'] = $this->data_model->RowDataWhere($where_re, 'cq_sol_referencia_comercial');

        $where_fiador3 = array('id_solicitud' => $id, 'tipo_info' => 'representante', 'tipo_referencia' => 'personal');
        $data['repre_ref_personal'] = $this->data_model->getDataWhere($where_fiador3, 'cq_sol_referencia');

        $data['template'] = 'template/solicitud-juridica_ver';
        $this->load->view('template/masterpage.php', $data);
    }

    function vfinal($id = "") {
        $data = $this->general();

        $data['car'] = $this->data_model->getCar($id, $this->session->userdata('pais'));
        if (empty($data['car'])) {
            $data['car'] = array(
                "tipo_vehiculo" => "",
                "year" => "",
            );
        }

        $data['allcategories'] = $this->data_model->allCategories();
        //Datos para seleccionar
        $data['marks'] = $this->data_model->getMarks();

        $data['template'] = 'template/solicitud-final-2';

        $this->load->view('template/masterpage.php', $data);
    }

    function credito($id = "") {
        $data = $this->general();

        $data['car'] = $this->data_model->getCar($id, $this->session->userdata('pais'));
        if (empty($data['car'])) {
            $data['car'] = array(
                "tipo_vehiculo" => "",
                "year" => "",
            );
        }
        $data['allcategories'] = $this->data_model->allCategories();
        //Datos para seleccionar
        $data['marks'] = $this->data_model->getMarks();

        $data['template'] = 'template/solicitudes/solicitud-credito';
        //$data['template'] = 'template/solicitud-final-2';

        $this->load->view('template/masterpage.php', $data);
    }

    
    function vehiculo($id = "") {
        $data = $this->general();

        $data['car'] = $this->data_model->getCar($id, $this->session->userdata('pais'));
        if (empty($data['car'])) {
            $data['car'] = array(
                "tipo_vehiculo" => "",
                "year" => "",
            );
        }
        $data['allcategories'] = $this->data_model->allCategories();
        //Datos para seleccionar
        $data['marks'] = $this->data_model->getMarks();

        $data['template'] = 'template/solicitudes/solicitud-vehiculo';

        $this->load->view('template/masterpage.php', $data);
    }
}
