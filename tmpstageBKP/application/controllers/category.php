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
class Category extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('filter_model');
        $this->load->model('data_model');
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
        $data['bannersPosition'] = $this->data_model->Banners();
        $data['banners'] = $this->data_model->getBanners();
        $data['paises'] = $this->data_model->getPaises();
        $data['moneda'] = $this->session->userdata('moneda');

        return $data;
    }

    function ver($id) {

        if ($this->session->userdata('pais')) {
            
        } else {
            $this->session->set_userdata('pais', 1);
        }

        //error_reporting(1);
        //categorias (Tipos de Vehiculo)
        $this->session->set_userdata('CategoriaActual', $id);


        $data = $this->general();

        //definimos limites de la consulta
        $desde = $this->session->userdata('lapso_actual') + 1;

        $limite = "LIMIT " . $desde . ", 12";

        //Productos (Carros)
        //Productos (Carros)


        $data['products'] = $this->filter_model->getProducts(date('Y') - 11, date('Y'), '', '', '', '', $id, '', '', '', $limite, '',0);

        $consulta_sin_limite = $this->filter_model->getProducts(date('Y') - 11, date('Y'), '', '', '', '', $id, '', '', '', '', '',0);
        //paginamos
        $total_resultados = count($consulta_sin_limite);
        $data['paginacion'] = $this->filter_model->paginar($total_resultados, 12, 6, "filter_charact");

        $data['total_resultados'] = $total_resultados;

        //Marcas
        $data['marks'] = $this->data_model->getMarksExistentes();

        //combustible
        $data['combustibles'] = $this->data_model->getData('cq_tipo_combustible');
        //calificacion
        //$data['calificacion'] = $this->data_model->getData('cq_tipo_combustible');
        //Mostrando
        $data['filtro'] = TRUE; //mostramos vista filtro
        //datos para el arbol de la vista
        $data['f_mark'] = 'todos';
        $data['f_model'] = '';
        $data['f_tipo_vehiculo'] = '';
        $data['f_combustible'] = '';
        $data['f_financiamiento'] = '';
        $data['f_recomendado'] = ''; /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
        $data['f_transmision'] = '';

        $data['template'] = 'template/principal.php';

        
        
        
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
        }


        //titulo de pagina
        $titulo = $this->data_model->getCategoria($id);


        $data['title'] = utf8_decode($titulo['nombre']);


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

}
