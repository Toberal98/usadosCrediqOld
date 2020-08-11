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

    function __construct() {
        parent::__construct();
        $this->load->model('bid_model');
        $this->load->model('data_model');
        $this->load->model('function_model');
        $this->load->model('Savedata_model');
        $this->load->library('session');
        $this->load->library('prestamo');
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

    function ver($id) {
        //$this->session->set_userdata('pais', 1);
        $this->session->set_userdata('present_id', $id);

        //datos generales
        $data = $this->general();

        //*******************************************************inyectamos hits**********************************************************
        //********************************************************************************************************************************
        $this->data_model->inyectarHit($id);

        //***********************************************************************************************************************

        $data['visto'] = $this->data_model->getAllHits($id);

        //Informacion vendedor

        $data['vendedorinfo'] = $this->data_model->getInfoVendedor($id);

        //Productos (Carros)
        error_log("\r\n-->Pais:: ".$this->session->userdata('pais')."\r\n", 3, dirname(__FILE__)."/log.log");

        $data['car'] = $this->data_model->getCar($id, $this->session->userdata('pais'));

        $this->Savedata_model->guardar_buscado($data['car']['id_marca'], $data['car']['id_modelo'], $data['car']['year']);
        //Similares
        $data['similares'] = $this->data_model->Similares($id, $data['car']['usuario'], $this->session->userdata('pais'));

        //Colores del Carro
        $data['color_interior'] = $this->data_model->getColor($data['car']['color_interno']);
        $data['color_exterior'] = $this->data_model->getColor($data['car']['color_externo']);
        //Marcas
        $data['marks'] = $this->data_model->getMarks();


        $nuevo_hit = $data['car']['hits'] + 1;
        $where_hit = array('id_automovil' => $id);
        $datos_hit = array('hits' => $nuevo_hit);

        $this->Savedata_model->actualizar($where_hit, 'cq_automovil', $datos_hit);

        $data['equipamiento'] = $this->data_model->GetEquipamiento($id);
        $data['equipamientolist'] = $this->data_model->GetEquipamientoList();

        //mostrar todo
        $data['filtro'] = TRUE; //mostramos vista filtro

           /*MODIFICADO POR GGONZALEZ 26/05/2015 -  INI*/

        $data['CAMPOS_MATRIZ'] = $this->data_model->getCamposMatriz($data['car']['year'], $this->session->userdata('pais'));

         /*MODIFICADO POR GGONZALEZ 26/05/2015 -  FIN*/

        $tasaInteresPar = $data['CAMPOS_MATRIZ']['tasa'];
        $plazoPar = $data['CAMPOS_MATRIZ']['plazo'];
		$recargo = $data['CAMPOS_MATRIZ']['recargo'];

        // Calcular la cuota minima.
        // Creamos el objeto préstamo y le decimos que queremos una exactitud de 10 dígitos después de la coma.
        $prestamo = new Prestamo(10);
        // Configuramos el valor que pedimos de préstamo.
        $capital = $data['car']['precio'];
        $prestamo->setCapital($capital);

        $prestamo->setTasaInteres($tasaInteresPar / 100 / 12);
		// CAAR .- Se agrego un recargo a la cuota que corresponde al GPS - 20170809
		$prestamo->setRecargo($recargo);
        $cuota = $prestamo->calcCuota($plazoPar);

        $cuota = number_format((float) $cuota, 2, '.', '');
        $data['car']['cuotaMin'] = $cuota;


        $var = array(
            'sesion' => 'vistos',
            'id' => $id,
            'limit' => 8
        );

        $this->function_model->comunes($var); //inyectamos id

        $data['tumbnails'] = $this->data_model->getTumbnails($id);

        if (count($data['tumbnails']) < 1) {
            $data['tumbnails'] = 0;
        }
        $data['template'] = 'template/car.php';
        $data['title'] = utf8_decode($data["car"]["estilo"]);
        $this->load->view('template/masterpage.php', $data);
    }

    function subasta($id) {
        //$this->session->set_userdata('pais', 1);
        $this->session->set_userdata('present_id', $id);

        //datos generales
        $data = $this->general();

        //*******************************************************inyectamos hits**********************************************************
        //********************************************************************************************************************************
        // $this->data_model->inyectarHit($id);

        //***********************************************************************************************************************

        $data['visto'] = $this->data_model->getAllHits($id);

        //Informacion vendedor

        $data['vendedorinfo'] = $this->data_model->getInfoVendedor($id);

        //Productos (Carros)
        error_log("\r\n-->Pais:: ".$this->session->userdata('pais')."\r\n", 3, dirname(__FILE__)."/log.log");

        $data['car'] = $this->data_model->getCar($id, $this->session->userdata('pais'));

        $data['bids'] = $this->bid_model->getBidsForCar($data['car']['id_automovil']);

        $this->Savedata_model->guardar_buscado($data['car']['id_marca'], $data['car']['id_modelo'], $data['car']['year']);
        //Similares
        $data['similares'] = $this->data_model->Similares($id, $data['car']['usuario'], $this->session->userdata('pais'));

        //Colores del Carro
        $data['color_interior'] = $this->data_model->getColor($data['car']['color_interno']);
        $data['color_exterior'] = $this->data_model->getColor($data['car']['color_externo']);
        //Marcas
        $data['marks'] = $this->data_model->getMarks();


        $nuevo_hit = $data['car']['hits'] + 1;
        $where_hit = array('id_automovil' => $id);
        $datos_hit = array('hits' => $nuevo_hit);

        $this->Savedata_model->actualizar($where_hit, 'cq_automovil', $datos_hit);

        $data['equipamiento'] = $this->data_model->GetEquipamiento($id);
        $data['equipamientolist'] = $this->data_model->GetEquipamientoList();

        //mostrar todo
        $data['filtro'] = TRUE; //mostramos vista filtro

           /*MODIFICADO POR GGONZALEZ 26/05/2015 -  INI*/

        $data['CAMPOS_MATRIZ'] = $this->data_model->getCamposMatriz($data['car']['year'], $this->session->userdata('pais'));

         /*MODIFICADO POR GGONZALEZ 26/05/2015 -  FIN*/

        $tasaInteresPar = $data['CAMPOS_MATRIZ']['tasa'];
        $plazoPar = $data['CAMPOS_MATRIZ']['plazo'];

        // Calcular la cuota minima.
        // Creamos el objeto préstamo y le decimos que queremos una exactitud de 10 dígitos después de la coma.
        $prestamo = new Prestamo(10);
        // Configuramos el valor que pedimos de préstamo.
        $capital = $data['car']['precio'];
        $prestamo->setCapital($capital);

        $prestamo->setTasaInteres($tasaInteresPar / 100 / 12);
        $cuota = $prestamo->calcCuota($plazoPar);

        $cuota = number_format((float) $cuota, 2, '.', '');
        $data['car']['cuotaMin'] = $cuota;


        $var = array(
            'sesion' => 'vistos',
            'id' => $id,
            'limit' => 8
        );

        $this->function_model->comunes($var); //inyectamos id

        $data['tumbnails'] = $this->data_model->getTumbnails($id);

        if (count($data['tumbnails']) < 1) {
            $data['tumbnails'] = 0;
        }

        $data['template'] = 'template/car_bids.php';
        $data['title'] = utf8_decode($data["car"]["estilo"]);
        $data['mine'] = $this->session->userdata('user_id') == $data['car']['usuario'] || $this->session->userdata('user_perfil') == '1';

        $this->load->view('template/masterpage.php', $data);
    }

    function detalle($id) {
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1, 2))) {
            redirect(base_url());
        } else {
            //$this->session->set_userdata('pais', 1);
            //Categorias (Tipos de Vehiculo)
            //datos generales
            $data = $this->general();
            //Productos (Carros)
            $data['car'] = $this->data_model->getUserCar($id, $this->session->userdata('pais'));
            //Colores del Carro
            $data['color_interior'] = NULL;
            $data['color_exterior'] = NULL;
            //Marcas
            $data['marks'] = $this->data_model->getMarks();

            $data['tumbnails'] = $this->data_model->getTumbnails($id);

            if (count($data['tumbnails']) < 1) {
                $data['tumbnails'] = 0;
            }
            $data['equipamiento'] = $this->data_model->GetEquipamiento($id);
            $data['visto'] = $this->data_model->getAllHits($id);
            $data['equipamientolist'] = $this->data_model->GetEquipamientoList();

            $data['autorizing'] = true;
            //mostrar todo
            $data['template'] = 'template/car.php';
            $this->load->view('template/masterpage.php', $data);
        }
    }

    function ver_names() {

        echo '<br/>imagen1=' . $this->session->userdata('imagen1');
        echo '<br/>imagen2=' . $this->session->userdata('imagen2');
        echo '<br/>imagen3=' . $this->session->userdata('imagen3');
        echo '<br/>imagen4=' . $this->session->userdata('imagen4');
    }

    //Protegido por session
    function add($tipo_venta = 0) {
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1, 2))) {
            redirect(base_url());
        } else {
            if (((int) $this->session->userdata('user_perfil')) !== 1) {
                $tipo_venta = 1;
            }

            $tipo_venta = (int) $tipo_venta;

            if (!in_array($tipo_venta, [1, 2, 3], true)) {
                $data['template'] = 'template/add-producto-select';
                $this->load->view('template/masterpage', $data);
            } else { // si es usuario normal o ya se seteo el tipo
                //datos generales
                $data = $this->general();
                $data['allcategories'] = $this->data_model->allCategories();
                //Datos para seleccionar
                $data['marks'] = $this->data_model->getMarks();
                $data['combustibles'] = $this->data_model->getcombus();
                $data['colors'] = $this->data_model->getcolors();

                $data['equipamiento_list'] = $this->data_model->getData('cq_equipamiento');
                $data['departamentos'] = $this->data_model->getDepartamentos($this->session->userdata('pais'));

                $data['tipo_venta'] = $tipo_venta;
                $data['template'] = 'template/add-producto';
                $this->load->view('template/masterpage', $data);
            }
        }
    }

    function estado($estado, $pagina=0,$placa='') {
        //if($pagina==""){$pagina=1;}
        if (!$this->session->userdata('user_id') or $this->session->userdata('user_perfil') != '1') {
            redirect(base_url());
        } else {
            //datos generales
            $data = $this->general();
            //Get Active Cars
            $limite = "LIMIT " . $pagina . ', 12';
            //$sinlimite = "0";
            //echo '<br/> pais='.$this->session->userdata('pais');
			
			 if ($estado == 'pendiente') {
                $data['cars'] = $this->data_model->getpendientes($this->session->userdata('pais'), $estado, $limite);
				//$data['activeCars'] = $this->data_model->getUserCars($this->session->userdata('user_id'));
				$data['template'] = 'template/autorizar.php';
                $sinlimite = $this->data_model->getpendientes($this->session->userdata('pais'), $estado, '');
				//$sinlimiteActive = $this->data_model->getUserCars($this->session->userdata('user_id'));
				//$sinlimit=$sinlimit+$sinlimiteActive;
            }

            if ($estado == 'userPendiente') {
				$estados='pendiente';
				//echo $placa;
				//echo $limite;
				$data['cars'] = $this->data_model->getUserPendientes($this->session->userdata('user_id'), $estados, $limite, $placa,$this->session->userdata('pais'));
				//getUser_Pendientes($idUsuario, $estado, $limite, $pais = 1){
				$data['template'] = 'template/userPendiente.php';  
				$sinlimite = $this->data_model->getUserPendientes($this->session->userdata('user_id'),$estados,'',$placa,$this->session->userdata('pais'));
				
				//print_r($data['cars']);
            }

			if ($estado == 'aprobado-admin') {
                $estado2 = 'aprobado';
                $data['cars'] = $this->data_model->carsbystado($this->session->userdata('pais'), $estado2, $limite,$placa);
                $sinlimite = $this->data_model->carsbystado($this->session->userdata('pais'), $estado2, '',$placa);
                $data['template'] = 'template/administrar';
                $data['tendencias_marca'] = $this->data_model->tendencias_marcas();
                $data['tendencias_modelos'] = $this->data_model->tendencias_modelos();
            }

            if ($estado == 'aprobado-hits') {
                $estado2 = 'aprobado';
                $data['cars'] = $this->data_model->carsbystado($this->session->userdata('pais'), $estado2, $limite);
                $sinlimite = $this->data_model->carsbystado($this->session->userdata('pais'), $estado2, '');
                $data['topMarca'] = $this->data_model->statTopMarca();
                $data['TopModelo'] = $this->data_model->statTopModelo();
                $data['TopAnio'] = $this->data_model->statTopAnio();

                $data['template'] = 'template/estadisticas.php';
            }


            if ($estado == 'aprobado-hits_2') {

                $estado2 = 'aprobado';
                $data['cars'] = $this->data_model->carsbystado($this->session->userdata('pais'), $estado2, $limite);
                $sinlimite = $this->data_model->carsbystado($this->session->userdata('pais'), $estado2, '');

                $data['topMarca'] = $this->data_model->statTopMarca();
                $data['TopModelo'] = $this->data_model->statTopModelo();
                $data['TopAnio'] = $this->data_model->statTopAnio();

                $data['template'] = 'template/estadisticas_2';
            }

            $this->load->library('pagination');

            $total_result = count($sinlimite);

            if ($total_result > 12) {

                $config['base_url'] = base_url() . 'index.php/car/estado/' . $estado;
                $config['total_rows'] = $total_result;
                $config['per_page'] = 12;
                $config['uri_segment'] = 4;
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
            }

            $this->load->view('template/masterpage', $data);
        }
    }

    function estadisticas($id) {
        if (!$this->session->userdata('user_id') or $this->session->userdata('user_perfil') != '1') {
            redirect(base_url());
        } else {
            $data = $this->general();

            //Productos (Carros)
            $data['car'] = $this->data_model->getCar($id, $this->session->userdata('pais'));
            //Marcas
            $data['marks'] = $this->data_model->getMarks();

            $data['tumbnails'] = $this->data_model->getTumbnails($id);
            if (count($data['tumbnails']) < 1) {
                $data['tumbnails'] = 0;
            }

            $data['estadisticas'] = $this->data_model->gethits($id);
            $data['estadisticas_clicks'] = $this->data_model->getclicks($id);

            $data['template'] = 'template/panel-estadistica';
            $this->load->view('template/masterpage', $data);
        }
    }

//
    function aprobar($id) {
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1, 2))) {
            redirect(base_url());
        } else {
            $data = $this->general();

            //Aprobar!

            $this->Savedata_model->aprobarCar($id);

            //sacamos car
            $car = $this->data_model->getCar($id, $this->session->userdata('pais'));



            $userTo = $this->data_model->getOneUser($car['usuario']);

            $datos = array('tipo' => 'fue_aprobado',
                'marca' => $car['marca'],
                'modelo' => $car['modelo'],
                'to' => $userTo['email'],
                'nombres' => $userTo['nombres'],
                'apellidos' => $userTo['apellidos']
            );
            //
            if ($this->function_model->enviarMail($datos)) {
                //redirect('car/detalle/' . $id);
            } else {
                $data['tipo'] = '32';
            }

            $data['tipo'] = '31'; //mostramos vista filtro
            $data['template'] = 'template/aviso';
            $this->load->view('template/masterpage.php', $data);
        }
    }

    function rechazar($id) {
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1, 2))) {
            redirect(base_url());
        } else {
            $data = $this->general();
            //Rechazar!

            $where = array('id_automovil' => $id);
            $upd = array('estado' => 'Rechazado');

            $this->load->model('savedata_model');
            $this->Savedata_model->actualizar($where, 'cq_automovil', $upd);

            $data['tipo'] = '33'; //mostramos vista filtro
            $data['template'] = 'template/aviso';

            $this->load->view('template/masterpage', $data);
        }
    }

    function comparar($id = "") {
        //datos generales
        $data = $this->general();

        $var = array(
            'sesion' => 'comparar', //nombre de la sesion
            'id' => $id,
            'limit' => 4
        );
        $total_ids = 0;
        $ids = 0;
        if ($id != "") {
            $comunes = $this->function_model->comunes($var);

            $total_ids = $comunes['total_ids']; //el total de id's
            $ids = $comunes['ids']; // y el listado de id's
        } else {
            $ids = $this->session->userdata('comparar');
            $total_ids = count($ids);
        }
        if ($ids == "") {
            redirect(base_url() . 'index.php/site/aviso/26');
        }
        //echo 'total ids='.$total_ids;
        //echo '<br />total_ids='.$total_ids;
        for ($i = 1; $i <= $total_ids; $i++) { //por cada id sacamos un carro
            $data['car'][$i] = $this->data_model->getCar($ids[$i], $this->session->userdata('pais')); //guardamos los datos de cada carro en un array con indice comenzano desd 1

            $data['total_comparar'] = $total_ids; //PARA la vista el total de autos comparados
            //echo '<br />id= '.$data['car'][$i]['id_automovil'];
        }

        //para el panel de otros vistos
        //sacamos lista vehiculos navegados
        $vistos = $this->session->userdata('vistos');

        $total_navegados = count($vistos);
        $mostrar = 0;
        //echo 'total navegados='.$total_navegados;

        if ($total_navegados > 4) {
            for ($i = 1; $i <= $total_navegados; $i++) {

                if (!in_array($vistos[$i], $ids)) {
                    $mostrar++;
                    $data['car_visto'][$mostrar] = $this->data_model->getCar($vistos[$i], $this->session->userdata('pais'));
                }
                if ($mostrar >= 4) {
                    break;
                }
            }
        } elseif ($total_navegados <= 4 and $total_navegados > 0) {

            for ($i = 1; $i <= $total_navegados; $i++) {
                //verificamos que el id a mostrar no este en los ids comparados
                if ($ids != 0) {
                    if (!in_array($vistos[$i], $ids)) {
                        $mostrar++; //PARA la vista
                        $data['car_visto'][$mostrar] = $this->data_model->getCar($vistos[$i], $this->session->userdata('pais'));
                    }
                } else {
                    $mostrar++; //PARA la vista
                    $data['car_visto'][$mostrar] = $this->data_model->getCar($vistos[$i], $this->session->userdata('pais'));
                }

                //echo '<br />'.$vistos[$i];
            }
        }

        $data['mostrar'] = $mostrar;
        //echo "VEHICULOS A MOSTRAR " . $mostrar;

        $data['marks'] = $this->data_model->getMarks();

        $data['tumbnails'] = $this->data_model->getTumbnails($id);

        $data['equipamiento_list'] = $this->data_model->GetEquipamientoList();

        //$data['equipamiento']=$this->data_model->GetEquipamiento($id);
        //mostrar todo
        $data['filtro'] = TRUE; //mostramos vista filtro
        $data['template'] = 'template/comparar';
        $this->load->view('template/masterpage.php', $data);
    }

    function removeComparar($id) {//suma un hits a un auto en cada aparicion en pantalla
        if ($id == '') {
            redirect(base_url() . 'index.php/car/comparar');
        }

        $var = array(
            'sesion' => 'comparar', //nombre de la sesion que contendra el arreglo
            'id' => $id, //el id que vamos a agregar
            'limit' => 4 //limite de ids que puden permanecer en el arreglo,
        );

        if ($this->session->userdata('comparar')) {

            echo '<br />Seccion existe<br />';

            $ids = $this->session->userdata('comparar');


            $i = 1;
            foreach ($ids as $id_car) {//recorremos el arreglo
                ///filtro, como escoger frijoles =)
                if ($id_car != $id) {//reconstruimos el arreglo y excluimos y excluimos el valor
                    $nuevos_ids[$i] = $id_car;
                    $i++;
                }
            }

            $this->session->set_userdata('comparar', $nuevos_ids); //guardamos el arreglo nuevamente
            redirect(base_url() . 'index.php/car/comparar');
        }
    }

    function quitar($id) {
        //datos generales
        $data = $this->general();

        $var = array(
            'sesion' => 'comparar',
            'id' => $id,
            'limit' => 4
        );

        $comunes = $this->function_model->comunes($var);

        $total_ids = $comunes['total_ids']; //el total de id's
        $ids = $comunes['ids']; // y el listado de id's
        //echo '<br />total_ids='.$total_ids;
        for ($i = 1; $i <= $total_ids; $i++) { //por cada id sacamos un carro
            $data['car'][$i] = $this->data_model->getCar($ids[$i], $this->session->userdata('pais'));
            $data['total_comparar'] = $total_ids; //PARA la vista
            //echo '<br />id= '.$data['car'][$i]['id_automovil'];
        }

        //para el panel de otros vistos
        //sacamos lista vehiculos navegados
        $vistos = $this->session->userdata('vistos');

        $total_navegados = count($vistos);
        $mostrar = 0;
        //echo 'total navegados='.$total_navegados;

        if ($total_navegados > 4) {
            for ($i = 1; $i <= $total_navegados; $i++) {

                if (!in_array($vistos[$i], $ids)) {
                    $mostrar++;
                    $data['car_visto'][$mostrar] = $this->data_model->getCar($vistos[$i], $this->session->userdata('pais'));
                }
                if ($mostrar >= 4) {
                    break;
                }
            }
        } elseif ($total_navegados <= 4 and $total_navegados > 0) {

            for ($i = 1; $i <= $total_navegados; $i++) {
                //verificamos que el id a mostrar no este en los ids comparados
                if (!in_array($vistos[$i], $ids)) {

                    $mostrar++; //PARA la vista
                    $data['car_visto'][$mostrar] = $this->data_model->getCar($vistos[$i], $this->session->userdata('pais'));
                }
                //echo '<br />'.$vistos[$i];
            }
        }

        $data['mostrar'] = $mostrar;

        $data['marks'] = $this->data_model->getMarks();

        $data['tumbnails'] = $this->data_model->getTumbnails($id);

        //$data['equipamiento']=$this->data_model->GetEquipamiento($id);
        //mostrar todo
        $data['filtro'] = TRUE; //mostramos vista filtro
        $data['template'] = 'template/comparar';
        $this->load->view('template/masterpage.php', $data);
    }

    function add_autolote() {
        $data = $this->general();

        //$data['equipamiento']=$this->data_model->GetEquipamiento($id);
        //mostrar todo
        //$data['filtro'] = TRUE;//mostramos vista filtro
        $data['template'] = 'template/add-autolote';
        $this->load->view('template/masterpage.php', $data);
    }

    function administrar($action, $id) {

        if (!$this->session->userdata('user_id')) {
            redirect(base_url());
        }
        if ($this->session->userdata('user_perfil') != '1') {
            redirect(base_url());
        }

        $data = $this->general();

        $data['equipamiento_list'] = $this->data_model->getData('cq_equipamiento');
        $data_where = array('id_auto' => $id);
        $data['equipamiento'] = $this->data_model->getDataWhere($data_where, 'cq_auto_x_equipamiento');

		  /* MODIFICADO POR GGONZALEZ 13/05/2015 INI*/

		$data['info_clientes'] = $this->data_model->getInfoCliente($id);
		$data['equipamiento_car'] = $this->data_model->getEquipamiento_sv($id);
        /* MODIFICADO POR GGONZALEZ 13/05/2015 FIN*/
        if (count($data['equipamiento']) < 1) {
            $data['equipamiento'] = 0;
        }

        //Productos (Carros)
        $data['car'] = $this->data_model->getUserCar($id, $this->session->userdata('pais'));

        //Marcas
        $data['marcas'] = $this->data_model->getMarks();
		//modelos
		 //echo 'marca actual'.$data['car']['id_marca'];
		$data['models'] = $this->data_model->ModelosPorMarca($data['car']['id_marca']);


        $data['combustibles'] = $this->data_model->getcombus();

        $data['colors'] = $this->data_model->getcolors();
        $data['departamentos'] = $this->data_model->getDepartamentos($this->session->userdata('pais'));
        $data['tumbnails'] = $this->data_model->getTumbnails($id);

        if (count($data['tumbnails']) < 1) {
            $data['tumbnails'] = 0;  //
        }

        $data['estadisticas'] = $this->data_model->gethits($id);

        $data['template'] = 'template/update-producto';
        $data['tipo_venta'] = $data['car']['tipo_venta'];

        $this->load->view('template/masterpage', $data);
    }

    function datos($action, $id) {
        $data = $this->general();
        //Productos (Carros)
        $data['car'] = $this->data_model->editUserCar($id, $this->session->userdata('pais'));

        if (!$this->session->userdata('user_id')) {
            redirect(base_url());
        }
        if ($this->session->userdata('user_perfil') != '1' and $this->session->userdata('user_perfil') != '2') {
            redirect(base_url());
        }
        if ($this->session->userdata('user_id') != $data['car']['usuario']) {
            redirect(base_url());
        }
        //echo '<br>user_perfil'.$this->session->userdata('user_perfil');
        //echo '<br>user_id'.$this->session->userdata('user_id');
        //echo '<br>car_usuario'.$data['car']['id_usuario'];


  /* MODIFICADO POR GGONZALEZ 13/05/2015 INI*/

        $data['equipamiento_list'] = $this->data_model->getData('cq_equipamiento');
		$data['equipamiento_car'] = $this->data_model->getEquipamiento_sv($id);
		$data['info_clientes'] = $this->data_model->getInfoCliente($id);

 /* MODIFICADO POR GGONZALEZ 13/05/2015 FIN*/

        $data_where = array('id_auto' => $id);
        $data['equipos'] = $this->data_model->getDataWhere($data_where, 'cq_auto_x_equipamiento');

        if (count($data['equipos']) < 1) {
            $data['equipos'] = 0;
        }

        //Marcas
        $data['marks'] = $this->data_model->getMarks();
		//modelos
		$data['models'] = $this->data_model->ModelosPorMarca($data['car']['id_marca']);

        $data['combustibles'] = $this->data_model->getcombus();

        $data['colors'] = $this->data_model->getcolors();
        $data['departamentos'] = $this->data_model->getDepartamentos($this->session->userdata('pais'));
        $data['tumbnails'] = $this->data_model->getTumbnails($id);

        if (count($data['tumbnails']) < 1) {
            $data['tumbnails'] = 0;  //
        }

        $data['estadisticas'] = $this->data_model->gethits($id);

        $data['tipo_venta'] = $data['car']['tipo_venta'];
        $data['template'] = 'template/edit_user_car';

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
        } elseif ($action == 'borrar') {

            $this->Savedata_model->actualizar(array('id_automovil' => $id), 'cq_automovil', array('estado' => 'eliminado')); //borramos imagen

            redirect(base_url() . 'index.php/car/estado/userPendiente');
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

    function administrar_2($action, $id) {

        if (!$this->session->userdata('user_id')) {
            redirect(base_url());
        }
        if ($this->session->userdata('user_perfil') != '1') {
            redirect(base_url());
        }

        //Productos (Carros)
        $data['car'] = $this->data_model->getCar($id, $this->session->userdata('pais'));


        $data = $this->general();

        $data['equipamiento_list'] = $this->data_model->getData('cq_equipamiento');
        $data_where = array('id_auto' => $id);
        $data['equipamiento'] = $this->data_model->getDataWhere($data_where, 'cq_auto_x_equipamiento');


        if (count($data['equipamiento']) < 1) {
            $data['equipamiento'] = 0;
        }


        //Marcas
        $data['marks'] = $this->data_model->getMarks();
        $data['combustibles'] = $this->data_model->getcombus();
        //echo 'marca actual'.$data['car']['id_marca'];
        $data['models'] = $this->data_model->ModelosPorMarca($data['car']['id_marca']);
        $data['colors'] = $this->data_model->getcolors();
        $data['departamentos'] = $this->data_model->getDepartamentos($this->session->userdata('pais'));
        $data['tumbnails'] = $this->data_model->getTumbnails($id);

        if (count($data['tumbnails']) < 1) {
            $data['tumbnails'] = 0;  //
        }

        $data['estadisticas'] = $this->data_model->gethits($id);

        $data['template'] = 'template/update-producto';

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
										 <a href="' . base_url() . 'index.php/car/dar_baja/' . $id . '/rechazar">Rechazar</a>
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
			
			if ($opcion == 'rechazar') {

                $this->Savedata_model->actualizar(array('id_automovil' => $id), 'cq_automovil', array('estado' => 'pendiente')); //borramos imagen
                $data['template'] = 'template/aviso';
                $data['tipo'] = "20";
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

    function primium_list($filtro = '', $desde = '0') {
        if (!$this->session->userdata('user_id') or $this->session->userdata('user_perfil') != '1') {
            redirect(base_url());
        } else {
            //
            $data = $this->general();

            $limite = 'LIMIT ' . $desde . ', 4';

            $data['cars'] = $this->data_model->carsbystado($this->session->userdata('pais'), 'Aprobado', $limite);

            $sinlimite = $this->data_model->carsbystado($this->session->userdata('pais'), 'Aprobado', '');

            $this->load->library('pagination');

            $total_result = count($sinlimite);

            if ($total_result > 4) {

                $config['base_url'] = base_url() . 'index.php/car/primium_list';
                $config['total_rows'] = $total_result;
                $config['per_page'] = 4;
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
            }

            $data['template'] = 'template/primium-list';
            $this->load->view('template/masterpage', $data);
        }
    }

    function solicitar_info($id) {
        $data = $this->general();

        $data['car'] = $this->data_model->getCar($id, $this->session->userdata('pais'));



        $data['user'] = $this->data_model->RowDataWhere(array('id_usuario' => $data['car']['usuario']), 'cq_usuario');



        $data['template'] = 'template/car_info';
        $this->load->view('template/masterpage', $data);
    }

    function solicitar_info_2($id) {
        $data = $this->general();

        $data['car'] = $this->data_model->getCar($id, $this->session->userdata('pais'));
        $data['user'] = $this->data_model->RowDataWhere(array('id_usuario' => $data['car']['usuario']), 'cq_usuario');

        $data['template'] = 'template/car_info_2';
        $this->load->view('template/masterpage', $data);
    }

    function proccessInfo() {

        $data = $this->general();

        $nombre = $this->input->post('nombre');

        $telefono = $this->input->post('telefono');
        $email = $this->input->post('email');
        $consulta = htmlentities($this->input->post('consulta'));
        $marca = $this->input->post('marca');
        $modelo = $this->input->post('modelo');
        $email = $this->input->post('3m41l');
        $data['id'] = $this->input->post('id');

        $email = str_replace('#', '@', $email);

        //echo '<br>email='.$email;
        //exit;

        $datos = array(
            'tipo' => 'info_car',
            'to' => $email,
            'nombre' => $nombre,
            'telefono' => $telefono,
            'email' => $email,
            'consulta' => $consulta,
            'marca' => $marca,
            'modelo' => $modelo
        );

        $this->function_model->enviarMail($datos);

        $data['tipo'] = '25';

        $data['template'] = 'template/aviso';
        $this->load->view('template/masterpage', $data);
    }

    function proccessInfo_2() {

        $data = $this->general();

        $nombre = $this->input->post('nombre');
        $apellido = $this->input->post('apellido');
        $telefono = $this->input->post('telefono');
        $telefono2 = $this->input->post('telefono2');
        $telefono3 = $this->input->post('telefono3');
        //$email = $this->input->post('email');
        $consulta = htmlentities($this->input->post('consulta'));
        $marca = $this->input->post('marca');
        $modelo = $this->input->post('modelo');
        //$email_to = $this->input->post('3m41l');
        $data['id'] = $this->input->post('id');

        //echo '<br>email='.$email;

        $datos = array(
            'tipo' => 'info_car_2',
            'to' => str_replace('#', '@', $this->input->post('3m41l')),
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'telefono2' => $telefono2,
            'telefono3' => $telefono3,
            'email' => str_replace('#', '@', $this->input->post('email')),
            'consulta' => $consulta,
            'marca' => $marca,
            'modelo' => $modelo,
            'id' => $this->input->post('id'),
            'cc' => 'usados.sv@crediq.com'
        );


        if (count($datos) > 0 && $this->input->post('id') > 0) {
            $this->function_model->enviarMail($datos);
        }

        $data['tipo'] = '25';
        $data['template'] = 'template/aviso';
        $this->load->view('template/masterpage', $data);
    }

    function prueba() {

        $data = $this->general();


        $data['template'] = 'template/add-producto-2';
        $this->load->view('template/masterpage', $data);
    }

}
