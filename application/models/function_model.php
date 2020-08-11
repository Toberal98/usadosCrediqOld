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
        //$enlace="http://crediq.web-informatica.info/index.php/site/activateAcc";



        $cuerpo = '<table cellspacing="0" callpadding="0"  width="389" height="180" border="0">';
        $cuerpo .= "<tr>";

        if ($datos['tipo'] == "solicitud") {

            $from = 'CrediQ';
            $subject = 'Solicitud de credito natural';

            $cuerpo .= "<th colspan=\"2\">Se ha hecho una Nueva Solicitud de credito</th>";
            $cuerpo .= "</tr>";
            $cuerpo .= "<tr>";
            $cuerpo .= '<td>
                        <h2>Solicitud de credito natural</h2>
                        Datos
                        <br /><br />';

            $cuerpo.='<h1>Datos de la Solicitud</h1>';
            foreach ($datos['datos_generales'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h1>Solicitante</h1>';
            $cuerpo.='<h2>Informacion del solicitante</h2>'; // ************* solicitante		
            foreach ($datos['solicitante'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Informacion Laboral</h2>'; // solicitante		
            foreach ($datos['laboral'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Informacion conyuge</h2>';
            foreach ($datos['conyuge'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Informacion vehiculo</h2>';
            foreach ($datos['vehiculo'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Informacion referencias crediq</h2>';
            foreach ($datos['ref_crediq1'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<br /><br />';
            foreach ($datos['ref_crediq2'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Informacion referencia financiera</h2>';
            foreach ($datos['ref_financiera'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Informacion referencia tarjeta de credito</h2>';
            foreach ($datos['ref_tarjeta'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }

            $cuerpo.='<h2>Informacion referencia comercial</h2>';
            foreach ($datos['ref_comercial'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }

            $cuerpo.='<h2>Informacion referencias personales</h2>';
            foreach ($datos['ref_personal1'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<br /><br />';
            foreach ($datos['ref_personal2'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }

            $cuerpo.='<h2>Informacion referencias familiares</h2>';
            foreach ($datos['ref_familiar1'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<br /><br />';
            foreach ($datos['ref_familiar2'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h1>Fiador</h1>';
            $cuerpo.='<h2>Informacion del fiador</h2>';
            foreach ($datos['fiador'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Informacion laboral</h2>';
            foreach ($datos['fiador_laboral'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Informacion del conyuge</h2>';
            foreach ($datos['fiador_conyuge'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Informacion del vehiculo</h2>';
            foreach ($datos['fiador_vehiculo'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Referencias Crediq</h2>';
            foreach ($datos['fiador_ref_crediq1'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<br /><br />';
            foreach ($datos['fiador_ref_crediq2'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Referencia financiera</h2>';
            foreach ($datos['fiador_ref_financiera'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Referencias tarjetas de credito</h2>';
            foreach ($datos['fiador_ref_tarjeta1'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<br /><br />';
            foreach ($datos['fiador_ref_tarjeta2'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }

            $cuerpo.='<h2>Referencia comercial</h2>';
            foreach ($datos['fiador_ref_comercial'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Referencia personal</h2>';
            foreach ($datos['fiador_ref_personal'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Referencia familiar</h2>';
            foreach ($datos['fiador_ref_familiar'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }

            $cuerpo.= '<br /><br /></td>';
        }
        if ($datos['tipo'] == "solicitud_juridica") {

            $from = 'CrediQ';
            $subject = 'Solicitud de credito juridica';

            $cuerpo .= "<th colspan=\"2\">Se ha hecho una Nueva Solicitud de credito</th>";
            $cuerpo .= "</tr>";
            $cuerpo .= "<tr>";
            $cuerpo .= '<td>
                        <h2>Solicitud de credito ' . $datos['tipo_solicitud'] . '</h2>
                        Datos
                        <br /><br />';

            $cuerpo.='<h1>Datos de la Solicitud</h1>';
            foreach ($datos['datos_generales'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h1>solicitante</h1>';
            $cuerpo.='<h2>Datos del solicitante</h2>';
            foreach ($datos['solicitante'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h1>Referencias</h1>';
            $cuerpo.='<h2>Referencias bancarias</h2>';
            foreach ($datos['ref_bank1'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<br /><br />';
            foreach ($datos['ref_bank2'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Referencias comerciales</h2>';
            foreach ($datos['ref_comercial1'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<br /><br />2<br/>';
            foreach ($datos['ref_comercial2'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }



            $cuerpo.='<h1>Representante legal</h1>';
            $cuerpo.='<h2>informacion del epresentante legal</h2>';
            foreach ($datos['representante'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Informacion laboral</h2>';
            foreach ($datos['repre_laboral'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Informacion del conyuge</h2>';
            foreach ($datos['repre_conyuge'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Informacion del vehiculo</h2>';
            foreach ($datos['repre_vehiculo'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Referencia financiera</h2>';
            foreach ($datos['repre_ref_financiera'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }

            $cuerpo.='<h2>Referencia tarjeta de credito</h2>';
            foreach ($datos['repre_ref_tarjeta'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<h2>Referencia comercial</h2>';
            foreach ($datos['repre_ref_comercial'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }

            $cuerpo.='<h2>Referencias personales</h2>';
            foreach ($datos['repre_ref_personal1'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
            $cuerpo.='<br /><br />2<br />';
            foreach ($datos['repre_ref_personal2'] as $label => $value) {
                $cuerpo.= $label . ': ' . $value . '<br />';
            }
        }
        if ($datos['tipo'] == "recuperarPass") {

            $from = 'CrediQ';
            $subject = 'Solicitud de nueva contraseña';

            $cuerpo .= "<th colspan=\"2\">Nueva Contraseña de CrediQ</th>";
            $cuerpo .= "</tr>";
            $cuerpo .= "<tr>";
            $cuerpo .= '<td align="center">
                        <h3>' . $datos['to'] . '</h3>
                        Ha solicitado nueva contraseña a usadoscrediq.com!
                        <br /><br />
                        Tu Nueva contraseña es:' . $datos['newpass'] . '
                        <br /><br />   
                        <br /> <br /></td>';
        }

        if ($datos['tipo'] == "registro") {

            $enlace = base_url() . "index.php/site/activateAcc/" . md5($datos['to']);
            $from = 'Crediq Registro de usuarios';
            $subject = 'Gracias por tu registro';

            $cuerpo .= "<th colspan=\"2\">Bienvenido a CrediQ</th>";
            $cuerpo .= "</tr>";
            $cuerpo .= "<tr>";
            $cuerpo .= '<td align="center">
                        <h3>' . $datos['nombre'] . ' Bienvenido a CrediQ</h3>
                    Gracias por Registrate a usadoscrediq.com!
                    <br /><br />
                    Tu clave es:' . $datos['clave'] . '
                    <br /><br />   
                    Para activar la cuenta click en el siguiente enlace:<br/><br/><strong> <a href="' . $enlace . '">' . $enlace . '</a> </strong>
                    <br /> <br /></td>';
        }

        if ($datos['tipo'] == "contacto") {

            $from = 'Crediq pagina de contacto';
            $subject = 'Nuevo formulario de contacto';

            $cuerpo .= "<th colspan=\"2\">Nuevo formulario de Contacto</th>";
            $cuerpo .= "</tr>";
            $cuerpo .= "<tr>";
            $cuerpo .= '<td align="center">
                            <h3>Datos</h3></td></tr>';
            foreach ($datos as $key => $value) {
                $cuerpo .= "<tr>";
                $cuerpo .= "<td> $key :</td><td> $value </td>";
                $cuerpo .= "</tr>";
            }
        }

        if ($datos['tipo'] == "revision") {

            $from = 'CrediQ';
            $subject = 'Revision de Vehiculo';

            $cuerpo .= "<th colspan=\"2\">Revision de Vehiculo de CrediQ</th>";
            $cuerpo .= "</tr>";
            $cuerpo .= "<tr>";
            $cuerpo .= '<td align="center">
                        <h3>' . $datos['to'] . '</h3>
                        <b>Su vehiculo sera sometido a revision y posteriormente se le notificara si fue autorizado.</b>
                        </td>';
        }

        if ($datos['tipo'] == "fue_aprobado") {

            $from = 'CrediQ';
            $subject = 'Aprobacion de Vehiculo';

            $cuerpo .= "<th colspan=\"2\">Aprobacion de Vehiculo de CrediQ</th>";
            $cuerpo .= "</tr>";
            $cuerpo .= "<tr>";
            $cuerpo .= '<td align="center">
                        <h3>' . $datos['nombres'] . " " . $datos['apellidos'] . '</h3>
                        <b>Felicidades su vehiculo ' . $datos['marca'] . ' - ' . $datos['modelo'] . ' ha sido aprobado .</b>
                       </td>';
        }
        if ($datos['tipo'] == "info_car") {

            $from = 'CrediQ';
            $subject = 'Solicitud de informacion de vehiculo';

            $cuerpo .= "<th colspan=\"2\">Marca: " . $datos['marca'] . " - Modelo: " . $datos['modelo'] . "</th>";
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
        if ($datos['tipo'] == "info_car_2") {

            $from = 'CrediQ';
            $subject = 'Solicitud de informacion de vehiculo';

            $cuerpo .= "<th colspan=\"2\">Marca: " . $datos['marca'] . " - Modelo: " . $datos['modelo'] . "</th>";
            $cuerpo .= "</tr>";
            $cuerpo .= "<tr>";
            $cuerpo .= '<td align="center">
                        <h3>' . $datos['nombre'] . ' </h3>
                        Nombres: ' . $datos['nombre'] . '<br/>
                        Apellidos: ' . $datos['apellido'] . '<br/>
                        Telefono Casa: ' . $datos['telefono'] . '<br/>
                        Telefono Trabajo: ' . $datos['telefono2'] . '<br/>
			Celular: ' . $datos['telefono3'] . '<br/>
			Correo Electronico: ' . $datos['email'] . '<br/><br/>
			Mensaje: ' . $datos['consulta'] . '<br/>
                        Link Vehiculo: '.base_url() ."car/ver/". $datos['id'] . '<br/>						 
						  
                       </td>';
            //error_log("\r\n-->Cuerpo Correo=".$cuerpo."\r\n", 3, dirname(__FILE__)."/log.log");
            //error_log("\r\n-->Cuerpo Correo=".$datos."\r\n", 3, dirname(__FILE__)."/log.log");
        }


        if ($datos['tipo'] == "form_Rec") {

            $from = 'CrediQ';
            $subject = 'Nueva recomendacion';

            $cuerpo .= "<th colspan=\"2\">Nueva recomendacion de usario crediQ</th>";
            $cuerpo .= "</tr>";
            $cuerpo .= "<tr>";
            $cuerpo .= '<td>
				  		<h3>Datos Generales</h3>
						Referir para: ' . $datos['tipo_rec'] . '
                        <h3>Cliente referido</h3>
                        Nombre: ' . $datos['referido']['nombre'] . '<br/>
						Dui: ' . $datos['referido']['dui'] . '<br/>
						Nit: ' . $datos['referido']['nit'] . '<br/><br/>
						Telefono: " ' . $datos['referido']['telefono'] . '"<br/>
						Vehiculo: "' . $datos['referido']['vehiculo'] . '"<br />
						 
						<h3>Referido por</h3>
                        Nombre: ' . $datos['referidor']['nombre'] . '<br/>
						Dui: ' . $datos['referidor']['dui'] . '<br/>
						Nit: ' . $datos['referidor']['nit'] . '<br/><br/>
						Telefono: " ' . $datos['referidor']['telefono'] . '"<br/>
						Email: "' . $datos['referidor']['email'] . '"<br />
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
