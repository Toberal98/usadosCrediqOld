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
class Car extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('bid_model');
        $this->load->model('data_model');
        $this->load->model('function_model');
        $this->load->model('Savedata_model');
        $this->load->library('session');
        $this->load->library('prestamo');
        $this->load->library('pagination');
        if(!$this->session->userdata('user_id'))
        redirect(base_url()."index.php/login");
    }

    function index(){
        $data['template'] = 'template/main-admin';
        $data['admin'] = true;
        $this->load->view('template/masterpage', $data);
    }

    function general(){
        $data['admin'] = true;
        $data['marcas'] = $this->data_model->getMarcas("");
        $data['categorias'] = $this->data_model->getCategories();

        $data['paises'] = $this->data_model->getPaises();
        $data['moneda'] = $this->session->userdata('moneda');
        $data['renting'] = $this->data_model->getRentingDefault();
        $data['compra'] = $this->data_model->getCompraDefault();
        return $data;
    }

    function add($tipo_venta = 0) {
        $data = $this->general();
        $data['renting'] = $this->data_model->getRentingDefault();
        $data['compra'] = $this->data_model->getCompraDefault();
        $data['template'] = 'template/add-producto';
        $this->load->view('template/masterpage', $data);
    }    
    
    //pendiente
    function addauto() {
        $data['admin'] = true;
        $data['marcas'] = $this->data_model->getMarcas("");
        $data['categorias'] = $this->data_model->getCategories();
        $data['template'] = 'template/add-auto';
        $this->load->view('template/masterpage', $data);
    }
    //pendiente
    function addprecio($id){
        $data['admin'] = true;
        $data['renting'] = $this->data_model->getRentingDefault();
        $data['compra'] = $this->data_model->getCompraDefault();
        $data['data_auto'] = $this->data_model->getInfoCar($id);
        $data['template'] = 'template/add-auto-precio';
        $this->load->view('template/masterpage', $data);
    }

    function precios(){
        $data['admin'] = true;
        $data['renting'] = $this->data_model->getRentingDefault();
        $data['compra'] = $this->data_model->getCompraDefault();
        $data['template'] = 'template/compra-renting';
        $this->load->view('template/masterpage', $data);
    }

    function administrar($action, $id){
        $data = $this->general();
        $data['data_auto'] = $this->data_model->getInfoCar($id);
        if($action == "editar"){
            $data['renting'] = $this->data_model->getRentingDefault();
            $data['compra'] = $this->data_model->getCompraDefault();
            $data['template'] = 'template/update-producto';            
        }else if($action == "ver"){
            $data['template'] = 'template/ver-producto';
        }    
        $this->load->view('template/masterpage', $data);
    }

    function estado($estado, $pagina = 0){
        //datos generales
        $data = $this->general();
        //Get Active Cars
        $limite = "LIMIT " . $pagina . ', 12';

        if ($estado == 'completado' || $estado == 'pendiente'){
            $data['cars'] = $this->data_model->carsbystado($this->session->userdata('pais'), $estado, $limite);
            $sinlimite = $this->data_model->carsbystado($this->session->userdata('pais'), $estado, '');
        }

        $this->load->library('pagination');

        $total_result = count($sinlimite);

        if ($total_result > 12){
            $config['base_url'] = base_url() . 'index.php/car/estado/' . $estado;
            $config['total_rows'] = $total_result;
            $config['per_page'] = 12;
            $config['uri_segment'] = 4;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
        }
        $data['estado'] = $estado;
        $data['template'] = 'template/administrar-autos.php';
        $this->load->view('template/masterpage', $data);
    }

    function cargarModelByMarca($idMarca){
        header("Content-Type: application/json");
        echo json_encode($this->data_model->getModelsByMarca($idMarca));
    }

    function marcas($row = 0){
        $items = $this->config->item('objetos_x_pagina');
        $data['admin'] = true;
        $limite = "LIMIT ".$row.", ".$items;

        $total_result = count($this->data_model->getMarcas(""));
        $data['marcas'] = $this->data_model->getMarcas($limite);
        
        $config = $this->config->item('pagination');
        $config['base_url'] = base_url() . 'index.php/car/marcas/';
        $config['total_rows'] = $total_result;
        $config['per_page'] = $items;
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['template'] = 'template/administrar-marcas';
        $this->load->view('template/masterpage', $data);
    }

    function modelos($row = 0){
        $items = $this->config->item('objetos_x_pagina');
        $data['admin'] = true;
        $limite = "LIMIT ".$row.", ".$items;

        $total_result = count($this->data_model->getModelos(""));
        $data['modelos'] = $this->data_model->getModelos($limite);//Parametro vacio por ignorra paginacion
        $data['marcas'] = $this->data_model->getMarcas("");
        $config = $this->config->item('pagination');
        $config['base_url'] = base_url() . 'index.php/car/modelos/';
        $config['total_rows'] = $total_result;
        $config['per_page'] = $items;
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['template'] = 'template/administrar-modelos';
        $this->load->view('template/masterpage', $data);
    }

    function planes($tipo){
        $data['admin'] = true;
        if($tipo == "compra"){
            $data['planes'] = $this->data_model->getPlanesCompra();
            $data['template'] = 'template/administrar-planescompra';
        }else if($tipo == "renting"){
            $data['planes'] = $this->data_model->getPlanesRenting();
            $data['template'] = 'template/administrar-planesrenting';
        }else{
            redirect(base_url()."index.php/car");
        }
        
        $this->load->view('template/masterpage', $data);
    }


    function borrar_mi_vehiculo($action, $id) {
        $data = $this->general();

        if (!$this->session->userdata('user_id')) {
            redirect(base_url());
        }
        if ($this->session->userdata('user_perfil') != '1' and $this->session->userdata('user_perfil') != '2') {
            redirect(base_url());
        }

        if ($action == 'preguntar') {

            $data['tipo'] = '34';

            $data['aviso'] = '<h3 class="cabin_blue_18">Desea Eliminar el vehiculo?</h3>
                              <h3 class="cabin_blue_18">| <a class="cabin_blue_18" href="' . base_url() . 'index.php/car/borrar_mi_vehiculo/borrar/' . $id . '">Si</a>
                            | <a class="cabin_blue_18" href="' . base_url() . 'index.php/user/acount">No</a> |</h3>';
        }elseif ($action == 'borrar'){

            $this->Savedata_model->actualizar(array('id_automovil' => $id), 'cq_automovil', array('estado' => 'eliminado')); //borramos imagen

            redirect(base_url() . 'index.php/user/acount');
        } else {
            redirect(base_url());
        }
        $data['template'] = 'template/aviso';
        $this->load->view('template/masterpage', $data);
    }

    function borrar_un_vehiculo($action, $id) {

        $data = $this->general();

        if (!$this->session->userdata('user_id')) {
            redirect(base_url());
        }
        if ($this->session->userdata('user_perfil') != '1') {
            redirect(base_url());
        }


        if ($action == 'preguntar') {

            $data['tipo'] = '34';

            $data['aviso'] = '<h3 class="cabin_blue_18">Desea Eliminar el vehiculo?</h3>
                              <h3 class="cabin_blue_18"> | <a class="cabin_blue_18" href="' . base_url() . 'index.php/car/borrar_un_vehiculo/si/' . $id . ' ">Si</a>
                            | <a class="cabin_blue_18" href="' . base_url() . 'index.php/car/estado/aprobado-admin">No</a> |</h3> ';
        } elseif ($action == 'borrar') {

            $this->Savedata_model->actualizar(array('id_automovil' => $id), 'cq_automovil', array('estado' => 'eliminado')); //borramos imagen

            redirect(base_url() . 'index.php/car/estado/aprobado-admin');
        } else {
            redirect(base_url());
        }

        $data['template'] = 'template/aviso';
        $this->load->view('template/masterpage', $data);
    }

    function dar_baja($id, $opcion) {
        if (!$this->session->userdata('user_id') or $this->session->userdata('user_perfil') != '1') {
            redirect(base_url());
        } else {

            $data = $this->general();

            $data['template'] = '';

            if ($opcion == 'preguntar') {

                $data['car'] = $this->data_model->getUserCar($id, $this->session->userdata('pais'));
                //Marcas
                $data['marks'] = $this->data_model->getMarks();
                $data['tumbnails'] = $this->data_model->getTumbnails($id);

                if (count($data['tumbnails']) < 1) {
                    $data['tumbnails'] = 0;
                }

                //$data['models'] = $this->data_model->getModels();


                $data['aviso'] = '<h3 >Baja de Veh&iacute;culo <span></span></h3>
                                  <div class="row detalle"> <div class="column12"><h1>' . $data['car']['id_automovil'] . ' - ' . $data['car']['marca'] . '-' . $data['car']['modelo'] . ' ' . $data['car']['year'] . '</h1>
                                        <p class="links"> <a href="' . base_url() . 'index.php/car/dar_baja/' . $id . '/vendido">Vendido por CrediQ</a>
                                        <a  href="' . base_url() . 'index.php/car/dar_baja/' . $id . '/sincontacto">Sin Contacto con Cliente</a>
                                        <a " href="' . base_url() . 'index.php/car/dar_baja/' . $id . '/tiempovencido">Tiempo Vencido</a>
                                        <a href="' . base_url() . 'index.php/car/estado/aprobado-admin/">Cancelar</a>
                                        <!--a href="' . base_url() . 'index.php/car/dar_baja/' . $id . '/no">Cancelar 2</a--> </p>
                                  </div></div>';
                $data['tipo'] = "11";

                $data['template'] = 'template/detalle-corto';
            }

            if ($opcion == 'vendido' || $opcion == 'sincontacto' || $opcion == 'tiempovencido') {

                $this->Savedata_model->actualizar(array('id_automovil' => $id), 'cq_automovil', array('estado' => $opcion)); //borramos imagen
                $data['template'] = 'template/aviso';
                $data['tipo'] = "20";
            }

            if ($opcion == 'no') {
                redirect(base_url() . 'index.php/car/administrar/modificar/' . $id); //
            }


            $this->load->view('template/masterpage', $data); //
        }
    }

    function borrarimagen($id, $borrar, $tipoimg) {
        if (!$this->session->userdata('user_id') or $this->session->userdata('user_perfil') != '1') {
            redirect(base_url());
        } else {

            $data = $this->general();

            if ($borrar == 'preguntar') {



                $data['aviso'] = '<h2>Desea borrar la imagen?</h2>
						| <a href="' . base_url() . 'index.php/car/borrarimagen/' . $id . '/si/' . $tipoimg . '">Si</a>
						| <a href="' . base_url() . 'index.php/car/borrarimagen/' . $id . '/no">No</a> |';
                $data['tipo'] = "10";
            }
            if ($borrar == 'si') {
                $this->Savedata_model->delimagen($id, $tipoimg); //borramos imagen,
                //echo 'borrada';
                redirect(base_url() . 'index.php/car/administrar/modificar/' . $id);
            }

            if ($borrar == 'no') {
                redirect(base_url() . 'index.php/car/administrar/modificar/' . $id);
            }

            $data['template'] = 'template/aviso';
            $this->load->view('template/masterpage', $data);
        }
    }

}