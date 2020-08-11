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
class Site extends CI_Controller {
    

    function __construct() {

        parent::__construct();
        $this->load->library('prestamo');        
        $this->load->model('data_model');
        $this->load->model('filter_model');
        $this->load->model('Secure_model');
        $this->load->model('function_model');
        $this->load->model('report_model');
        $this->load->model('Savedata_model');

        if (!$this->session->userdata('pais')) {
            $this->session->set_userdata('pais', 1);
        }

        if (!$this->session->userdata('moneda')) {
            $this->data_model->SetMoneda();
        }

        if (!$this->session->userdata('orden_actual')) {
            // Tomar mas reciente por default
            $this->session->set_userdata('orden_actual', '5');
        }

        if (!$this->session->userdata('lapso_actual')) {
            $this->session->set_userdata('lapso_actual', '0');
        }

        if (!$this->session->userdata('pagina_actual')) {
            $this->session->set_userdata('pagina_actual', '1');
        }

        if (!$this->session->userdata('vista_actual')) {
            $this->session->set_userdata('vista_actual', '1');
        }

        //$this->load->library('Recaptcha');
    }

    function general() {
        //Categorias (Tipos de Vehiculo)
        $data['categories'] = $this->data_model->getCategories();
        //Publicidad
        $data['banners'] = $this->data_model->getBanners();

        $data['bannersPosition'] = $this->data_model->Banners();

        $data['paises'] = $this->data_model->getPaises();

        return $data;
    }

    function calculadora($car = "0") {
        $data = $this->general();


        if ($car != "0") {
            $data['car'] = $this->data_model->getCar($car, $this->session->userdata('pais'));
            $data['monto'] = $data['car']['precio'];
        } else {
            $data['monto'] = 0;
        }

        $data['template'] = 'template/calculadora';
        $this->load->view('template/masterpage.php', $data);
    }

    function autolote($urlAutolote = "0") {


        if (!$this->session->userdata('CategoriaActual')) {
            $this->session->set_userdata('CategoriaActual', 'todas');
        }

        $data = $this->general();

        //echo '<br />id_banner=' . $data['bannersPosition'][0]['id_banner'];
        //definimos limites de la consulta
        $desde = $this->session->userdata('lapso_actual');

        $limite = "LIMIT " . $desde . ", 12";

        //Productos (Carros)
        $idUsuarioAutolote = "";

        if ($urlAutolote != "") {
            $data['idUsuarioAutolote'] = $this->data_model->getUserIdAutolote($urlAutolote);
            $idUsuarioAutolote = $data['idUsuarioAutolote']["idUsuario"];
        }


        $data['products'] = $this->filter_model->getProducts('', '', '', '', '', '', 'todas', '', '', '', $limite, '',$idUsuarioAutolote,0);

        $consulta_sin_limite = $this->filter_model->getProducts('', '', '', '', '', '', 'todas', '', '', '', '', '',$idUsuarioAutolote,0);

        $total_resultados = count($consulta_sin_limite);
        //Marcas
        $data['marks'] = $this->data_model->getMarks();
        //mostrar todo
        $data['filtro'] = TRUE; //mostramos vista filtro

        $data['combustibles'] = $this->data_model->getcombus();


        $data['total_resultados'] = $total_resultados;
        $data['paginacion'] = $this->filter_model->paginar($total_resultados, 12, 10, "filter_charact");
        $data['template'] = 'template/principal.php';

        $vista = $this->session->userdata('vista_actual');

        if ($vista == 1) {
            $data['vista1'] = TRUE; //mostramos vista 1
        } elseif ($vista == 2) {
            $data['vista2'] = TRUE; //mostramos vista 2
        } else {
            $data['vista1'] = TRUE; //mostramos vista 1
        }

        $this->load->view('template/masterpage.php', $data);
    }

    function index() {

        
        
        
        if (!$this->session->userdata('CategoriaActual')) {
            $this->session->set_userdata('CategoriaActual', 'todas');        }

        $data = $this->general();
        
        
         //Datos para seleccionar
        $data['marks_registro'] = $this->data_model->getMarks();
        //$data['combustibles'] = $this->data_model->getcombus();
        //$data['colors_registro'] = $this->data_model->getcolors()
        $data['profesions_registro'] = $this->data_model->getprofesions();

        $publickey = "6Le9fdQSAAAAAOd_EP6MD3RLTaua97E2oPdqhUry";

        $data['capatcha'] = $this->Secure_model->recaptcha_get_html($publickey);


        //echo '<br />id_banner=' . $data['bannersPosition'][0]['id_banner'];
        //definimos limites de la consulta
        $desde = $this->session->userdata('lapso_actual');

        $limite = "LIMIT " . $desde . ", 12";

        //Productos (Carros)
        date_default_timezone_set('America/El_Salvador');
        //Productos (Carros)
        $data['products'] = $this->filter_model->getProducts(date('Y') - 11, date('Y'), '', '', '', '', 'todas', '', '', '', $limite,'',0);

        $consulta_sin_limite = $this->filter_model->getProducts(date('Y') - 11, date('Y'), '', '', '', '', 'todas', '', '', '', '','',0);

        $total_resultados = count($consulta_sin_limite);
        //Marcas
        $data['marks'] = $this->data_model->getMarksExistentes();
        //mostrar todo
        $data['filtro'] = TRUE; //mostramos vista filtro

        $data['combustibles'] = $this->data_model->getcombus();
        $data['total_resultados'] = $total_resultados;
        $data['paginacion'] = $this->filter_model->paginar($total_resultados, 12, 6, "filter_charact");
        $data['template'] = 'template/principal.php';

        //datos para el arbol de la vista
        $data['f_mark'] = 'todos';
        $data['f_model'] = '';
        $data['f_tipo_vehiculo'] = '';
        $data['f_combustible'] = '';
        $data['f_financiamiento'] = '';
        $data['f_recomendados'] = '';
        $data['f_transmision'] = '';
        
        
       
        // Calcular la cuota minima.
         $i=0;
        foreach($data['products'] as $producto){
            
              /*MODIFICADO POR GGONZALEZ 26/05/2015 -  INI*/
            $data['CAMPOS_MATRIZ'] = $this->data_model->getCamposMatriz($producto['year'], $this->session->userdata('pais'));
            
              /*MODIFICADO POR GGONZALEZ 26/05/2015 -  FIN*/
        
            $tasaInteresPar =$data['CAMPOS_MATRIZ']['tasa'] ;
            $plazoPar = $data['CAMPOS_MATRIZ']['plazo'] ;
        
        
            // Creamos el objeto préstamo y le decimos que queremos una exactitud de 10 dígitos después de la coma.
            $prestamo = new Prestamo(10);
            // Configuramos el valor que pedimos de préstamo.
            $capital=$producto['precio'];
            $prestamo->setCapital($capital);            
            
            
            $prestamo->setTasaInteres($tasaInteresPar/100/12);
            $cuota = $prestamo->calcCuota($plazoPar);
            
            $cuota = number_format((float)$cuota, 2, '.', '');
            $producto['cuotaMin'] = $cuota;
            $data['products'][$i] = $producto;
            $i++;
         }

        $vista = $this->session->userdata('vista_actual');

        if ($vista == 1) {
            $data['vista1'] = TRUE; //mostramos vista 1
        } elseif ($vista == 2) {
            $data['vista2'] = TRUE; //mostramos vista 2
        } else {
            $data['vista1'] = TRUE; //mostramos vista 1
        }

        $this->load->view('template/masterpage.php', $data);
    }

    function about() {
        echo 'about page';
    }

    function process_url($id) {
        $this->load->model('secure_model');
        $url = $this->secure_model->getBannerURL($id);

        if ($url) {
            redirect($url);
        } else {
            redirect(base_url());
        }
    }

    function register() {
        //Categorias (Tipos de Vehiculo)
        $data = $this->general();
        //Datos para seleccionar
        $data['marks'] = $this->data_model->getMarks();
        $data['combustibles'] = $this->data_model->getcombus();
        $data['colors'] = $this->data_model->getcolors();
        $data['profesions'] = $this->data_model->getprofesions();

        $publickey = "6Le9fdQSAAAAAOd_EP6MD3RLTaua97E2oPdqhUry";

        $data['capatcha'] = $this->Secure_model->recaptcha_get_html($publickey);

        $data['template'] = 'template/add-usuario';
        //$this->load->view('template/masterpage', $data);
    }

    function aviso($tipo) {
        //Categorias (Tipos de Vehiculo)
        $data = $this->general();
        //Datos para seleccionar
        $data['marks'] = $this->data_model->getMarks();
        $data['combustibles'] = $this->data_model->getcombus();
        $data['colors'] = $this->data_model->getcolors();
        
        
            
         //Datos para seleccionar
        $data['marks_registro'] = $this->data_model->getMarks();
        //$data['combustibles'] = $this->data_model->getcombus();
        //$data['colors_registro'] = $this->data_model->getcolors();
        $data['profesions_registro'] = $this->data_model->getprofesions();

        $publickey = "6Le9fdQSAAAAAOd_EP6MD3RLTaua97E2oPdqhUry";

        $data['capatcha'] = $this->Secure_model->recaptcha_get_html($publickey);


        $data['tipo'] = $tipo;
        if ($tipo == 4 or $tipo == 12 or $tipo == 13) {
            $data['telefonos'] = $this->Secure_model->getTelefonos($this->session->userdata('user_id'));
        }


        $data['template'] = 'template/aviso';
        $this->load->view('template/masterpage', $data);
    }

    function updateduser() {
        //Categorias (Tipos de Vehiculo)
        $data = $this->general();
        //Datos para seleccionar
        $data['marks'] = $this->data_model->getMarks();
        $data['combustibles'] = $this->data_model->getcombus();
        $data['colors'] = $this->data_model->getcolors();

        $this->load->view('template/masterpage', $data);
    }

    function login() {
        $this->load->model('secure_model');
        $username = $this->input->post('user');
        $password = $this->input->post('pwd');

        //$template = $this->input->post('template');

        $log = $this->secure_model->login($username, $password);

        if ($this->secure_model->login($username, $password)) {
            redirect('car/add');
        } else {
            //Categorias (Tipos de Vehiculo)
            $data = $this->general();
            //Productos (Carros)
            $data['products'] = $this->data_model->Productos($this->session->userdata('pais'));
            //Marcas
            $data['marks'] = $this->data_model->getMarks();
            //Template
            //buscamos email checkEmail
            if ($this->secure_model->checkEmail($username)) {
                $user_temp = $this->data_model->get_estado_user($username);
                if (isset($user_temp['estado'])) {
                    if (md5($user_temp['estado']) == md5($username)) {
                        $data['error_login2'] = 'Su cuenta no ha sido activada';
                    }
                }
            }
            $data['error_login'] = 'Email o Password incorectos';
            $data['tipo'] = "30";

            $data['template'] = 'template/aviso';

            //$data['template'] = $template;
            $this->load->view('template/masterpage.php', $data);
        }
    }

    function logout() {
        $this->session->destroy();
        redirect(base_url());
    }

    function modificarDatos() {
        //protegido por sesion
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1, 2))) {
            redirect(base_url());
        } else {
            $data = $this->general();
            //Datos para seleccionar
            $data['marks'] = $this->data_model->getMarks();
            $data['combustibles'] = $this->data_model->getcombus();
            $data['colors'] = $this->data_model->getcolors();

            $data['telefonos'] = $this->Secure_model->getTelefonos($this->session->userdata('user_id'));

            $data['template'] = 'template/mod-usuario';
            $this->load->view('template/masterpage', $data);
        }
    }

    function activateAcc($key) {

        $data = $this->general();
        //Datos para seleccionar
        $data['marks'] = $this->data_model->getMarks();
        $data['combustibles'] = $this->data_model->getcombus();
        $data['colors'] = $this->data_model->getcolors();

        if ($this->Secure_model->activateAccount($key)) {
            $data['tipo'] = 8;
            $data['template'] = 'template/aviso';
        } else {
            $data['tipo'] = 9;
            $data['template'] = 'template/aviso';
        }
        $this->load->view('template/masterpage', $data);
    }

    function changePais() {
        $pais = $this->input->post('pais');
        $template = $this->input->post('template');

        $this->session->set_userdata('pais', $pais);

        $this->data_model->SetMoneda();

        redirect(base_url());
    }

    //Uso del sitio que es Joomla
    function resultados() {
        $this->load->model('filter_model');

        $year = $this->input->post('year');
        $marca = $this->input->post('marca');
        $modelo = $this->input->post('modelo');
        $pais = $this->input->post('pais');

        $pais = $this->data_model->getPaisbyCode($pais);

        $this->session->set_userdata('pais', $pais);

        //Categorias (Tipos de Vehiculo)
        $data = $this->general();

        //Productos (Carros)
        $data['products'] = $this->filter_model->filter_ymm($year, $marca, $modelo, $pais);
        //Marcas
        $data['marks'] = $this->data_model->getMarks();
        //mostrar todo
        $data['template'] = 'template/principal.php';
        $this->load->view('template/masterpage.php', $data);
    }

    function contacto() {

        $data = $this->general();

        $data['template'] = 'template/contacto.php';

        $this->load->view('template/masterpage.php', $data);
    }

    function agencias($numAgencia) {

        $data = $this->general();
        $data["numAgencia"]=$numAgencia;
        $this->load->view('template/maps/agencias.php', $data);
    }
    function proccessContact() {

        $data = $this->general();
        //Datos para seleccionar
        $data['marks'] = $this->data_model->getMarks();
        $data['combustibles'] = $this->data_model->getcombus();
        $data['colors'] = $this->data_model->getcolors();

        $nombre = $this->input->post('nombre');
        $telefono = $this->input->post('telefono');
        $email = $this->input->post('email');
        $consulta = htmlentities($this->input->post('consulta'));

        $datos = array(
            'tipo' => 'contacto',
            'to' => 'usados.sv@crediq.com',
            'nombre' => $nombre,
            'telefono' => $telefono,
            'email' => $email,
            'consulta' => $consulta
        );

        $clave = "";

        if ($this->function_model->enviarMail($datos)) {
            redirect(base_url() . 'index.php/site/aviso/5');
        } else {
            redirect(base_url() . 'index.php/site/aviso/3');
        }

        $this->load->view('template/masterpage.php', $data);
    }

    function recuperarClave() {

        $data = $this->general();
        //Datos para seleccionar
        $data['marks'] = $this->data_model->getMarks();
        $data['combustibles'] = $this->data_model->getcombus();
        $data['colors'] = $this->data_model->getcolors();

        $publickey = "6Le9fdQSAAAAAOd_EP6MD3RLTaua97E2oPdqhUry";

        $data['capatcha'] = $this->Secure_model->recaptcha_get_html($publickey);

        $data['template'] = 'template/recuperar_clave.php';

        $this->load->view('template/masterpage_clave.php', $data);
    }

    function remakeClave() {

        $data = $this->general();
        //Datos para seleccionar
        $data['marks'] = $this->data_model->getMarks();
        $data['combustibles'] = $this->data_model->getcombus();
        $data['colors'] = $this->data_model->getcolors();

        $email = $this->input->post('email');

        if ($this->Secure_model->checkEmail($email)) {

            $nombre = md5($email);

            $newPass = $this->Secure_model->generateClave($nombre);

            $this->Secure_model->updatePassword($email, $newPass);

            $datos = "recuperarPass";

            $datos = array('tipo' => 'recuperarPass',
                'to' => $email,
                'newpass' => $newPass
            );

            if ($this->function_model->enviarMail($datos)) {
                redirect(base_url() . 'index.php/site/aviso/6');
            } else {
                redirect(base_url() . 'index.php/site/aviso/3');
            }
        } else {
            redirect(base_url() . 'index.php/site/aviso/7');
        }
    }

    function adverts($desde = '0') {
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1, 2))) {
            redirect(base_url());
        } else {
            $data = $this->general();
            //limite
            $limite = 'LIMIT ' . $desde . ', 12';
            $data['adverts'] = $this->data_model->getBanners_list($limite);
            $sinlimite = $this->data_model->getBanners_list('');

            //cargamos paginacion
            $this->load->library('pagination');

            $total_result = count($sinlimite);

            if ($total_result > 12) {

                $config['base_url'] = base_url() . 'index.php/site/adverts/';
                $config['total_rows'] = $total_result;
                $config['per_page'] = 12;
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
            }

            $data['template'] = 'template/advert-list';

            $this->load->view('template/masterpage', $data);
        }
    }

    function advert_crear() {
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1, 2))) {
            redirect(base_url());
        } else {
            $data = $this->general();
            $data['template'] = 'template/advert-crear';

            $this->load->view('template/masterpage', $data);
        }
    }

    function advert_update($id) {
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1, 2))) {
            redirect(base_url());
        } else {
            $data = $this->general();
            //sacamos un banner segun el id
            $data['banner'] = $this->data_model->getBanner($id);
            $data['banner_imgs'] = $this->data_model->getBannerImg($id);
            $data['id'] = $id;
            $data['template'] = 'template/advert-update';
            $this->load->view('template/masterpage', $data);
        }
    }

    function advert_borrar($id, $accion) {
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1, 2))) {
            redirect(base_url());
        } else {
            //delete advert
            $data = $this->general();

            if ($accion == 'preguntar') {

                $data['imagen'] = $this->data_model->getBannerImg($id);

                $data['aviso'] = '<h2>Desea Borrar este banner?</h2>
						| <a href="' . base_url() . 'index.php/site/advert_borrar/' . $id . '/si">Si</a>
						| <a href="' . base_url() . 'index.php/site/advert_borrar/' . $id . '/no">No</a> |';
                $data['tipo'] = "18";
            }

            if ($accion == 'si') {//
                $data['imagen'] = $this->data_model->getBannerImg($id);

                $this->data_model->deleteBanner($id);

                if (count($data['imagen']) > 0) {
                    $this->data_model->deleteBannerImgs($id);
                }
                $data['tipo'] = "19";
            }

            if ($accion == 'no') {
                redirect(base_url() . 'index.php/site/adverts'); // 
            }

            $data['template'] = 'template/aviso';
            $this->load->view('template/masterpage', $data); //
        }
    }

    function change_vista($tipo) {
        $this->session->set_userdata('vista_actual', $tipo);
        redirect(base_url());
    }

    function recomendar() {

        // JA - 22/01/2015 Se deshabilito por requerimiento del area comercial
        /*$data = $this->general();
        $data['template'] = 'template/recomendar';        
        $this->load->view('template/masterpage.php', $data);*/
        redirect(base_url());
    }

    function nopromociones() {

        
        // JA - 22/01/2015 Se deshabilito por requerimiento del area comercial
        /*$data = $this->general();
        $data['template'] = 'template/nopromociones';
        $this->load->view('template/masterpage.php', $data);
        */
         redirect(base_url());
    }

    function reportes($lap = '0', $orden = '') {

        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1))) {
            redirect(base_url());
        } else {
            $data = $this->general();


            if (!$this->session->userdata('rep_sort')) {
                $this->session->set_userdata('rep_sort', 'ASC');
            }
            if (!$this->session->userdata('rep_tipo')) {
                $this->session->set_userdata('rep_tipo', 'global');
            }

            $sort = $this->input->post('sort');
            $tipo = $this->input->post("tipo");
            $por_rango = $this->input->post("rango");

            if ($por_rango == 'Filtrar') {
                $desde = $this->input->post('desde_year') . '-' . $this->input->post('desde_mes') . '-' . $this->input->post('desde_dia');
                $hasta = $this->input->post('hasta_year') . '-' . $this->input->post('hasta_mes') . '-' . $this->input->post('hasta_dia');
                $rango = "AND fecha BETWEEN '" . $desde . "' AND  '" . $hasta . "'  ";
            } else {
                $rango = "";
            }

            //echo "sort viene= ".$sort."<br><br>";

            if ($sort == 'Descendente') {
                $this->session->set_userdata('rep_sort', 'DESC');
            } elseif ($sort == 'Ascendente') {
                $this->session->set_userdata('rep_sort', 'ASC');
            } else {
                $sort = $this->session->userdata('rep_sort');
            }

            //tipos del form
            if ($tipo == 'Global') {
                $this->session->set_userdata('rep_tipo', 'global');
            } elseif ($tipo == 'Autolote') {
                $this->session->set_userdata('rep_tipo', 'lotes');
            } else {
                $tipo = $this->session->userdata('rep_tipo');
            }


            if ($orden != '') {

                if ($orden == 'usu') {
                    $orden = 'usuario';
                }
                if ($orden == 'sub') {
                    $orden = 'subidos';
                }
                if ($orden == 'apro') {
                    $orden = 'aprobados';
                }
                if ($orden == 'rech') {
                    $orden = 'rechazados';
                }
                if ($orden == 'ven') {
                    $orden = 'vendidos';
                }
                if ($orden == 'deb') {
                    $orden = 'de_baja';
                }

                $this->session->set_userdata('rep_orden', $orden);
            } elseif ($orden == '') {
                $this->session->set_userdata('rep_orden', 'usuario');
            }

            $orden = $this->session->userdata('rep_orden');

            $sort = $this->session->userdata('rep_sort'); //***************** sort

            $tipo = $this->session->userdata('rep_tipo');

            //echo 'tipo='.$tipo.'<br />';
            //echo 'sort final='.$sort.'<br />';

            $limite = 'LIMIT ' . $lap . ' , 12';

            if ($por_rango == 'Filtrar') {
                $data['reportes'] = $this->report_model->reporte_fecha($orden, $sort, $limite, $tipo, $rango); //sort: ASC o DESC
                $total = $this->report_model->reporte_fecha($orden, $sort, '', $tipo, $rango);
            } else {

                $data['reportes'] = $this->report_model->reporte($orden, $sort, $limite, $tipo, $rango); //sort: ASC o DESC
                $total = $this->report_model->reporte($orden, $sort, '', $tipo, $rango);
            }

            $this->load->library('pagination');

            $total_result = count($total);



            if ($total_result > 12) {

                $config['base_url'] = base_url() . 'index.php/site/reportes/';
                $config['total_rows'] = $total_result;
                $config['per_page'] = 12;
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
            }

            $data['template'] = 'template/reportes';

            $this->load->view('template/masterpage.php', $data);
        }
    }

    function reportes_detalle($lap = '0', $orden = '') {
        $data = $this->general();

        if (!$this->session->userdata('rep_sort')) {
            $this->session->set_userdata('rep_sort', 'ASC');
        }

        if (!$this->session->userdata('rep_tipo')) {
            $this->session->set_userdata('rep_tipo', 'global');
        }
        if (!$this->session->userdata('rep_estado')) {
            $this->session->set_userdata('rep_estado', 'todos');
        }

        $sort = $this->input->post('sort');
        $tipo = $this->input->post("tipo");
        $por_rango = $this->input->post("rango");
        $estado = $this->input->post("estado");

        if ($por_rango == 'Filtrar') {
            $desde = $this->input->post('desde_year') . '-' . $this->input->post('desde_mes') . '-' . $this->input->post('desde_dia');
            $hasta = $this->input->post('hasta_year') . '-' . $this->input->post('hasta_mes') . '-' . $this->input->post('hasta_dia');
            $rango = "AND fecha BETWEEN '" . $desde . "' AND  '" . $hasta . "'  ";
        } else {
            $rango = "";
        }

        if ($estado != "") {
            $this->session->set_userdata('rep_estado', $estado);
        } else {
            $estado = $this->session->userdata('rep_estado');
        }
        //echo "sort viene= ".$sort."<br><br>";

        if ($sort == 'Descendente') {
            $this->session->set_userdata('rep_sort', 'DESC');
        } elseif ($sort == 'Ascendente') {
            $this->session->set_userdata('rep_sort', 'ASC');
        } else {
            $sort = $this->session->userdata('rep_sort');
        }

        //tipos del form
        if ($tipo == 'Global') {
            $this->session->set_userdata('rep_tipo', 'global');
        } elseif ($tipo == 'Autolote') {
            $this->session->set_userdata('rep_tipo', 'lotes');
        } else {
            $tipo = $this->session->userdata('rep_tipo');
        }

        if ($orden != '') {

            if ($orden == 'lot') {
                $orden = 'lote';
            }
            if ($orden == 'pla') {
                $orden = 'placa';
            }
            if ($orden == 'marc') {
                $orden = 'marca';
            }
            if ($orden == 'tipo') {
                $orden = 'tipo';
            }
            if ($orden == 'year') {
                $orden = 'year_';
            }
            if ($orden == 'ing') {
                $orden = 'ingreso';
            }
            if ($orden == 'prec') {
                $orden = 'precio';
            }
            if ($orden == 'vis') {
                $orden = 'visitas';
            }
            if ($orden == 'pre') {
                $orden = 'precalificado';
            }
            if ($orden == 'ant') {
                $orden = 'antiguedad';
            }

            $this->session->set_userdata('rep_orden', $orden);
        } elseif ($orden == '') {
            $this->session->set_userdata('rep_orden', 'usuario');
        }

        $orden = $this->session->userdata('rep_orden');
        $sort = $this->session->userdata('rep_sort'); //***************** sort
        $tipo = $this->session->userdata('rep_tipo');
        $estado = $this->session->userdata('rep_estado');

        //echo 'tipo='.$tipo.'<br />';
        //echo 'sort final='.$sort.'<br />';

        $limite = 'LIMIT ' . $lap . ' , 12';

        //if($por_rango=='Filtrar'){
        //   $data['reportes']=$this->data_model->reporte_detalle_fecha($orden,$sort,$limite,$tipo,$rango);//sort: ASC o DESC
        //    $total=$this->data_model->reporte_detalle_fecha($orden,$sort,'',$tipo,$rango);
        //}else{

        $data['reportes'] = $this->report_model->reporte_detalle($orden, $sort, $limite, $tipo, $rango, $estado); //sort: ASC o DESC
        $total = $this->report_model->reporte_detalle($orden, $sort, '', $tipo, $rango, $estado);
        //}

        $this->load->library('pagination');

        $total_result = count($total);

        //echo '<br /> rango='.$por_rango.'<br />'; 

        if ($total_result > 12) {

            $config['base_url'] = base_url() . 'index.php/site/reportes_detalle/';
            $config['total_rows'] = $total_result;
            $config['per_page'] = 12;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
        }

        $data['template'] = 'template/reportes_detalles';

        $this->load->view('template/masterpage.php', $data);
    }

    function vehiculosvendidos() {
        

                if (!$this->session->userdata('CategoriaActual')) {
            $this->session->set_userdata('CategoriaActual', 'todas');
        }

        $data = $this->general();

        //echo '<br />id_banner=' . $data['bannersPosition'][0]['id_banner'];
        //definimos limites de la consulta
        $desde = $this->session->userdata('lapso_actual');

        $limite = "LIMIT " . $desde . ", 12";

        //Productos (Carros)
        date_default_timezone_set('America/El_Salvador');
        //Productos (Carros)
        $data['products'] = $this->filter_model->getProducts(date('Y') - 11, date('Y'), '', '', '', '', 'todas', '', '', '', $limite,'',0);

        $consulta_sin_limite = $this->filter_model->getProducts(date('Y') - 11, date('Y'), '', '', '', '', 'todas', '', '', '', '','',0);

        $total_resultados = count($consulta_sin_limite);
        //Marcas
        $data['marks'] = $this->data_model->getMarks();
        //mostrar todo
        $data['filtro'] = TRUE; //mostramos vista filtro

        $data['combustibles'] = $this->data_model->getcombus();
        $data['total_resultados'] = $total_resultados;
        $data['paginacion'] = $this->filter_model->paginar($total_resultados, 12, 6, "filter_charact");

       

        $data['template'] = 'template/vendidos/vehiculosvendidos.php';

        //datos para el arbol de la vista
        $data['f_mark'] = 'todos';
        $data['f_model'] = '';
        $data['f_tipo_vehiculo'] = '';
        $data['f_combustible'] = '';
        $data['f_financiamiento'] = '';
        $data['f_recomendados'] = '';
        $data['f_transmision'] = '';

        $vista = $this->session->userdata('vista_actual');

        if ($vista == 1) {
            $data['vista1'] = TRUE; //mostramos vista 1
        } elseif ($vista == 2) {
            $data['vista2'] = TRUE; //mostramos vista 2
        } else {
            $data['vista1'] = TRUE; //mostramos vista 1
        }
        
        
        ////////////////////////////////////////
        $year = $this->input->post('year');
        $year_hasta = $this->input->post('year_hasta');

        $mark = $this->input->post('marca');
        $model = $this->input->post('modelo');
        $start_price = $this->input->post('desde');
        $end_price = $this->input->post('hasta');
        $tipo_vehiculo = $this->input->post('tipo_v');
        $combustible = $this->input->post('combustible');
        $financiamiento = $this->input->post('financiamiento');
        $recomendados = $this->input->post('$recomendados');
        $transmision = $this->input->post('transmision');
        $ingreso = $this->input->post('tipo_ingreso');

        //DATOS DE PAGINACION
        $lapso_actual = $this->input->post('lapso_actual'); //seccion de paginas que se van a mostrar en lista de paginas ej. 25-30
        $pagina_actual = $this->input->post('pagina_actual');
        $vista_actual = $this->input->post('vista_actual');
        $orden_actual = $this->input->post('orden');

        if ($lapso_actual != '') {//guardamos en variables de session para que se muestren seleccionados los listbox en formularios y paginacion
            $lapso_actual = htmlentities($lapso_actual);
            $this->session->set_userdata('lapso_actual', $lapso_actual);
            
        } elseif (!$this->session->userdata('lapso_actual')) {
            $this->session->set_userdata('lapso_actual', '0');
        }

        if ($pagina_actual != '') {
            $pagina_actual = htmlentities($pagina_actual);
            $this->session->set_userdata('pagina_actual', $pagina_actual);
            
        } elseif (!$this->session->userdata('pagina_actual')) {
            $this->session->set_userdata('pagina_actual', '1');
        }

        if ($vista_actual != '') {
            $vista_actual = htmlentities($vista_actual);
            $this->session->set_userdata('vista_actual', $vista_actual);
        } elseif (!$this->session->userdata('vista_actual')) {
            $this->session->set_userdata('vista_actual', '1');
        }
        if ($orden_actual != '') {
            $orden_actual = htmlentities($orden_actual);
            $this->session->set_userdata('orden_actual', $orden_actual);
        } elseif (!$this->session->userdata('orden_actual')) {
            $this->session->set_userdata('orden_actual', '1');
        }

        //definimos limites de la consulta
        $desde = $this->session->userdata('lapso_actual');

        $limite = "LIMIT " . $desde . ", 12";

        //echo 'limite = '.$limite;


        //paginacion
       // $data['total_resultados'] = $total_resultados;
        //$data['paginacion'] = $this->filter_model->paginar($total_resultados, 12, 6, "filter_charact");
       


        
       
        $this->load->view('template/masterpage.php', $data);
    }
    
    /*INI INI - Modificado por: GGONZALEZ - 25/01/2015 */ 
     function recomendados() {
        
                if (!$this->session->userdata('CategoriaActual')) {
            $this->session->set_userdata('CategoriaActual', 'todas');
        }

        $data = $this->general();

        //echo '<br />id_banner=' . $data['bannersPosition'][0]['id_banner'];
        //definimos limites de la consulta
        $desde = $this->session->userdata('lapso_actual');

        $limite = "LIMIT " . $desde . ", 12";

        //Productos (Carros)
        date_default_timezone_set('America/El_Salvador');
        //Productos (Carros)
        $data['products'] = $this->filter_model->getProducts(date('Y') - 11, date('Y'), '', '', '', '', 'todas', '', '', '', $limite,'',1);

        $consulta_sin_limite = $this->filter_model->getProducts(date('Y') - 11, date('Y'), '', '', '', '', 'todas', '', '', '', '','',1);

        $total_resultados = count($consulta_sin_limite);
        //Marcas
        $data['marks'] = $this->data_model->getMarks();
        //mostrar todo
        $data['filtro'] = TRUE; //mostramos vista filtro

        $data['combustibles'] = $this->data_model->getcombus();
        $data['total_resultados'] = $total_resultados;
        $data['paginacion'] = $this->filter_model->paginar($total_resultados, 12, 6, "filter_charact");
        $data['template'] = 'template/recomendados/recomendado.php';

        //datos para el arbol de la vista
        $data['f_mark'] = 'todos';
        $data['f_model'] = '';
        $data['f_tipo_vehiculo'] = '';
        $data['f_combustible'] = '';
        $data['f_recomendados'] = '';
        $data['f_transmision'] = '';

        $vista = $this->session->userdata('vista_actual');

        if ($vista == 1) {
            $data['vista1'] = TRUE; //mostramos vista 1
        } elseif ($vista == 2) {
            $data['vista2'] = TRUE; //mostramos vista 2
        } else {
            $data['vista1'] = TRUE; //mostramos vista 1
        }
        
        
        ////////////////////////////////////////
        $year = $this->input->post('year');
        $year_hasta = $this->input->post('year_hasta');

        $mark = $this->input->post('marca');
        $model = $this->input->post('modelo');
        $start_price = $this->input->post('desde');
        $end_price = $this->input->post('hasta');
        $tipo_vehiculo = $this->input->post('tipo_v');
        $combustible = $this->input->post('combustible');
        $recomendados = $this->input->post('recomendados');
        $financiamiento = $this->input->post('financiamiento');
        $transmision = $this->input->post('transmision');
        $ingreso = $this->input->post('tipo_ingreso');

        //DATOS DE PAGINACION
        $lapso_actual = $this->input->post('lapso_actual'); //seccion de paginas que se van a mostrar en lista de paginas ej. 25-30
        $pagina_actual = $this->input->post('pagina_actual');
        $vista_actual = $this->input->post('vista_actual');
        $orden_actual = $this->input->post('orden');

        if ($lapso_actual != '') {//guardamos en variables de session para que se muestren seleccionados los listbox en formularios y paginacion
            $lapso_actual = htmlentities($lapso_actual);
            $this->session->set_userdata('lapso_actual', $lapso_actual);
        } elseif (!$this->session->userdata('lapso_actual')) {
            $this->session->set_userdata('lapso_actual', '0');
        }

        if ($pagina_actual != '') {
            $pagina_actual = htmlentities($pagina_actual);
            $this->session->set_userdata('pagina_actual', $pagina_actual);
        } elseif (!$this->session->userdata('pagina_actual')) {
            $this->session->set_userdata('pagina_actual', '1');
        }

        if ($vista_actual != '') {
            $vista_actual = htmlentities($vista_actual);
            $this->session->set_userdata('vista_actual', $vista_actual);
        } elseif (!$this->session->userdata('vista_actual')) {
            $this->session->set_userdata('vista_actual', '1');
        }
        if ($orden_actual != '') {
            $orden_actual = htmlentities($orden_actual);
            $this->session->set_userdata('orden_actual', $orden_actual);
        } elseif (!$this->session->userdata('orden_actual')) {
            $this->session->set_userdata('orden_actual', '1');
        }

        //definimos limites de la consulta
        $desde = $this->session->userdata('lapso_actual');

        $limite = "LIMIT " . $desde . ", 12";

        //echo 'limite = '.$limite;

        if (!$this->session->userdata('category')) {

            //echo '<br>year='.$year.'<br/>'; 
            //echo '<br>year='.$year_hasta.'<br>';

            $data['products'] = $this->filter_model->getProductsRecomendados($limite, $ingreso,1);
            //vaciamos limite para obtener la consulta de todos los autos con exactamente los mismos criterios
            $consulta_sin_limite = $this->filter_model->getProductsRecomendados("",$ingreso,1);
            $total_resultados = count($consulta_sin_limite);
        }

        //paginacion
        $data['total_resultados'] = $total_resultados;
        $data['paginacion'] = $this->filter_model->paginar($total_resultados, 12, 6, "filter_charact");

        //datos de busqueda, si son cero resultados guardamos marca modelo y año
        if ($total_resultados < 1) {
            $this->Savedata_model->guardar_buscado($mark, $model, $year);
        }

        if ($transmision == 'A') {
            $transmision = 'Automatica';
        }
        if ($transmision == 'M') {
            $transmision = 'Manual';
        }

        if ($financiamiento == '0') {
            $financiamiento = 'Sin financiamiento';
        }
        if ($financiamiento == '1') {
            $financiamiento = 'Con financiamiento';
        }
        
         if ($recomendados == '1') {
            $recomendados = 'Recomendacion de CrediQ';
        }
/*FIN- Modificado por: GGONZALEZ - 25/01/2015 */ 

        if ($tipo_vehiculo != "") {
            $f_mark = array();
            $f_model = array();
            $f_tipo_vehiculo = array();
            $f_combustible = array();
            //datos para el reporte de busqueda

            if ($tipo_vehiculo != "todas") {
                $f_tipo_vehiculo = $this->data_model->getCampo('nombre', 'cq_tipo_vehiculo', 'id_tipo_vehiculo', $tipo_vehiculo);
                //$f_tipo_vehiculo = $this->data_model->getCategoriasExistentes();

                $f_tipo_vehiculo['nombre'] = $f_tipo_vehiculo['nombre'] . '.';
            } else {
                $f_tipo_vehiculo['nombre'] = "";
            }
            if ($tipo_vehiculo == "todas") {
                $f_tipo_vehiculo['nombre'] = "todas";
            }
            if ($mark != "") {
                $f_mark = $this->data_model->getCampo('nombre', 'cq_marca', 'id_marca', $mark);
                $f_mark['nombre'] = $f_mark['nombre'] . '.';
            } else {
                $f_mark['nombre'] = "";
            }
            if ($model != "") {
                $f_model = $this->data_model->getCampo('nombre', 'cq_modelo', 'id_modelo', $model);
                $f_model['nombre'] = $f_model['nombre'] . '.';
            } else {
                $f_model['nombre'] = "";
            }

            if ($combustible != "") {
                $f_combustible = $this->data_model->getCampo('nombre', 'cq_tipo_combustible', 'id_tipo_combustible', $combustible);
                $f_combustible['nombre'] = $f_combustible['nombre'] . '.';
            } else {
                $f_combustible['nombre'] = "";
            }

            $new_info = $f_mark['nombre'] . $f_model['nombre'] . $f_tipo_vehiculo['nombre'] . $f_combustible['nombre'] . $recomendados;
            $this->session->set_userdata('info_busqueda', $new_info);
            $data['informe'] = $new_info;
        } else {
            if (!$this->session->userdata('info_busqueda')) {
                $data['informe'] = "";
            } else {
                $data['informe'] = $this->session->userdata('info_busqueda');
            }
        }
        
        
        $this->load->view('template/masterpage.php', $data);
    }


}
