<?php


include 'ChromePHP.php';
ChromePhp::log('Hello console!');
ChromePhp::log($_SERVER);
ChromePhp::warn('something went wrong!');


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
class Ajax extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('filter_model');
        $this->load->model('data_model');
        $this->load->model('Secure_model');
        $this->load->model('Savedata_model');
        $this->load->model('function_model');
        $this->load->library('session');
        $this->load->library('ImageUploader');
        $this->load->library('prestamo');
    }

    function index() {
        redirect(base_url());
    }

    /* Filtrado por año, marca y precio */

    function filter() {

        $year = $this->input->post('year');
        $year_hasta = $this->input->post('year_hasta');

        $start_price = $this->input->post('desde');
        $end_price = $this->input->post('hasta');

        $mark = $this->input->post('marca');
        $model = $this->input->post('modelo');
        $tipo_vehiculo = $this->input->post('tipo_v');
        $combustible = $this->input->post('combustible');
        $financiamiento = $this->input->post('financiamiento');
        $transmision = $this->input->post('transmision');
        $ingreso = $this->input->post('tipo_ingreso');
        $tipo_venta = $this->input->post('tipo_venta');
        $recomendados = $this->input->post('recomendados'); /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */

        /*$filtros = "Year:".$year." | year_hasta:".$year_hasta." | start_price:".$start_price." | end_price:".$end_price.
                " | mark:".$mark. " | model: ".$model. " | tipo_vehiculo:". $tipo_vehiculo. " | combustible:".$combustible.
                " | financiamiento:" .$financiamiento." | transmision".$transmision. " | ingreso".$ingreso;


        error_log("\r\n-->Filtros:: ".$filtros."\r\n", 3, dirname(__FILE__)."/log.log");
        */

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

            /*INI - Modificado por: GGONZALEZ - 25/01/2015 */
            $data['products'] = $this->filter_model->getProducts($year, $year_hasta, $mark, $model, $start_price, $end_price, $tipo_vehiculo, $combustible, $financiamiento,$transmision, $limite, $ingreso,$recomendados, '', $tipo_venta);
            //vaciamos limite para obtener la consulta de todos los autos con exactamente los mismos criterios
            $consulta_sin_limite = $this->filter_model->getProducts($year, $year_hasta, $mark, $model, $start_price, $end_price, $tipo_vehiculo, $combustible, $financiamiento,$transmision, "", $ingreso,$recomendados, '', $tipo_venta);
            $total_resultados = count($consulta_sin_limite);
        }
            /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
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
        /*INI - Modificado por: GGONZALEZ - 25/01/2015 */
        if ($recomendados == '1') {
            $recomendados = 'Recomendacion de CrediQ';
        }
        /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
        //echo '<br/><h1>entro '.$mark.'</h1>';
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

            /*INI - Modificado por: GGONZALEZ - 25/01/2015 */
            $new_info = $f_mark['nombre'] . $f_model['nombre'] . $f_tipo_vehiculo['nombre'] . $f_combustible['nombre'] . $financiamiento ;
            /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
            $this->session->set_userdata('info_busqueda', $new_info);
            $data['informe'] = $new_info;
        } else {
            if (!$this->session->userdata('info_busqueda')) {
                $data['informe'] = "";
            } else {
                $data['informe'] = $this->session->userdata('info_busqueda');
            }
        }



        // Calcular la cuota minima.
        $i = 0;
        foreach ($data['products'] as $producto) {

              /*MODIFICADO POR GGONZALEZ 26/05/2015 -  INI*/
            $data['CAMPOS_MATRIZ'] = $this->data_model->getCamposMatriz($producto['year'], $this->session->userdata('pais'));

              /*MODIFICADO POR GGONZALEZ 26/05/2015 -  FIN*/

            $tasaInteresPar =$data['CAMPOS_MATRIZ']['tasa'] ;
            $plazoPar = $data['CAMPOS_MATRIZ']['plazo'] ;
			$recargo = $data['CAMPOS_MATRIZ']['recargo'];

            // Creamos el objeto préstamo y le decimos que queremos una exactitud de 10 dígitos después de la coma.
            $prestamo = new Prestamo(10);
            // Configuramos el valor que pedimos de préstamo.
            $capital = $producto['precio'];
            $prestamo->setCapital($capital);


            $prestamo->setTasaInteres($tasaInteresPar / 100 / 12);
			// CAAR .- Se agrego un recargo a la cuota que corresponde al GPS - 20170809
			$prestamo->setRecargo($recargo);
            $cuota = $prestamo->calcCuota($plazoPar);

            $cuota = number_format((float) $cuota, 2, '.', '');
            $producto['cuotaMin'] = $cuota;

            //cuota renting
            $producto['cuota_renting'] = 0;
            $producto['aplica_renting'] = "no";

            $data_renting = $this->data_model->getRentingByAuto($producto['id_automovil']);
            $row_renting = $data_renting->row_array();

            if(!empty($row_renting)){
                $producto['cuota_renting'] = $row_renting['cuota_mensual'];
                $producto['aplica_renting'] = "si";
            }

            $data['products'][$i] = $producto;
            $i++;

            //error_log("\r\n-->hasta=".$producto['id_automovil']."\r\n", 3, dirname(__FILE__)."/log.log");
        }

        //$marrrr= $this->data_model->getCampo('nombre','cq_marca','id_marca',$mark);
        //echo $marrrr['nombre'];
        //carga de vistas
        $vista = $this->session->userdata('vista_actual');

        //error_log("\r\n-->vista=".$vista."\r\n", 3, dirname(__FILE__)."/log.log");
        if ($vista == 1) {
            $this->load->view('template/ajax/ver_bloques.php', $data);
        } elseif ($vista == 2) {
            $this->load->view('template/ajax/ver_lista.php', $data);
        } else {
            $this->load->view('template/ajax/ver_bloques.php', $data);
        }
    }

    function filterre() {

        $year = $this->input->post('year');
        $year_hasta = $this->input->post('year_hasta');

        $start_price = $this->input->post('desde');
        $end_price = $this->input->post('hasta');

        $mark = $this->input->post('marca');
        $model = $this->input->post('modelo');
        $tipo_vehiculo = $this->input->post('tipo_v');
        $combustible = $this->input->post('combustible');
        $financiamiento = $this->input->post('financiamiento');
        $transmision = $this->input->post('transmision');
        $ingreso = $this->input->post('tipo_ingreso');
        $tipo_venta = $this->input->post('tipo_venta');
        $recomendados = $this->input->post('recomendados'); /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */

        /*$filtros = "Year:".$year." | year_hasta:".$year_hasta." | start_price:".$start_price." | end_price:".$end_price.
                " | mark:".$mark. " | model: ".$model. " | tipo_vehiculo:". $tipo_vehiculo. " | combustible:".$combustible.
                " | financiamiento:" .$financiamiento." | transmision".$transmision. " | ingreso".$ingreso;


        error_log("\r\n-->Filtros:: ".$filtros."\r\n", 3, dirname(__FILE__)."/log.log");
        */

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

            /*INI - Modificado por: GGONZALEZ - 25/01/2015 */
            $data['products'] = $this->filter_model->getProducts(date('Y') - 11, date('Y'), '', '', '', '', 'todas', '', '', '', $limite,'',1);
            //vaciamos limite para obtener la consulta de todos los autos con exactamente los mismos criterios
            $consulta_sin_limite = $this->filter_model->getProducts(date('Y') - 11, date('Y'), '', '', '', '', 'todas', '', '', '', '','',1);
            $total_resultados = count($consulta_sin_limite);
        }
            /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
        //paginacion
        $data['total_resultados'] = $total_resultados;
        $data['paginacion'] = $this->filter_model->paginar($total_resultados, 12, 6, "filter_charact_re");

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
        /*INI - Modificado por: GGONZALEZ - 25/01/2015 */
        if ($recomendados == '1') {
            $recomendados = 'Recomendacion de CrediQ';
        }
        /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
        //echo '<br/><h1>entro '.$mark.'</h1>';
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

            /*INI - Modificado por: GGONZALEZ - 25/01/2015 */
            $new_info = $f_mark['nombre'] . $f_model['nombre'] . $f_tipo_vehiculo['nombre'] . $f_combustible['nombre'] . $financiamiento ;
            /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
            $this->session->set_userdata('info_busqueda', $new_info);
            $data['informe'] = $new_info;
        } else {
            if (!$this->session->userdata('info_busqueda')) {
                $data['informe'] = "";
            } else {
                $data['informe'] = $this->session->userdata('info_busqueda');
            }
        }



        // Calcular la cuota minima.
        $i = 0;
        foreach ($data['products'] as $producto) {

              /*MODIFICADO POR GGONZALEZ 26/05/2015 -  INI*/
            $data['CAMPOS_MATRIZ'] = $this->data_model->getCamposMatriz($producto['year'], $this->session->userdata('pais'));

              /*MODIFICADO POR GGONZALEZ 26/05/2015 -  FIN*/

            $tasaInteresPar =$data['CAMPOS_MATRIZ']['tasa'] ;
            $plazoPar = $data['CAMPOS_MATRIZ']['plazo'] ;

            // Creamos el objeto préstamo y le decimos que queremos una exactitud de 10 dígitos después de la coma.
            $prestamo = new Prestamo(10);
            // Configuramos el valor que pedimos de préstamo.
            $capital = $producto['precio'];
            $prestamo->setCapital($capital);


            $prestamo->setTasaInteres($tasaInteresPar / 100 / 12);
            $cuota = $prestamo->calcCuota($plazoPar);

            $cuota = number_format((float) $cuota, 2, '.', '');
            $producto['cuotaMin'] = $cuota;
            $data['products'][$i] = $producto;
            $i++;

            //error_log("\r\n-->hasta=".$producto['id_automovil']."\r\n", 3, dirname(__FILE__)."/log.log");
        }

        //$marrrr= $this->data_model->getCampo('nombre','cq_marca','id_marca',$mark);
        //echo $marrrr['nombre'];
        //carga de vistas
        $vista = $this->session->userdata('vista_actual');

        //error_log("\r\n-->vista=".$vista."\r\n", 3, dirname(__FILE__)."/log.log");
        if ($vista == 1) {
            $this->load->view('template/ajax/ver_bloques.php', $data);
        } elseif ($vista == 2) {
            $this->load->view('template/ajax/ver_lista.php', $data);
        } else {
            $this->load->view('template/ajax/ver_bloques.php', $data);
        }
    }


     function filterve() {

        $year = $this->input->post('year');
        $year_hasta = $this->input->post('year_hasta');


        $start_price = $this->input->post('desde');
        $end_price = $this->input->post('hasta');


        $mark = $this->input->post('marca');
        $model = $this->input->post('modelo');
        $tipo_vehiculo = $this->input->post('tipo_v');
        $combustible = $this->input->post('combustible');
        $financiamiento = $this->input->post('financiamiento');
        $transmision = $this->input->post('transmision');
        $tipo_venta = $this->input->post('tipo_venta');
        $ingreso = $this->input->post('tipo_ingreso');
        $recomendados = $this->input->post('recomendados'); /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */



        /*$filtros = "Year:".$year." | year_hasta:".$year_hasta." | start_price:".$start_price." | end_price:".$end_price.
                " | mark:".$mark. " | model: ".$model. " | tipo_vehiculo:". $tipo_vehiculo. " | combustible:".$combustible.
                " | financiamiento:" .$financiamiento." | transmision".$transmision. " | ingreso".$ingreso;


        error_log("\r\n-->Filtros:: ".$filtros."\r\n", 3, dirname(__FILE__)."/log.log");
        */


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

            /*INI - Modificado por: GGONZALEZ - 25/01/2015 */
            $data['products'] = $this->filter_model->getProducts($year, $year_hasta, $mark, $model, $start_price, $end_price, $tipo_vehiculo, $combustible, $financiamiento,$transmision, $limite, $ingreso,$recomendados, '', $tipo_venta);
            //vaciamos limite para obtener la consulta de todos los autos con exactamente los mismos criterios
            $consulta_sin_limite = $this->filter_model->getProducts($year, $year_hasta, $mark, $model, $start_price, $end_price, $tipo_vehiculo, $combustible, $financiamiento,$transmision, "", $ingreso,$recomendados, '', $tipo_venta);
            $total_resultados = count($consulta_sin_limite);
        }
            /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
        //paginacion
        $data['total_resultados'] = $total_resultados;
        $data['paginacion'] = $this->filter_model->paginar($total_resultados, 12, 6, "filter_charact_ve");

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
        /*INI - Modificado por: GGONZALEZ - 25/01/2015 */
        if ($recomendados == '1') {
            $recomendados = 'Recomendacion de CrediQ';
        }
        /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
        //echo '<br/><h1>entro '.$mark.'</h1>';
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

            /*INI - Modificado por: GGONZALEZ - 25/01/2015 */
            $new_info = $f_mark['nombre'] . $f_model['nombre'] . $f_tipo_vehiculo['nombre'] . $f_combustible['nombre'] . $financiamiento ;
            /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
            $this->session->set_userdata('info_busqueda', $new_info);
            $data['informe'] = $new_info;
        } else {
            if (!$this->session->userdata('info_busqueda')) {
                $data['informe'] = "";
            } else {
                $data['informe'] = $this->session->userdata('info_busqueda');
            }
        }



        // Calcular la cuota minima.
        $i = 0;
        foreach ($data['products'] as $producto) {

              /*MODIFICADO POR GGONZALEZ 26/05/2015 -  INI*/
            $data['CAMPOS_MATRIZ'] = $this->data_model->getCamposMatriz($producto['year'], $this->session->userdata('pais'));

              /*MODIFICADO POR GGONZALEZ 26/05/2015 -  FIN*/

            $tasaInteresPar =$data['CAMPOS_MATRIZ']['tasa'] ;
            $plazoPar = $data['CAMPOS_MATRIZ']['plazo'] ;

            // Creamos el objeto préstamo y le decimos que queremos una exactitud de 10 dígitos después de la coma.
            $prestamo = new Prestamo(10);
            // Configuramos el valor que pedimos de préstamo.
            $capital = $producto['precio'];
            $prestamo->setCapital($capital);


            $prestamo->setTasaInteres($tasaInteresPar / 100 / 12);
            $cuota = $prestamo->calcCuota($plazoPar);

            $cuota = number_format((float) $cuota, 2, '.', '');
            $producto['cuotaMin'] = $cuota;
            $data['products'][$i] = $producto;
            $i++;

            //error_log("\r\n-->hasta=".$producto['id_automovil']."\r\n", 3, dirname(__FILE__)."/log.log");
        }

        //$marrrr= $this->data_model->getCampo('nombre','cq_marca','id_marca',$mark);
        //echo $marrrr['nombre'];
        //carga de vistas
        $vista = $this->session->userdata('vista_actual');

        //error_log("\r\n-->vista=".$vista."\r\n", 3, dirname(__FILE__)."/log.log");
        if ($vista == 1) {
            $this->load->view('template/vendidos/ver_bloques.php', $data);
        } elseif ($vista == 2) {
            $this->load->view('template/vendidos/ver_lista.php', $data);
        } else {
            $this->load->view('template/vendidos/ver_bloques.php', $data);
        }
    }

    function doimage($img_info) {
        if ($img_info = explode("-", $img_info)) {
            /* BEGIN IW */
            $url = "http://www.usadoscrediq.com/public/images/no_disponible.jpg";

            if (count($img_info) > 3) {
                list($id_auto, $desired_width, $desired_height, $tipo_imagen) = $img_info;

                $tipo_imagen = str_pad($tipo_imagen, 5, '0', STR_PAD_LEFT);

                $datos = $this->data_model->getDataWhere(array(
                    'codigo_vehiculo' => $id_auto,
                    'codigo_tipo_foto' => $tipo_imagen
                ), 'imagenes');

                if (count($datos) > 0) {//contamos thums
                    $url = $this->imageuploader
                        ->doCarResizedImage(
                            $datos[0],
                            $desired_width,
                            $desired_height
                        );
                }
            }

            header("Location: $url");
            /* END IW */
        }
    }

    function dothums($img_info) {//usado para lista y bloques en resultados de busqueda
        if ($img_info = explode("-", $img_info)) {
            /* BEGIN IW */
            $url = "http://www.usadoscrediq.com/public/images/no_disponible.jpg";

            if (count($img_info) > 1) {
                list($id_auto, $vista_actual) = $img_info;

                $datos = $this->data_model->getDataWhere(array(
                    'codigo_vehiculo' => $id_auto
                ), 'imagenes');

                if (count($datos) > 0) {
                  switch ($vista_actual) {
                      case '2':
                          $desired_width = 60;
                          $desired_height = 40;
                      break;
                      case '3':
                          $desired_width = 99;
                          $desired_height = 77;
                      break;
                      default:
                          $desired_width = 204;
                          $desired_height = 137;
                      break;
                  }

                  $url = $this->imageuploader
                      ->doCarResizedImage(
                          $datos[0],
                          $desired_width,
                          $desired_height
                      );
                }
            }

            header("Location: $url");
            /* END IW */
        }
    }

    //Obtenemos modelos de una marca para convertilos en opciones un select
    function getmodels() {
        $marca = $this->input->post('marca');
        $models = $this->filter_model->getModelsByMarck($marca);
        echo '<option value="">Todos</option>';
        foreach ($models as $model) {
            echo '<option value="' . $model['id_modelo'] . '">' . $model['nombre'] . '</option>';
        }
    }

    function getmodelsExistentes() {
        $marca = $this->input->post('marca');
        $models = $this->filter_model->getModelsByMarckExistentes($marca);
        echo '<option value="">Todos</option>';
        foreach ($models as $model) {
            echo '<option value="' . $model['id_modelo'] . '">' . $model['nombre'] . '</option>';
        }
    }

    //SE EJECUTA AL SELECCIONAR UN TIPO DE VEHICULO, AUTOMOVIL, AUTOBUS, ETC...
    function marcasByTipo() {//sacamos marcas de acuerdo al tipo de vehiculo seleccionado
        $tipo = $this->input->post('tipo');
        $marcas = $this->filter_model->MarcasByTipo($tipo); //getDataWhere consulta con un solo criterio(select * from $tabla where $campo=$valor)

        echo '<option value="">Todas</option>';
        foreach ($marcas as $marca) {
            $nombre_marca = $this->filter_model->getDataWhere('cq_marca', 'id_marca', $marca['marca']); //obtenemos nombre de cada uno de los id
            if (!empty($nombre_marca)) {
                echo '<option value="' . $marca['marca'] . '">' . $nombre_marca['nombre'] . '</option>';
            }
        }
        echo 'ajax';
    }

    function marcasByTipoExistentes() {//sacamos marcas de acuerdo al tipo de vehiculo seleccionado
        $tipo = $this->input->post('tipo');
        $marcas = $this->filter_model->MarcasByTipoExistentes($tipo); //getDataWhere consulta con un solo criterio(select * from $tabla where $campo=$valor)

        echo '<option value="">Todas</option>';
        foreach ($marcas as $marca) {
            $nombre_marca = $this->filter_model->getDataWhere('cq_marca', 'id_marca', $marca['marca']); //obtenemos nombre de cada uno de los id
            if (!empty($nombre_marca)) {
                echo '<option value="' . $marca['marca'] . '">' . $nombre_marca['nombre'] . '</option>';
            }
        }
        echo 'ajax';
    }

    //USO EXCLUSIVO DEL JOOMLA-------------------------------------------------------------------
    function getmodelsj() {
        $marca = $this->input->post('marca');
        $models = $this->filter_model->getModelsByMarck($marca);
        echo '<div class="marca_item" onclick="ocultar_modelos(this);" id="">Modelo</div>';
        foreach ($models as $model) {
            echo '<div class="marca_item" onclick="ocultar_modelos(this);" id="' . $model['id_modelo'] . '">' . $model['nombre'] . '</div>';
        }
    }

    //USO EXCLUSIVO DEL JOOMLA
    function getmarksj() {
        $marcas = $this->data_model->getMarks();
        echo '<div class="marca_item" onclick="get_models(this);" id="">Marca</div>';
        foreach ($marcas as $marca) {
            echo '<div class="marca_item" onclick="get_models(this);" id="' . $marca['id_marca'] . '">' . $marca['nombre'] . '</div>';
        }
    }

    function doUpload() {

        $targetFolder = '/public/img_autos_temp'; // Relative to the root

        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = rtrim(FCPATH, '/') . $targetFolder;
            $targetFile = rtrim($targetPath, '/') . '/' . $_FILES['Filedata']['name'];

            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);

            if (in_array($fileParts['extension'], $fileTypes)) {
                move_uploaded_file($tempFile, $targetFile);
                //echo '<img src="'.base_url().'crediq/public/img_autos_temp/'.$_FILES['Filedata']['name'].'" alt="img">';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    function setname_imagen($image) {

        $file = $this->input->post('archivo');

        $this->session->set_userdata($image, $file);

        echo $image;
    }

    function checkEmail() {

        $email = $this->input->post('email');
        if ($this->Secure_model->checkEmail($email)) {
            echo '<span class="cabin_naranjas">El email que intenta registrar ya existe, por favor intente con otro! </span>';
        }
    }

    function checkEmail_up() {

        $email = $this->input->post('email');
        if ($this->Secure_model->checkEmail($email) and $email != $this->session->userdata('user_email')) {
            echo '<span class="cabin_naranjas">El email que intenta registrar ya existe, por favor intente con otro! </span>';
        }
    }

    function inyectarClick() {//suma un hits a un auto en cada aparicion en pantalla
        $id = $this->input->post('id');
        $this->data_model->inyectarClick($id);
    }

    function addComparar() {//suma un hits a un auto en cada aparicion en pantalla
        $id = $this->input->post('id');

        $var = array(
            'sesion' => 'comparar', //nombre de la sesion que contendra el arreglo
            'id' => $id, //el id que vamos a agregar
            'limit' => 4 //limite de ids que puden permanecer en el arreglo
        );

        if ($id != "") {
            $comunes = $this->function_model->comunes($var);
        }
    }

    function removeComparar() {//suma un hits a un auto en cada aparicion en pantalla
        $id = $this->input->post('id');

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
        }
    }

    function verComparar() {//suma un hits a un auto en cada aparicion en pantalla
        //$ids=$this->session->userdata('comparar');
        //		foreach($ids as $id_car){//
        echo '<br>id=' . $this->session->userdata('queryDebug');

        //}
    }

    function versession() {//suma un hits a un auto en cada aparicion en pantalla
        echo '<br /> consulta: ' . $this->session->userdata('consulta_');
        echo '<br /> imagen 1: ' . $this->session->userdata('imagen1') . '<br />';
        echo '<br /> imagen 2: ' . $this->session->userdata('imagen2');
        echo '<br /> imagen 3: ' . $this->session->userdata('imagen3');
        echo '<br /> imagen 4: ' . $this->session->userdata('imagen4');

        //$where 	= array('codigo_vehiculo' => '1005');//sacamos thums de este auto
        //$datos=$this->data_model->getDataWhere($where,'imagenes');
        //header ('Content-type:image/jpeg ');
        //echo base64_decode($datos[0]['imagen_file']);
        $car_id = $this->data_model->maxid();
        $car_id = $this->session->userdata('user_id') . $car_id['max_id'];
        $car_id = $car_id + 1;
        echo '<br />max car id ' . $car_id;




        $total_imgs = $this->data_model->total_Imgs('401013');

        echo '<br />total: ' . count($total_imgs) . '<br />';
    }

    function prueba_up() {//suma un hits a un auto en cada aparicion en pantalla
        $targetFolder = '/public/img_autos_temp'; // Relative to the root

        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $targetFile = rtrim($targetPath, '/') . '/' . $_FILES['Filedata']['name'];

            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPEG', 'JPG'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);

            if (in_array($fileParts['extension'], $fileTypes)) {
                move_uploaded_file($tempFile, $targetFile);
                //echo '<img src="'.base_url().'crediq/public/img_autos_temp/'.$_FILES['Filedata']['name'].'" alt="img">';
            } else {
                echo '<h3>Tipo de archivo invalido.<h3>';
                echo '<h3>Tipo de archivo: ' . $fileParts . '.<h3>';
                echo '<h3>Filedata: ' . $_FILES['Filedata']['tmp_name'] . '.<h3>';
            }
        }
    }

    //trama consentimiento
    function TramaConsentimiento($id,$marca,$pais,$modelo,$nombre,$dui,$telefono,$email){
		
  	 //Autorizacion de credenciales
      $curl = curl_init();
      // $username = "b42866a9-56d4-3d8d-920d-0dcd8c38f4f6";
      // $password = "WXi4nWzJCIYq1oKNbQ#8fr7Vvh";
      $username = "8893b4ba-0a06-3af6-b109-0757138987a4";
      $password = "x&q1E!l9mN6c26!wltzQ40jq2&1H";
      curl_setopt_array($curl, array(
        // CURLOPT_URL => "https://oauthasservices-d48d16b03.us2.hana.ondemand.com/oauth2/api/v1/token?grant_type=client_credentials",
		CURLOPT_URL => "https://oauthasservices-dd1d83ab9.us2.hana.ondemand.com/oauth2/api/v1/token?grant_type=client_credentials",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_USERPWD => $username . ":" . $password
      ));
      $response = json_decode(curl_exec($curl));
      curl_close($curl);
      $token = $response->{'access_token'};	  
	  
      echo '<script> console.log("TOKEN: '.$token.'") </script>';
      $this->db->select('cq_marca.nombre as Marca');
      $this->db->select('cq_pais.codigo as Pais');
      $this->db->from('cq_automovil');
      $this->db->join('cq_marca', 'cq_automovil.marca = cq_marca.id_marca');
      $this->db->join('cq_pais','cq_automovil.pais = cq_pais.id_pais');
      $this->db->where('id_automovil', $id);
      $consulta = $this->db->get();
      $resultado = $consulta->result();
      $marca = NULL;
      $codigo = NULL;
      $comparacionCelular = "\+503|00503|503?[ -]*(6|7)[ -]*([0-9][ -]*){8}";
      $telefonoMovil = NULL;
      $telefonoFijo = NULL;

      if(preg_match($telefono,$comparacionCelular)==TRUE){
          $telefonoMovil = $telefono;
		  
      }else{
		  $telefonoFijo = $telefono;
		  
      }

      $this->db->select('codigo');
      $this->db->from('cq_pais');
      $this->db->where('id_pais', $pais);
      $consulta = $this->db->get();

      foreach ($consulta->result() as $row)
      {
        $codigo = strtoupper($row->codigo);
      }

      //obtenemos la marca y el pais
      foreach ($resultado as $row)
          {
          $marca = $row->Marca;
          $pais = $row->Pais;
          }
        //obtenemos el area marketing
        //select valor from cq_par_parametros where codigo = 'AREA_MARKETING';
          $this->db->select('valor');
          $this->db->from('cq_par_parametros');
          $this->db->where('codigo', 'AREA_MARKETING');
          $consulta = $this->db->get();
          $resultado = $consulta->result();
          $Area_Marketing = NULL;

            foreach ($resultado as $row)
              {
                  $Area_Marketing = $row->valor;
              }

          //obtenemos el producto id
          // SELECT t.productID from cq_automovil as a INNER JOIN cq_tipo_vehiculo as t on a.tipo_vehiculo = t.id_tipo_vehiculo where a.id_automovil = 883;
          $this->db->select('cq_tipo_vehiculo.productID AS ID');
          $this->db->from('cq_automovil');
          $this->db->join('cq_tipo_vehiculo ','cq_automovil.tipo_vehiculo = cq_tipo_vehiculo.id_tipo_vehiculo');
          $this->db->where('id_automovil',$id);
          $resultado = $this->db->get();

          // $ProductId = $id;

          foreach ($resultado->result() as $rows) {
            $ProductId = $rows->ID;
          }
          //obtener el monto del vehiculo
          //select precio from cq_automovil where id_automovil = 883;
          $this->db->select('precio');
          $this->db->from('cq_automovil');
          $this->db->where('id_automovil', $id);
          $resultado = $this->db->get();
          //
          // $monto = 7000;
          //
          foreach ($resultado->result() as $rows) {
            $monto = $rows->precio;
          }
		  $timestamp = gmdate("Y-m-d\TH:i:s") . ".547";
		  
      // El pais parametrizar a codigo ISO
		  
      // Trama Consentimiento
      $curl = curl_init();
      $json = array(
        "WebsiteName" => "Usados CrediQ -".$codigo,
        "ContactID" => $email,
        "ContactOrigin" => "WEBCQ",
        "ContactOriginData" => array(
            "OriginDataLastChgUTCDateTime" => $timestamp,
            "CityName" => "",
            "Country" => $codigo,
            "EmailAddress" => $email,
            "FirstName" => "",
            "LastName" => "",
            "FullName" => $nombre,
            "GenderCode" => "",
            "AddressHouseNumber" => "",
            "IsConsumer" => true,
            "IsContactPerson" => false,
            "Language" => "ES",
            "MaritalStatus" => "",
            "MaritalStatusName" => "",
            "MobileNumber" => $telefonoMovil,
            "IsObsolete" => false,
            "PhoneNumber" => $telefonoFijo,
            "ContactPostalCode" => "",
            "AddressRegion" => "",
            "StreetName" => ""
        ),
        "MarketingPermissions" => array(
                "MarketingPermission" => [
                array(
                    "ContactPermissionID" =>  $email,
                    "ContactPermissionOrigin" => "EMAIL",
                    "MarketingArea" => $Area_Marketing,
                    "CommunicationMedium" => "WEB",
                    "CommunicationCategory" => "",
                    "ContactPermission" => "Y",
                    "PermissionUTCDateTime" => $timestamp,
                    "CommunicationDirection" => null,
                    "PermissionSourceObject" => null,
                    "PermissionSourceObjectType" => null,
                    "PermissionSourceSystem" => null,
                    "PermissionSourceSystemType" => null,
                    "PermissionSourceDataURL" => null,
                    "PermissionSourceCommMedium" => "WEB",
                    "IsConfirmationRequired" => false
                )
            ]
        )
    );

    echo '<script> console.log("MENSAJE CONSENTIMIENTO: '.json_encode($json).'") </script>';
	
	$request_headers=array(
    'Content-type: application/json',
    // 'Content-Length: '.strlen(json_encode($json)),
    'x-csrf-token: ' . $token,
    'Authorization: Bearer '.$token
    );
	
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://l5961-iflmap.hcisbp.us2.hana.ondemand.com/http/Web/MKT/Contact",
		// CURLOPT_URL => "https://e5728-iflmap.hcisbt.us2.hana.ondemand.com/http/Web/MKT/Contact",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST=>true,
        CURLOPT_POSTFIELDS => json_encode($json),
        CURLOPT_HTTPHEADER=> $request_headers,
        CURLOPT_XOAUTH2_BEARER=>$token,
        CURLOPT_HEADER=>false
        )
      );

      $data = curl_exec($curl);
      curl_close($curl);
		  
	echo '<script> console.log("RESP.CONSENTIMIENTO: '.$data.'") </script>';
	
	$timestamp = gmdate("Y-m-d\TH:i:s") . ".123";
	
	// Moneda (currency) deberia venir segun pais, codigo ISO

    //siguiente proceso
    $tramaInteraccion =
    '{
                    "InteractionContactOrigin": "WEBCQ",
                    "InteractionContactId": "'.$email.'",
                    "CommunicationMedium": "WEB",
                    "InteractionType": "COTIZACION",
                    "InteractionTimeStampUTC": "'. $timestamp .'",
                    "InteractionSourceObjectType": "WEBCQ",
                    "InteractionSourceObject": "WEBCQ",
                    "MarketingArea": "'.$Area_Marketing.'",
                    "CampaignID": "",
                    "MarketingLocationOrigin": "",
                    "MarketingLocation": "",
                    "DigitalAccountType": "",
                    "DigitalAccount": "",
                    "MKT_AgreementOrigin": "",
                    "MKT_AgreementExternalID": "",
                    "CampaignContent": null,
                    "InteractionWeightingFactor": null,
                    "InteractionSentimentValue": null,
                    "InteractionStatus": "",
                    "InteractionReason": "",
                    "InteractionLanguage": "ES",
                    "InteractionAmount": "",
                    "InteractionCurrency": "USD",
                    "InteractionLatitude": "",
                    "InteractionLongitude": "",
                    "SpatialReferenceSystem": "",
                    "DeviceType": "DESKTOP",
                    "InteractionDeviceName": "",
                    "SourceSystemType": "WEBCQ",
                    "SourceSystem": "WEBCQ",
                    "InteractionSourceObjectAddlID": "",
                    "InteractionSourceObjectStatus": "",
                    "InteractionSourceDataURL": "'.current_url().'",
                    "InteractionSourceTimeStampUTC": "'. $timestamp .'",
                    "CampaignContentLinkURL": "",
                    "CampaignContentLinkName": "",
                    "ReferralSource": "",
                    "ReferralSourceCategory": "",
                    "InteractionContentSubject": "",
                    "InteractionContent": "",
                    "InteractionProducts": {
                            "InteractionProduct": [{
                                       "ProductOrigin": "SAP_ERP_MATNR",
                                       "Product": "'.$ProductId.'",
                                       "InteractionProdWeightingFactor": "1",
                                       "InteractionProductSentimentVal": "1",
                                       "InteractionProductAmount": "'.$monto.'",
                                       "InteractionProductQuantity": "1",
                                       "InteractionProductUnit": "ST",
                                       "ProductRecommendationModelType": "",
                                       "ProductRecommendationScenario": null,
                                       "InteractionProductStatus": "",
                                       "InteractionProductReason": "",
                                       "InteractionSourceItemNumber": null
                                }]
                    }
                }';

    echo "<script> console.log('** MENSAJE INTERAC:".$tramaInteraccion."') </script>";

	   
	$query = http_build_query($tramaInteraccion);

    $request_headers=array(
      'Content-type: application/json',
      'Content-Length: '.strlen($tramaInteraccion),
      'InteractionType: Interactions',
      'Authorization: Bearer '.$token
    );

    $curl=curl_init();
    // $api_url='https://e5728-iflmap.hcisbt.us2.hana.ondemand.com/http/Web/MKT/Interactions';
	$api_url='https://l5961-iflmap.hcisbp.us2.hana.ondemand.com/http/Web/MKT/Interactions';

    curl_setopt_array(
    $curl,
      array(

          CURLOPT_URL => $api_url,
          CURLOPT_POST => true,
          CURLOPT_RETURNTRANSFER =>true,
          CURLOPT_POSTFIELDS => $tramaInteraccion,
          CURLOPT_HTTPHEADER => $request_headers,
          CURLOPT_XOAUTH2_BEARER=> $token,
          CURLOPT_HEADER=>false
      )
    );

      $res=curl_exec($curl);
      curl_close($curl);
      session_start();

      echo "<script> console.log('** RESP INTERAC:".$res."') </script>";

  }

  //consentimiento contactenos
    function interaccionContacto($email, $nombre, $telefono, $pais) {
      //obtenemos fecha, hora y microsegundos

      $datetime = new DateTime();
      $date = $datetime->format(DateTime::ATOM);


      //obtenemos el area marketing
      //select valor from cq_par_parametros where codigo = 'AREA_MARKETING';
		$this->db->select('valor');
		$this->db->from('cq_par_parametros');
		$this->db->where('codigo', 'AREA_MARKETING');
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		$Area_Marketing = NULL;

		foreach ($resultado as $row) {
			$Area_Marketing = $row->valor;
		}
		//obtenemos el Pais

      $this->db->select('codigo');
      $this->db->from('cq_pais');
      $this->db->where('id_pais', $pais);
      $consulta = $this->db->get();

      foreach ($consulta->result() as $row)
      {
        $codigo = strtoupper($row->codigo);
      }

      //decidimos por el $telefono

      $comparacionCelular = "\+503|00503|503?[ -](6|7)[ -]([0-9][ -]*){8}";
      $telefonoMovil = NULL;
      $telefonoFijo = NULL;

      if(preg_match($telefono,$comparacionCelular)==TRUE){
          $telefonoMovil = $telefono;
		  
      }else{
          $telefonoFijo = $telefono;
		  
      }

    //Autorizacion de credenciales
        $curl = curl_init();
        // $username = "b42866a9-56d4-3d8d-920d-0dcd8c38f4f6";
        // $password = "WXi4nWzJCIYq1oKNbQ#8fr7Vvh";
	    $username = "8893b4ba-0a06-3af6-b109-0757138987a4";
	    $password = "x&q1E!l9mN6c26!wltzQ40jq2&1H";
        curl_setopt_array($curl, array(
          // CURLOPT_URL => "https://oauthasservices-d48d16b03.us2.hana.ondemand.com/oauth2/api/v1/token?grant_type=client_credentials",
		  CURLOPT_URL => "https://oauthasservices-dd1d83ab9.us2.hana.ondemand.com/oauth2/api/v1/token?grant_type=client_credentials",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
          CURLOPT_USERPWD => $username . ":" . $password
        ));

        $response = json_decode(curl_exec($curl));

        curl_close($curl);
        $token = $response->{'access_token'};
        echo "<script> console.log('".$token."') </script>";
        //Autorizacion de token
		
		$timestamp = gmdate("Y-m-d\TH:i:s") . ".547";

        $curl = curl_init();
        $json = array(
          "WebsiteName" => "Usados CrediQ - ". $codigo,
          "ContactID" => $email,
          "ContactOrigin" => "WEBCQ",
          "ContactOriginData" => array(
              "OriginDataLastChgUTCDateTime" => $timestamp,
              "CityName" => "",
              "Country" => $codigo,
              "EmailAddress" => $email,
              "FirstName" => "",
              "LastName" => "",
              "FullName" => $nombre,
              "GenderCode" => "",
              "AddressHouseNumber" => "",
              "IsConsumer" => true,
              "IsContactPerson" => false,
              "Language" => "ES",
              "MaritalStatus" => "",
              "MaritalStatusName" => "",
              "MobileNumber" => $telefonoMovil,
              "IsObsolete" => false,
              "PhoneNumber" => $telefonoFijo,
              "ContactPostalCode" => "",
              "AddressRegion" => "",
              "StreetName" => ""
          ),
          "MarketingPermissions" => array(
                  "MarketingPermission" => [
                  array(
                      "ContactPermissionID" =>  $email,
                      "ContactPermissionOrigin" => "EMAIL",
                      "MarketingArea" => $Area_Marketing,
                      "CommunicationMedium" => "WEB",
                      "CommunicationCategory" => "",
                      "ContactPermission" => "Y",
                      "PermissionUTCDateTime" => $timestamp,
                      "CommunicationDirection" => null,
                      "PermissionSourceObject" => null,
                      "PermissionSourceObjectType" => null,
                      "PermissionSourceSystem" => null,
                      "PermissionSourceSystemType" => null,
                      "PermissionSourceDataURL" => null,
                      "PermissionSourceCommMedium" => "WEB",
                      "IsConfirmationRequired" => false
                  )
              ]
          )
      );
	  
        echo "<script> console.log('** MENSAJE CONSENT:".json_encode($json)."') </script>";

		$request_headers=array(
		'Content-type: application/json',
		'x-csrf-token: ' . $token,
		'Authorization: Bearer '.$token
		);

		  curl_setopt_array($curl, array(
			// CURLOPT_URL => "https://e5728-iflmap.hcisbt.us2.hana.ondemand.com/http/Web/MKT/Contact",
			CURLOPT_URL => "https://l5961-iflmap.hcisbp.us2.hana.ondemand.com/http/Web/MKT/Contact",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST=>true,
			CURLOPT_POSTFIELDS => json_encode($json),
			CURLOPT_HTTPHEADER=> $request_headers,
			CURLOPT_XOAUTH2_BEARER=>$token,
			CURLOPT_HEADER=>false
			)
		  );		
		
        $response = curl_exec($curl);
        curl_close($curl);

        echo "<script> console.log('** RESP CONSENT:".$response."') </script>";
		
		$timestamp = gmdate("Y-m-d\TH:i:s") . ".123";

        //Trama interaccion
        $tramaInteraccion =
        '{
                        "InteractionContactOrigin": "WEBCQ",
                        "InteractionContactId": "'.$email.'",
                        "CommunicationMedium": "WEB",
                        "InteractionType": "COTIZACION",
                        "InteractionTimeStampUTC": "'. $timestamp .'",
                        "InteractionSourceObjectType": "WEBCQ",
                        "InteractionSourceObject": "WEBCQ",
                        "MarketingArea": "' . $Area_Marketing . '",
                        "CampaignID": "",
                        "MarketingLocationOrigin": "",
                        "MarketingLocation": "",
                        "DigitalAccountType": "",
                        "DigitalAccount": "",
                        "MKT_AgreementOrigin": "",
                        "MKT_AgreementExternalID": "",
                        "CampaignContent": null,
                        "InteractionWeightingFactor": null,
                        "InteractionSentimentValue": null,
                        "InteractionStatus": "",
                        "InteractionReason": "",
                        "InteractionLanguage": "ES",
                        "InteractionAmount": "",
                        "InteractionCurrency": "USD",
                        "InteractionLatitude": "",
                        "InteractionLongitude": "",
                        "SpatialReferenceSystem": "",
                        "DeviceType": "DESKTOP",
                        "InteractionDeviceName": "",
                        "SourceSystemType": "WEBCQ",
                        "SourceSystem": "WEBCQ",
                        "InteractionSourceObjectAddlID": "",
                        "InteractionSourceObjectStatus": "",
                        "InteractionSourceDataURL": "'.current_url().'",
                        "InteractionSourceTimeStampUTC": null,
                        "CampaignContentLinkURL": "",
                        "CampaignContentLinkName": "",
                        "ReferralSource": "",
                        "ReferralSourceCategory": "",
                        "InteractionContentSubject": "",
                        "InteractionContent": "",
                        "InteractionProducts": {
                                "InteractionProduct": [{
                                           "ProductOrigin": "EXTERNAL_01",
                                           "Product": "CQ_PRODUCTO_FINANCIERO",
                                           "InteractionProdWeightingFactor": "1",
                                           "InteractionProductSentimentVal": "1",
                                           "InteractionProductAmount": "",
                                           "InteractionProductQuantity": "1",
                                           "InteractionProductUnit": "ST",
                                           "ProductRecommendationModelType": "",
                                           "ProductRecommendationScenario": null,
                                           "InteractionProductStatus": "",
                                           "InteractionProductReason": "",
                                           "InteractionSourceItemNumber": null
                                    }]
                        }
                    }';

       echo "<script> console.log('** MENSAJE INTERAC:".$tramaInteraccion."') </script>";

   	   $request_headers=array(
          'Content-type: application/json',
          'Content-Length: '.strlen($tramaInteraccion),
          'InteractionType: Interactions',
          'Authorization: Bearer '.$token
        );

        $curl=curl_init();
        // $api_url='https://e5728-iflmap.hcisbt.us2.hana.ondemand.com/http/Web/MKT/Interactions';
		$api_url='https://l5961-iflmap.hcisbp.us2.hana.ondemand.com/http/Web/MKT/Interactions';


        curl_setopt_array(
        $curl,
          array(

              CURLOPT_URL => $api_url,
              CURLOPT_POST => true,
              CURLOPT_RETURNTRANSFER =>true,
              CURLOPT_POSTFIELDS => $tramaInteraccion,
              CURLOPT_HTTPHEADER => $request_headers,
              CURLOPT_XOAUTH2_BEARER=> $token,
              CURLOPT_HEADER=>false
          )
        );

        $res=curl_exec($curl);
        curl_close($curl);

        echo "<script> console.log('** RESP INTERAC:".$res."') </script>";

        session_start();

      }

    /*enviar solicitud*/
    function enviarMail()
    {
        $button = $this->input->post('button');
        $auto = $this->input->post('auto');
        $name = $this->input->post('name');
        $dui = $this->input->post('dui');
        $pais = $this->input->post('pais');
		$email = utf8_encode($this->input->post('email'));
        $phone = $this->input->post('phone');
        $channel = $this->input->post('channel') == 'web' ? 'web' : 'mobile';
        $automovil = $this->input->post('automovil');
        $bandera = $this->input->post('bandera');
        $to = 'ventasusados@crediq.com';
        $data_auto = $this->data_model->getCar($auto, $this->session->userdata('pais'));
        $arreglo_auto = $data_auto['marca']." ".$data_auto['modelo']." (".$data_auto['id_automovil'].")";
        $marca = $data_auto['marca'];
        $modelo = $data_auto['modelo'];
        $cuota = $data_auto['precio'];
        $paisSeleccionado = $this->session->userdata('pais');

        if($bandera == 2){
          self:: interaccionContacto($email, $name, $phone, $paisSeleccionado);
        }elseif ($bandera == 1) {
          self:: TramaConsentimiento($auto,$marca,$paisSeleccionado ,$modelo,$name,$dui,$telefono,$email);
        }




    
        //Method insert to SpreedSheet Google
        if($channel == "mobile"){
            $url = "https://script.google.com/macros/s/AKfycbx_DX-hzN5BMzmVk_3WbjRHJHBeUpTBGje_r4UM0Wm-KuGBow/exec";
        
            $params = array('vendedor' => $to,
                        'boton' => $button,
                        'name' => $name,
                        'dui' => $dui,
                        'email' => $email,
                        'phone' => $phone,
                        'automovil' => $arreglo_auto,
                        'channel' => $channel);
        
            $query = http_build_query($params);
            $ch    = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
            $response = curl_exec($ch);
            curl_close($ch);
        }
        //End Method
        
        $subject = "{$button}";
        
        $cuerpo = '<table cellspacing="0" callpadding="0"  width="389" height="180" border="0">';
                    $cuerpo .= "<tr>";
        $cuerpo = "<th>Formulario {$button}</th>";
        $cuerpo .= "</tr>";
        $cuerpo .= "<tr>";
        $cuerpo .= '<td align="center">';
        $cuerpo .= "<p>{$name} ha llenado el formulario {$button} con la siguiente informacion:</p>";
        $cuerpo .= "<p><b>Nombre:</b> {$name}</p>";
        $cuerpo .= "<p><b>Dui/Identificación:</b> {$dui}</p>";
        $cuerpo .= "<p><b>E-mail:</b> {$email}</p>";
        $cuerpo .= "<p><b>Teléfono:</b> {$phone}</p>";
        if (!empty($data_auto)) {
            $cuerpo .= "<p><b>Auto:</b> {$data_auto['marca']} {$data_auto['modelo']} {$data_auto['year']} ({$data_auto['id_automovil']})</p>";
        }
        $cuerpo .= '</td>';
        $cuerpo .= '</tr>';
        $cuerpo .= '</table>';
        //Email configuracion
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => '190.0.230.57',//'correo.crediqinfo.com',
            'smtp_port' => 25,
            'smtp_user' => 'info',
            'smtp_pass' => 'crediq',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => '\r\n',
        );
        
        if ($data_auto['tipo_venta'] == '2') {
            //veh.liquidacion@crediq.com
            echo 'entre a contado';
            $to = 'melperez@crediq.com';
            //$this->email->cc('');
        }
        
        if ($email == 'rigovillg@gmail.com') {
        
            $this->load->library('ContactLogger');
        
            if ($data_auto['tipo_venta'] == '2') {
                $to = 'melperez@crediq.com';
                //$this->contactlogger->setSpreadsheetId('1rxkLkWwJhap-pQUS5XHXO-Btyq7jxBLwc4pfzpIFRHc');
                //$this->contactlogger->setSpreadsheetId('1Du4OM8LjQ4dVb9JOebF9eh1ydbDGjcqTQbePUhY8LN0');
            } else {
                //$to = $this->contactlogger->getNextTo();
            }
        
            $this->contactlogger->addLine($to, $email, $button, $name, $phone, $data_auto, $channel);
        
        }
        
        //Load email library
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        //Set email parameters
        $this->email->from('info@crediqinfo.com', 'CrediQ');
        $this->email->to($to);
        // $this->email->to('koporto@crediq.com, ralvarenga@crediq.com, imurga@crediq.com');
        if ($data_auto['tipo_venta'] == '1') {
            $this->email->cc('fduran@crediq.com, callcenter@crediq.com','rvillalobos@crediq.com');
        
        }
        
        // $this->email->bcc('gerardo@iw.sv');
        $this->email->subject($subject);
        $this->email->message($cuerpo);
        
        
        if ($this->email->send()) {
            return TRUE;
        
        } else {
            show_error($this->email->print_debugger());
            return FALSE;
        }
    }
    /*enviar solicitud*/

    function calcCuotaRenting(){
        $valor_res = $this->input->post('residual');
        $valor_veh = $this->input->post('precio');
        $int_anual =  $this->input->post('tasa');
        $nper = $this->input->post('plazo');
        $mant_total = $this->input->post('mantenimiento');
        $i_men = ($int_anual / 100)/12;
        //Se cambio para ser menual y no divido por nper
        //$mante_mensual = $mant_total / $nper;
        $mante_mensual = $mant_total;
        $tipo_mante =  $this->input->post('tipo_mante');
        $adminis = $this->input->post('administrativo');
        //Se agregaro nuevos cargos 18/09/2019
        $cargo_gps = $this->input->post('gps');
        $cargo_seguro = $this->input->post('seguro');

        $renting = 0;
        $renting = ($valor_veh-(($valor_res/pow((1+$i_men),$nper))))/((1-(1/pow((1+$i_men),$nper)))/($i_men));

        if($tipo_mante == "porcentaje"){
            $adminis = $valor_veh * ($adminis/100);
        }
        //Se suman nuevos cargos 18/09/2019
        $rentingconIva = ($renting + $mante_mensual + $adminis + $cargo_gps + $cargo_seguro) * 1.13;
        $rentingconIva = number_format((float) $rentingconIva, 2, '.', '');
        echo $rentingconIva;
    }


}
