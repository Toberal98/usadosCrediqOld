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
class Secure_model extends CI_Model
{
	
	//Inicio de Session de un Usuario
	function login($username, $password){

		$password=trim($password);
		
		$this->db->where('estado', 'activo');
		$this->db->where('email', $username);
		$this->db->where('clave', md5($password));
		//$this->db->where('pais', $this->session->userdata('pais'));
		$query = $this->db->get('cq_usuario');

		if($query->num_rows() > 0)
		{
			$user = $query->row_array();
			$split = explode(' ', $user['nombres']);
			$user_name = $split[0];
			$split = explode(' ', $user['apellidos']);
			$user_name .= ' ' . $split[0];

			$data = array(
                'user_id'   => $user['id_usuario'],
                'user_name' => $user_name,
                'user_pais' => $user['pais'],
                'user_perfil'    => $user['tipo_usuario'],
                'user_email'=>$username,
                'user_nombres'=>$user['nombres'],
                'user_apellidos'=>$user['apellidos'],
                'user_clab'=>$user['clave']
            );
			$this->session->set_userdata($data);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/*
	* cuando se hace click en un banner se manda a llamar getBannerURL
	* obtiene la URL hacia adonde debe direccionar y aumenta el record de clicks en el banner
	*/
	function getBannerURL($id)
	{
		$this->db->where('id_banner', $id);
		$query = $this->db->get('cq_banner');
		//Si encontramos el banner
		if($query->num_rows() > 0)
		{
			//Recuperamos data
			$banner = $query->row_array();
			//Actualizamos Click de Banners
			$datos = array('clicks' => ($banner['clicks'] + 1));
			$this->db->where('id_banner', $banner['id_banner']);
			$this->db->update('cq_banner', $datos);
			//Retornamos el link correspondiente al banner
			return $banner['link'];
		}
		//Si no lo encontramos retornamos FALSE
		return FALSE;
	}
	function generateClave($nombre){

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

          	$md5 = md5(date("d-m-Y H:i:s a")); 


          	$codigo = substr($md5,0,5);
          	
            
          	$rand="!";
            for ($i=1; $i <= 5; $i++) { 
                $rand.=rand(0,9);
            }
          	$clave=$codigo.$rand;
            $clave=trim($clave); 

           	return $clave;

	}
	
   
	function getTelefonos($id_user){
		$query = $this->db->query("SELECT * FROM cq_telefonos WHERE id_usuario= '".$id_user."' ");
		return $query->result_array();
	}
	
	 
	 // MODIFICADO POR GGONZALEZ 11/05/2015 INI    
	function getTel($id_user){
		$query = $this->db->query("SELECT telefono FROM cq_telefonos WHERE id_usuario= '".$id_user."' ");
		return $query->result_array();
	}
 // MODIFICADO POR GGONZALEZ 11/05/2015 FIN 
	
	function activateAccount($key){
		
 			
          	$this->db->where('estado', $key);
			$this->db->where('pais', $this->session->userdata('pais'));
			$query = $this->db->get('cq_usuario');

			if($query->num_rows() > 0)
			{
				$user = $query->row_array();
				
                		$this->db->where('id_usuario', $user['id_usuario']);
                		$this->db->where('estado', $key);

                        $estado="activo";

                		$data = array(
               				
               				'estado' => $estado
           	 			);

                        $this->db->update('cq_usuario', $data); 

					return TRUE;

			}else{

			return FALSE;
		   	
		   	}

	}
	function checkEmail($email){
		
 			
          	$this->db->where('email', $email);
			//$this->db->where('pais', $this->session->userdata('pais'));
			$query = $this->db->get('cq_usuario');

			if($query->num_rows() > 0)
			{
					return TRUE;

			}else{
			      return FALSE;
		   	}

	}

	function updatePassword($email,$newPass){
 			$newPass=md5($newPass);
          	$data = array(
               'clave' => $newPass
            );
   			$this->db->where('email', $email);
			$this->db->update('cq_usuario', $data);
					return TRUE;
	}

	function recaptcha_get_html($pubkey, $error = null, $use_ssl = false){

	if ($pubkey == null || $pubkey == '') {
		die ("To use reCAPTCHA you must get an API key from <a href='https://www.google.com/recaptcha/admin/create'>https://www.google.com/recaptcha/admin/create</a>");
	}
	
	if ($use_ssl) {
                $server = 'https://www.google.com/recaptcha/api';
        } else {
                $server = 'http://www.google.com/recaptcha/api';
        }

        $errorpart = "";
        if ($error) {
           $errorpart = "&amp;error=" . $error;
        }
        return '<script type="text/javascript" src="'. $server . '/challenge?k=' . $pubkey . $errorpart . '"></script>

		<noscript>
  		<iframe src="'. $server . '/noscript?k=' . $pubkey . $errorpart . '" height="300" width="500" frameborder="0"></iframe><br/>
  		<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
  		<input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
		</noscript>';
 	}
	 
}
