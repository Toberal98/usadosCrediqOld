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
class function_model extends CI_Model {

    function enviarMail($datos) {

        $cuerpo = '<table cellspacing="0" callpadding="0"  width="389" height="180" border="0">';
        $cuerpo .= "<tr>";

        if ($datos['tipo'] == "info-car") {

            $from = 'Nuevos CrediQ';
            $subject = 'Solicitud de informacion de vehiculo';

            $cuerpo .= "<th colspan=\"2\">Marca: " . $datos['marca'] . " - Modelo: " . $datos['modelo'] . "</th>";
            $cuerpo .= "<th colspan=\"2\">Opcion: " . $datos['opcion'] . " - Cuota: " . $datos['cuota'] . "</th>";            
            $cuerpo .= "</tr>";
            $cuerpo .= "<tr>";
            $cuerpo .= '<td align="center">
                        <h3>' . $datos['nombre'] . ' </h3>
                        Nombre: ' . $datos['nombre'] . '<br/>
						 Telefono: ' . $datos['telefono'] . '<br/>
						  Email: ' . $datos['email'] . '<br/><br/>
						  Consulta: " ' . $datos['consulta'] . '"<br/>
						 
                       </td>';
        }

        $cuerpo .= "</tr>";
        $cuerpo .= "</table>";

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

        //Load email library
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        //Set email parameters		
        $this->email->from('info@crediqinfo.com', $from);
        $this->email->to($datos['to']);
        $this->email->cc($datos['cc']);
        $this->email->subject($subject);
        $this->email->message($cuerpo);

        //Send the email
        
        if ($this->email->send()) {
            return TRUE;
        } else {
            show_error($this->email->print_debugger());
            return FALSE;
        }
    }

    function comunes($var) {//busca un id dentro del array de la session especificada y si no existe la session la crea y agrega el id, 
        //devuelve el total de ids en el array.Crea un grupo de id comunes dentro de un array, DATOS QUE RECIBE:
        //$var['sesion']: el nombre de la session
        //$var['id']: el id a buscar 
        //$limite: numero de ids comunes
        $total_ids = 1;

        if (!$this->session->userdata($var['sesion'])) {//si la session no existe
            $datos = array();
            $datos[1] = $var['id']; //el id que necesitamos buscar y agregar
            //$this->session->set_userdata('comparar',$datos);
        } else {

            $datos = $this->session->userdata($var['sesion']);
            $total_ids = count($datos); //contamos el total de ids en el arrays

            if (!in_array($var['id'], $datos)) {//buscamos el id recibido en el el arreglo si no existe lo agregamos
                if ($total_ids >= $var['limit']) {

                    for ($i = 1; $i <= $var['limit'] - 1; $i++) {
                        $datos[$i] = $datos[$i + 1];
                    }

                    $datos[4] = $var['id']; //agregamos un nuevo indice
                } else {

                    $datos[$total_ids + 1] = $var['id']; //agregamos un nuevo indice
                    $total_ids++; //como agremos otro id, entonces sumamos uno mas al total
                }
            }
        }

        $this->session->set_userdata($var['sesion'], $datos); //Guardamos enl la session los ids

        $comunes = array('total_ids' => $total_ids, 'ids' => $datos); //retornamos el total y los ids(array de ids)

        return $comunes;
    }

    function hace($fecha) {
        //la fecha insertada debe tener el siguiente formato: 2010-12-10 06:10:20(año-mes-dia hora:minutos:segundos)

        $year = substr($fecha, 0, 4);
        $mes = substr($fecha, 5, 2);
        $dia = substr($fecha, 8, 2);
        $hora = substr($fecha, 11, 2);
        $minutos = substr($fecha, 14, 2);

        $result = preg_replace("/[^0-9]/", "", $year);

        if ($result) {
            //echo 'fecha: '.$hora.':'.$minutos.'/'.$dia.'-'.$mes.'-'.$year.' | ';

            if (date('Y') > $year) {
                //calculamos años
                $hace = date('Y') - $year;
                $hace = $hace . 'a&ntilde;os';
            } elseif (date('Y') == $year) {

                if (date('m') > $mes) {
                    //calculamos meses
                    $hace = date('m') - $mes;
                    $hace = $hace . ' meses';
                } else if ($mes == date('m')) {

                    if (date('d') > $dia) {
                        //calculamos dias 
                        $hace = date('d') - $dia;
                        $hace = $hace . ' dias';
                    } else if (date('d') == $dia) {

                        if (date('H') > $hora) {
                            $hace = date('H') - $hora;
                            $hace = $hace . ' horas';
                        } else if (date('H') == $hora) {

                            if (date('i') > $minutos) {
                                $hace = date('i') - $minutos;
                                $hace = $hace . ' minutos';
                            } else {
                                $hace = 'unos segundos';
                            }
                        }
                    }
                }
            }

            return $hace;
        } else {
            return '-';
        }
    }

}
