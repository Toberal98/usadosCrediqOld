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
         echo "hola";
    }

    function calcCuotaCompra(){
        $precio = $this->input->post('precio');
        $tasa = $this->input->post('tasa');
        $plazo = $this->input->post('plazo');
        $recargo = $this->input->post('recargo');
        $prima = $this->input->post('prima');

        $valor_financiar = $precio - (($prima/100)*$precio);

        if(empty($recargo)){
            $recargo_cal=0;
        }
        $recargo_cal = ($recargo/100) * $precio;

        // Creamos el objeto préstamo y le decimos que queremos una exactitud de 10 dígitos después de la coma.
        $prestamo = new Prestamo(10);
        // Configuramos el valor que pedimos de préstamo.
        $prestamo->setCapital($valor_financiar);
        $prestamo->setTasaInteres($tasa / 100 / 12);

        // CAAR .- Se agrego un recargo a la cuota que corresponde al GPS - 20170809
        $prestamo->setRecargo($recargo_cal);
        $cuota = $prestamo->calcCuota($plazo);

        $cuota_con_iva = number_format((float) ($cuota * 1.13), 2, '.', '');
        echo $cuota_con_iva;
    } 

    function calcCuotaRenting(){
        $valor_res = $this->input->post('residual');
        $valor_veh = $this->input->post('precio');
        $int_anual =  $this->input->post('tasa');  
        $nper = $this->input->post('plazo');
        $mant_total = $this->input->post('mantenimiento');
        $i_men = ($int_anual / 100)/12;
        $mante_mensual = $mant_total / $nper;
        $tipo_mante =  $this->input->post('tipo_mante');
        $adminis = $this->input->post('administrativo');
        $renting = 0;
        $renting = ($valor_veh-(($valor_res/pow((1+$i_men),$nper))))/((1-(1/pow((1+$i_men),$nper)))/($i_men));
        
        if($tipo_mante == "porcentaje"){
            $adminis = $valor_veh * ($adminis/100);
        }
        $rentingconIva = ($renting + $mante_mensual + $adminis) * 1.13;

        $rentingconIva = number_format((float) $rentingconIva, 2, '.', '');

        echo $rentingconIva;
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

    //Luis Flores - Datasoft
    function comprobarEmail(){
        $result = $this->Secure_model->checkEmail($this->input->post('correo'));
        if($result){
            echo "false";
        }else{
            echo "true";
        }
    }

        //Luis Flores - Datasoft
    function comprobarEmailNuevoActual(){
        $nuevo = $this->input->post('correo');
        $actual = $this->input->post('actual');
        if($nuevo == $actual){
            echo "true";
        }else{ 
            $result = $this->Secure_model->checkEmail($this->input->post('correo'));
            if($result){
                echo "false";
            }else{
                echo "true";
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

    /*enviar solicitud*/
    function enviarMail()
    {
        echo "Enviandoooo";
        $marca = $this->input->post('marca');
        $modelo = $this->input->post('modelo');
        $opcion = $this->input->post('opcion');
        $cuota = $this->input->post('cuota');
        $nombre = $this->input->post('name');
        $telefono = $this->input->post('phone');
        $email = $this->input->post('email');
        $dui = $this->input->post('dui');
        $channel = $this->input->post('channel');
        $consulta = htmlentities($this->input->post('consulta'));

        $to = 'josefloresvasquez@gmail.com';//ventasusados@crediq.com

        $subject = "Solicitud de Información";

        $cuerpo = '<table cellspacing="0" callpadding="0"  width="389" height="180" border="0">';
                    $cuerpo .= "<tr>";
        $cuerpo = "<th>Formulario</th>";
        $cuerpo .= "</tr>";
        $cuerpo .= "<tr>";
        $cuerpo .= '<td align="center">';
        $cuerpo .= "<p>{$nombre} ha llenado el formulario Solicitud de Información con los siguiente datos:</p>";
        $cuerpo .= "<p><b>Nombre:</b> {$nombre}</p>";
        $cuerpo .= "<p><b>Dui/Identificación:</b> {$dui}</p>";
        $cuerpo .= "<p><b>E-mail:</b> {$email}</p>";
        $cuerpo .= "<p><b>Teléfono:</b> {$telefono}</p>";

        $cuerpo .= "<p><b>Marca:</b> {$marca}<br>";
        $cuerpo .= "<b>Modelo:</b> {$modelo}<br>";
        $cuerpo .= "<b>Opcion:</b> {$opcion}<br>";
        $cuerpo .= "<b>Cuota:</b> {$cuota}<br></p>";

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
            'newline' => '\r\n'
        );
        
        //Load email library
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        //Set email parameters
        $this->email->from('info@crediqinfo.com', 'CrediQ');
        $this->email->to($to);

        //if ($data_auto['tipo_venta'] == '1') {
          //  $this->email->cc('fduran@crediq.com, callcenter@crediq.com','rvillalobos@crediq.com');       
        //}

        // $this->email->bcc('gerardo@iw.sv');
        $this->email->subject($subject);
        $this->email->message($cuerpo);

        if ($this->email->send()){
            echo "Enviando...";
            $this->session->set_flashdata("msg", "Solicitud enviada exitosamente.");
            redirect(base_url());
        } else {
            show_error($this->email->print_debugger());
            return FALSE;
        }
    }
    /*enviar solicitud*/

}
