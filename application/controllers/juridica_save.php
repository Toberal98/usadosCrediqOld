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

class Juridica_save extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('data_model');
		$this->load->model('function_model');
		$this->load->model('Savedata_model');
		$this->load->helper('cookie');
		$this->load->library('Session');
	}

	function index()
	{
		redirect(base_url());
	}
	function general(){
		//Categorias (Tipos de Vehiculo)
		$data['categories'] = $this->data_model->getCategories();
		//Publicidad
		$data['banners'] = $this->data_model->getBanners();
		
		$data['bannersPosition'] = $this->data_model->Banners();
		
		$data['paises']  = $this->data_model->getPaises();
		$data['moneda'] = $this->session->userdata('moneda');

		return $data;
	}
	function credito_juridica($paso){
		
		if($paso==1){
			
			if($this->session->userdata('user_id')){
				$id_usuario=$this->session->userdata('user_id');	
			}else{
				$id_usuario=NULL;
			}
				$tipo_solicitud=$this->input->post('tipo_solicitud');
				
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
				$fecha=date("d-m-Y");
				$datos_generales=array( 'fecha'=>$fecha,
										'id_usuario'=>        $id_usuario,
										'producto'=>          $this->input->post('producto'),
										'valor_de_compra'=>  $this->input->post('valor_de_compra'),
										'valor_de_prima'=>    $this->input->post('valor_de_prima'),
										'canje'=>             $this->input->post('canje'),
										'valor_a_financiar'=> $this->input->post('valor_a_financiar'),
										'plazo'=>             $this->input->post('plazo'),
										'prima'=>             $this->input->post('prima'),
										'tasa'=>              $this->input->post('tasa'),
										'garantia'=>          $this->input->post('garantia'),
										'nueva'=>             $this->input->post('nueva'),
										'usada'=>             $this->input->post('usada'),
										'marca'=>             $this->input->post('marca'),
										'modelo'=>            $this->input->post('modelo'),
										'asesor_de_ventas'=>       $this->input->post('asesor_de_ventas'),
										'fecha_sugerida_de_pago'=> $this->input->post('fecha_sugerida_de_pago'),
										'tipo_solicitud'=>$tipo_solicitud,
										'estado'=>'editando'
									);
			$id_solicitud=$this->session->userdata('id_solicitud');						
			if($id_solicitud==""){
				$id_solicitud=$this->Savedata_model->guardar('cq_sol_solicitud', $datos_generales);
				$this->session->set_userdata('id_solicitud',$id_solicitud);
			}
															
			$this->session->set_userdata('datos_generales',$datos_generales);
			$this->session->set_userdata('paso1','ok');
			
			redirect(base_url() . 'index.php/solicitud/credito_juridica/2');
			
			
			
		}elseif($paso==2){
			if($this->session->userdata('paso1')=='ok'){
				//guardamos datos paso2
				
				$solicitante=array();
				
				$id_solicitud=$this->session->userdata('id_solicitud');	
				
				$tipo_solicitud=$this->input->post('tipo_solicitud');
				
				 $solicitante=array( 
										'id_solicitud'=>        		$id_solicitud,
										'razon_social'=>     			$this->input->post('razon_social'),
										'nombre_comercial'=>  			$this->input->post('nombre_comercial'),
										'fecha_constitucion'=>    		$this->input->post('fecha_constitucion'),
										'no_registro_fiscal'=>        	$this->input->post('no_registro_fiscal'),
										'giro_actividad_economica'=> 	$this->input->post('giro_actividad_economica'),
										'direccion_actual'=>     		$this->input->post('direccion_actual'),
										'casa'=>             			$this->input->post('casa'),
										'pago_mensual'=>              	$this->input->post('pago_mensual'),
										'tiempo_de_operar'=>  			$this->input->post('tiempo_de_operar'),
										'empleados'=>           		$this->input->post('empleados'),
										'empleados_masculino'=>			$this->input->post('empleados_masculino'),
										'empleados_femenino'=>          $this->input->post('empleados_femenino'),
										'telefono'=>           			$this->input->post('telefono'),
										'fax'=>        					$this->input->post('fax'),
										'nombre_del_contacto'=> 		$this->input->post('nombre_del_contacto'),
										'email'=> 						$this->input->post('email'),
										'tipo_solicitud'=>				$tipo_solicitud ,
										'ventas_anuales'=>				$this->input->post('ventas_anuales')
									);
									
									
				
										
										
			$ref_bank1=array(    		
										'id_solicitud'=>         $id_solicitud,
										'bancaria'=>    		 $this->input->post('ref_bancaria1'),
										'tipo'=>         		 $this->input->post('ref_tipo1'),
										'tipo_solicitud'=>     	 'juridica',
										'tipo_info'=>  			 'solicitante'
										);
			$ref_bank2=array(    		
										'id_solicitud'=>         $id_solicitud,
										'bancaria'=>    		 $this->input->post('ref_bancaria2'),
										'tipo'=>         		 $this->input->post('ref_tipo2'),
										'tipo_solicitud'=>     	 'juridica',
										'tipo_info'=>  			 'solicitante'
										);
										
										
			$ref_comercial1=array(    		
										'id_solicitud'=>         $id_solicitud,
										'Comercial'=>    		 $this->input->post('ref_Comercial1'),
										'tipo_solicitud'=>       'juridica',
										'tipo_info'=>     	     'solicitante',
										'n_cuenta'=>  			 $this->input->post('ref_n_cuenta1'),
										'telefono'=>			 $this->input->post('ref_telefono1'),
										);
			$ref_comercial2=array(    		
										'id_solicitud'=>         $id_solicitud,
										'Comercial'=>    		 $this->input->post('ref_Comercial2'),
										'tipo_solicitud'=>       'juridica',
										'tipo_info'=>     	     'solicitante',
										'n_cuenta'=>  			 $this->input->post('ref_n_cuenta2'),
										'telefono'=>			 $this->input->post('ref_telefono2'),
										);							
																	
													
										
										
										
				$this->session->set_userdata('solicitante',$solicitante);
				
				
				$this->session->set_userdata('ref_bank1',$ref_bank1);
				$this->session->set_userdata('ref_bank2',$ref_bank2);
				
				$this->session->set_userdata('ref_comercial1',$ref_comercial1);
				$this->session->set_userdata('ref_comercial2',$ref_comercial2);
				
				
				
				$this->session->set_userdata('paso2','ok');
									
				redirect(base_url() . 'index.php/solicitud/credito_juridica/3');
				
				echo 'total_info_laboral | '.count($this->session->userdata('info_laboral'));
				
			}else{
				redirect(base_url() . 'index.php/solicitud/credito_juridica/1');
			}
			
		}elseif($paso==3){
			if($this->session->userdata('paso1')!='ok'){
										
				redirect(base_url() . 'index.php/solicitud/credito_juridica/1');				
									
			}elseif($this->session->userdata('paso2')!='ok'){
				
				redirect(base_url() . 'index.php/solicitud/credito_juridica/2');
				
			}else{
				
				
				$tipo_solicitud=$this->input->post('tipo_solicitud');
				//unos pocos Datos del fiador';
				$id_solicitud=$this->session->userdata('id_solicitud');	
				$representante=array(
										'id_solicitud'=>        $id_solicitud,
										'nombre'=>     	$this->input->post('nombre'),
										
										'sexo'=>    			$this->input->post('sexo'),
										'fecha_nacimiento'=> 	$this->input->post('fecha_nacimiento'),
										'nacionalidad'=>        $this->input->post('nacionalidad'),
										'estado_familiar'=>     $this->input->post('estado_familiar'),
										'dui'=>             	$this->input->post('dui'),
										'nit'=>              	$this->input->post('nit'),
										'profesion'=>			$this->input->post('profesion'),
										'email'=>				$this->input->post('email'),
										'celular'=> 			$this->input->post('celular'),
										'n_dependientes'=>		$this->input->post('n_dependientes'),
										'direccion_particular'=>$this->input->post('direccion_particular'),
										
										'telefono'=> 			$this->input->post('telefono'),
										'tipo_vivienda'=>		$this->input->post('tipo_vivienda'),
										
										'tiempo_de_residir'=>	$this->input->post('tiempo_de_residir'),
										'pago_mensual'=>	$this->input->post('pago_mensual')
										
									);
				$repre_laboral=array(  'id_solicitud'=>         $id_solicitud,
										'tipo_solicitud'=>     	 $tipo_solicitud,
										'tipo_info'=>  			 'representante',
										'lugar'=>    			 $this->input->post('lab_lugar'),
										'fecha_ingreso'=>        $this->input->post('lab_fecha_ingreso'),
										'direccion'=> 			 $this->input->post('lab_direccion'),
										'cargo'=>     			 $this->input->post('lab_cargo'),
										'jefe_inmediato'=>       '',
										'telefono'=>             $this->input->post('lab_telefono'),
										'salario'=>  			 $this->input->post('lab_salario'),
										'otros_ingresos'=>       $this->input->post('lab_otros_ingresos'),
										'origen_otros_ingresos'=>$this->input->post('lab_origen_otros_ingresos'),
										'gastos'=>          	 '',
										'anterior'=>           	 '',
										'anterior_tel'=>         '',
										'anterior_desde'=> 		 '',
										'anterior_hasta'=> 		 '',
										'anterior_ingresos'=>	 '' );
										
										
				$repre_conyuge=array(  'id'=>         			 '',
										'id_solicitud'=>        $id_solicitud,
										'nombre'=>    			$this->input->post('con_nombre'),
										'lugar_trabajo'=>       $this->input->post('con_lugar_trabajo'),
										'cargo'=>     			'',
										'fecha_ingreso'=>      	$this->input->post('con_fecha_ingreso'),
										'telefono'=>            $this->input->post('con_telefono'),
										'celular'=>  			$this->input->post('con_celular'),
										'salario'=>      		$this->input->post('con_salario'),
										'email'=>				$this->input->post('con_email'), 
										'tipo_solicitud'=>     	 $tipo_solicitud,
										'tipo_info'=>  			 'representante'
										);
										
				$repre_vehiculo=array( 'id'=>         			 '',
										'id_solicitud'=>        $id_solicitud,
										'vehiculo_propio'=>    	$this->input->post('vehiculo_propio'),
										'marca'=>     			$this->input->post('marca'),
										'modelo'=>      		$this->input->post('modelo'),
										'year'=>            	$this->input->post('year'),
										'placa'=>  				$this->input->post('placa'),
										'financiado'=>      	$this->input->post('financiado'),
										'tipo_solicitud'=>     	$tipo_solicitud,
										'tipo_info'=>  			 'representante'
										);
				
				
			    $repre_ref_financiera=array(    		
										'id_solicitud'=>         $id_solicitud,
										'financiera'=>    		 $this->input->post('ref_financiera'),
										'otorgamiento'=>         '',
										'vencimiento'=>     	 '',
										'monto'=>      	         '',
										'saldo'=>     	         '',
										'cuota'=>  			     '',
										'tipo_solicitud'=>     	 $tipo_solicitud,
										'tipo_info'=>  			 'representante'
										);
										
			$repre_ref_tarjeta=array(    		
										'id_solicitud'=>       $id_solicitud,
										'emisor'=>    		   $this->input->post('ref_tarjeta_emisor'),
										'_2_'=>         		   $this->input->post('ref_tarjeta_2'),
										'tipo_solicitud'=>     $tipo_solicitud,
										'tipo_info'=>  		    'representante'
										);
										
										
										
			$repre_ref_comercial=array(    		
										'id_solicitud'=>       $id_solicitud,
										'comercial'=>    	    $this->input->post('ref_comercial'),
										'tipo_solicitud'=>     $tipo_solicitud,
										'tipo_info'=>  		    'representante',
										'n_cuenta'=>  		    '',
										'telefono'=>  		    '',
										);
			$repre_ref_personal1=array(    		
										'id_solicitud'=>       $id_solicitud,
										'personal'=>    	    $this->input->post('ref_personal1'),
										'telefono'=>     		$this->input->post('ref_per_telefono1'),
										'celular'=>  		    $this->input->post('ref_per_celular1'),
										'direccion'=>  		    '',
										'parentesco'=>  		'',
										'direccion_trabajo'=>  	'',
										'tipo_referencia'=>  	'personal',
										'tipo_solicitud'=>  	$tipo_solicitud,
										'tipo_info'=>  		    'representante'
										);
			$repre_ref_personal2=array(    		
										'id_solicitud'=>       $id_solicitud,
										'personal'=>    	    $this->input->post('ref_personal2'),
										'telefono'=>     		$this->input->post('ref_per_telefono2'),
										'celular'=>  		    $this->input->post('ref_per_celular2'),
										'direccion'=>  		    '',
										'parentesco'=>  		'',
										'direccion_trabajo'=>  	'',
										'tipo_referencia'=>  	'personal',
										'tipo_solicitud'=>  	$tipo_solicitud,
										'tipo_info'=>  		    'representante'
										);							
										
			
			$this->session->set_userdata('representante',$representante);
			$this->session->set_userdata('repre_laboral',$repre_laboral);
			$this->session->set_userdata('repre_conyuge',$repre_conyuge);
			$this->session->set_userdata('repre_vehiculo',$repre_vehiculo);
			
			$this->session->set_userdata('repre_ref_financiera',$repre_ref_financiera);
			
			$this->session->set_userdata('repre_ref_tarjeta',$repre_ref_tarjeta);
			
			$this->session->set_userdata('repre_ref_comercial',$repre_ref_comercial);
			
		
			$this->session->set_userdata('repre_ref_personal1',$repre_ref_personal1);
			$this->session->set_userdata('repre_ref_personal2',$repre_ref_personal2);
			
			//echo '<br>ok<br>';
			
			//guardaMOS Data en respectivos campos
			//guardaMOS Data en respectivos tablas
			//paso 1
			
				$datos_generales=$this->session->userdata('datos_generales');
				$datos_generales['estado']='pendiente';
				$this->session->set_userdata('datos_generales',$datos_generales);
				
       			$this->Savedata_model->actualizar(array('id_solicitud'=>$this->session->userdata('id_solicitud')), 'cq_sol_solicitud', $this->session->userdata('datos_generales'));
	  
	  //paso 2
	  
      			$this->Savedata_model->guardar('cq_sol_solicitante_juridico',  $this->session->userdata('solicitante'));
      			$this->Savedata_model->guardar('cq_sol_referencia_bancaria', $this->session->userdata('ref_bank1'));
      			$this->Savedata_model->guardar('cq_sol_referencia_bancaria',      $this->session->userdata('ref_bank2'));
				
      			$this->Savedata_model->guardar('cq_sol_referencia_comercial',     $this->session->userdata('ref_comercial1'));
				$this->Savedata_model->guardar('cq_sol_referencia_comercial',     $this->session->userdata('ref_comercial2'));
				
	
	//paso 3		
	  			$this->Savedata_model->guardar('cq_sol_representante_legal',  $this->session->userdata('representante'));
      			$this->Savedata_model->guardar('cq_sol_info-laboral',  $this->session->userdata('repre_laboral'));
      			$this->Savedata_model->guardar('cq_sol_conyuge',  $this->session->userdata('repre_conyuge'));
      			$this->Savedata_model->guardar('cq_sol_vehiculo',  $this->session->userdata('repre_vehiculo'));


      			$this->Savedata_model->guardar('cq_sol_referencia_financiera',  $this->session->userdata('repre_ref_financiera'));

      			$this->Savedata_model->guardar('cq_sol_referencia_tarjeta_credito',  $this->session->userdata('repre_ref_tarjeta'));
      			

      			$this->Savedata_model->guardar('cq_sol_referencia_comercial',  $this->session->userdata('repre_ref_comercial'));
      
      			$this->Savedata_model->guardar('cq_sol_referencia',  $this->session->userdata('repre_ref_personal1'));
      			$this->Savedata_model->guardar('cq_sol_referencia',  $this->session->userdata('repre_ref_personal2'));
	  			
				//echo '</br>la data se ha guardado</br>';
	  			
				$send_Data=array('tipo'=>'solicitud_juridica',
								 'to'=>'info.sv@crediq.com',
								 'datos_generales'=>$datos_generales,
								 'solicitante' => $this->session->userdata('solicitante'),
      							 'ref_bank1' => $this->session->userdata('ref_bank1'),
      							 'ref_bank2' => $this->session->userdata('ref_bank2'),
      							 'ref_comercial1' => $this->session->userdata('ref_comercial1'),
								 'ref_comercial2' => $this->session->userdata('ref_comercial2'),
	  							 'representante' => $this->session->userdata('representante'),//datos del representate legal
      							 'repre_laboral' => $this->session->userdata('repre_laboral'),
      							 'repre_conyuge' => $this->session->userdata('repre_conyuge'),
      							 'repre_vehiculo' => $this->session->userdata('repre_vehiculo'),
      							 'repre_ref_financiera' => $this->session->userdata('repre_ref_financiera'),
      							 'repre_ref_tarjeta' => $this->session->userdata('repre_ref_tarjeta'),
      							 'repre_ref_comercial' => $this->session->userdata('repre_ref_comercial'),
      							 'repre_ref_personal1' => $this->session->userdata('repre_ref_personal1'),
      							 'repre_ref_personal2' => $this->session->userdata('repre_ref_personal2')
								 	
								);
				
				$this->function_model->enviarMail($send_Data);
				
	  			//vaciamos sesiones
	  			$this->session->set_userdata('id_solicitud','');
				
	  			session_destroy();
				
	  			//echo '</br>la data se ha guardado</br>';
				
				
				redirect(base_url() . 'index.php/solicitud/juridica_saved');
				
				
				
				//redirect(base_url() . 'index.php/solicitud/credito_juridica/3');
				
			}
		}else{
			$data['template'] = 'template/solicitud-natural_1';
		}
		
		//$this->load->view('template/masterpage.php', $data);
	
	}
	
	
	function credito_juridico($paso){
		
		$data = $this->general();
		
		if($paso==1){
			$data['template'] = 'template/solicitud-juridico_1';
		}else
		if($paso==2){
			//if(count($this->session->userdata('paso1'))<1){
				//$data['template'] = 'template/solicitud-nuevos_1';
			//}else{
				$data['template'] = 'template/solicitud-juridico_2';
			//}
		}
		else
		if($paso==3){
			//if(count($this->session->userdata('paso1'))<1 or count($this->session->userdata('paso2'))<1){
				//$data['template'] = 'template/solicitud-nuevos_1';
			//}else{
				$data['template'] = 'template/solicitud-juridico_3';
			//}
		}else{
			$data['template'] = 'template/solicitud-juridico_1';
		}
		
		$this->load->view('template/masterpage.php', $data);
	
	}
	
	
	
	
	


}