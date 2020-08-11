<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
**/
class senddata_model extends CI_Model{
  

	function enviarMail($emailTo,$clave,$datos)
	{
           /*MODIFICADO POR GGONZALEZ 21/05/2015 -  INI*/ 
            $pais= $this->session->userdata('pais');
            
             if ($pais == 1){ 
            date_default_timezone_set('America/El_Salvador');
            }
            
            elseif ($pais == 2){
                
            date_default_timezone_set('America/Costa_Rica');    
            }
            
            elseif ($pais == 3){
             date_default_timezone_set('America/Honduras');   
            }
            
            /*MODIFICADO POR GGONZALEZ 21/05/2015 -  FIN*/

		        $enlace=base_url()."index.php/site/activateAcc/".md5($emailTo);
            //$enlace="http://crediq.web-informatica.info/index.php/site/activateAcc";

            $cuerpo = '<table cellspacing="0" callpadding="0"  width="389" height="180" border="0">';
            $cuerpo .= "<tr>";
            
            if($clave!=""){

                if($datos=="recuperarPass"){
                  
                    $from='CrediQ';
                    $subject='Solicitud de nueva contraseña';
                    $cuerpo .= "<th colspan=\"2\">Nueva Contraseña de CrediQ</th>";
                    $cuerpo .= "</tr>";
                    $cuerpo .= "<tr>";
                    $cuerpo .= '<td align="center">
                        <h3>'.$emailTo.'</h3>
                        Ha solicitado nueva contraseña a usadoscrediq.com!
                        <br /><br />
                        Tu Nueva contraseña es:'.$clave.'
                        <br /><br />   
                        <br /> <br /></td>';
                }else{

                    $from='Crediq Registro de usuarios';
                    $subject='Gracias por tu registro';

                    $cuerpo .= "<th colspan=\"2\">Bienvenido a CrediQ</th>";
                    $cuerpo .= "</tr>";
                    $cuerpo .= "<tr>";
                    $cuerpo .= '<td align="center">
                        <h3>'.$datos.'</h3>
                    Gracias por Registrate a usadoscrediq.com!
                    <br /><br />
                    Tu clave es:'.$clave.'
                    <br /><br />   
                    Para activar la cuenta click en el siguiente enlace: <strong> <a href="'.$enlace.'">'.$enlace.'</a> </strong>
                    <br /> <br /></td>';
                }

            }else{




                $from='Crediq pagina de contacto';
                $subject='Nuevo formulario de contacto';
                
                $cuerpo .= "<th colspan=\"2\">Nuevo formulario de Contacto</th>";
                $cuerpo .= "</tr>";
                $cuerpo .= "<tr>";
                $cuerpo .= '<td align="center">
                            <h3>Datos</h3></td></tr>';
                            foreach($datos as $key => $value){
                              $cuerpo .= "<tr>";
                              $cuerpo .= "<td> $key :</td><td> $value </td>";
                              $cuerpo .= "</tr>";
                              
                            }
              

                if($datos=="revision"){
                  
                  $from='CrediQ';
                  $subject='Revision de Vehiculo';
                   $cuerpo = '<table cellspacing="0" callpadding="0"  width="389" height="180" border="0">';
                              $cuerpo .= "<tr>";
                  $cuerpo = "<th colspan=\"2\">Revision de Vehiculo de CrediQ</th>";
                  $cuerpo .= "</tr>";
                  $cuerpo .= "<tr>";
                  $cuerpo .= '<td align="center">
                        <h3>'.$emailTo.'</h3>
                        <b>Su vehiculo sera sometido a revision y posteriormente se le notificara si fue autorizado.</b>
                       </td>';

              }
              if($datos['accion']=="fue_aprobado"){
                  
                  $from='CrediQ';
                  $subject='Aprobacion de Vehiculo';
                  $cuerpo = '<table cellspacing="0" callpadding="0"  width="389" height="180" border="0">';
                  $cuerpo .= "<tr>";
                  $cuerpo = "<th colspan=\"2\">Aprobacion de Vehiculo de CrediQ</th>";
                  $cuerpo .= "</tr>";
                  $cuerpo .= "<tr>";
                  $cuerpo .= '<td align="center">
                        <h3>'.$emailTo['nombres']." ".$emailTo['apellidos'].'</h3>
                        <b>Felicidades su vehiculo '.$datos['marca'].' - '.$datos['modelo'].' ha sido aprobado .</b>
                       </td>';
                  $emailTo=$emailTo['email'];     

              }



                            
            }

            $cuerpo .= "</tr>";
            $cuerpo .= "</table>";

		//Email configuracion
	    $config = Array(

           'mailtype' => 'html'
        );

		//Load email library
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		//Set email parameters
		$this->email->from('usados@usadoscrediq.com', $from);
		$this->email->to($emailTo); 
		$this->email->subject($subject);
		$this->email->message($cuerpo);

		//Send the email
		if($this->email->send()){
      return TRUE;
    }else{
      return FALSE;
    }
	}

}