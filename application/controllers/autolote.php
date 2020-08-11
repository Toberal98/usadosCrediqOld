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
class Autolote extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('data_model');
        $this->load->model('function_model');
        $this->load->model('Savedata_model');
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

    
	function usuarios($lap=1){
		if (!$this->session->userdata('user_id') or $this->session->userdata('user_perfil') != '1') {
            redirect(base_url());
        } else {
			$data = $this->general();
			
			$criterio=$this->input->post('criterio');
			
			$limite = "LIMIT " . $lap . ', 12';
			
			if($criterio!=''){
				$data['usuarios']=$this->data_model->buscar($criterio,$limite);
				$total=count($this->data_model->buscar($criterio,''));
			}else{
				$data['usuarios']=$this->data_model->autolote_users($limite);
				$total=count($this->data_model->autolote_users(''));
			}
			
			$this->load->library('pagination');

            if ($total > 12) {

                $config['base_url'] = base_url() . 'index.php/autolote/usuarios';
                $config['total_rows'] = $total;
                $config['per_page'] = 12;
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
            }

			$data['template'] = 'template/primium-usuarios';
        	$this->load->view('template/masterpage', $data);
		}
	}
	
	function primium($accion,$id){
		if (!$this->session->userdata('user_id') or $this->session->userdata('user_perfil') != '1') {
            redirect(base_url());
        } else {
			$data = $this->general();
            $data['tipo']='35';
			if($accion=="Marcar"){
				$this->Savedata_model->actualizar(array('id_usuario'=>$id), 'cq_usuario', array('primium'=>'1','fecha_registro'=>date("d-m-Y")));
			}else if($accion=="Quitar"){
				$this->Savedata_model->actualizar(array('id_usuario'=>$id), 'cq_usuario', array('primium'=>'0','fecha_registro'=>""));
                $data['tipo']='36';
			}
			//
            
            $data['template'] = 'template/aviso';       //
        	$this->load->view('template/masterpage', $data);
		}
	}
	function add(){
		if (!$this->session->userdata('user_id') or $this->session->userdata('user_perfil') != '1') {
            redirect(base_url());
        } else {
			$data = $this->general();
			
			$data['template'] = 'template/add-autolote';
        	$this->load->view('template/masterpage', $data);
		}
	}
	function leer(){
		if (!$this->session->userdata('user_id') or $this->session->userdata('user_perfil') != '1') {
            redirect(base_url());
        }else{
			$data = $this->general();
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
			$key=substr(md5(date('d-m-Y H:i:s')),0 ,6);
			
			$destino=$_SERVER['DOCUMENT_ROOT'].'/public/autolotes/'.$key.$_FILES["archivo"]['name'];;
			
			//echo 'destino='.$destino.'<br /><br />';
			
			if(copy($_FILES['archivo']['tmp_name'],$destino)){
			
				// archivo txt
				$lineas=file($destino);
				// iniciamos contador y la fila a cero
				
				//insertamos autolote
				$usuario=$this->session->userdata('user_id');
				$datos=array(
							'nombrecorto'=>$this->input->post('nombre'),
							'idUsuario'=>$usuario
							);
				$lote_id=$this->Savedata_model->guardar('cq_autolotes', $datos);
				
				foreach ($lineas as $num_linea => $linea) {
					
					//echo "Línea : " . $linea . "<br />\n";
					
					if($linea!=""){
						$datos = explode(",",$linea);
						// imprimimos datos en pantalla
						
						$maxid = $this->data_model->maxid();
						$maxid = $maxid['max_id']+1;
						$car_id = $this->Savedata_model->guardar('cq_ids',array('id_automovil' => $maxid ));
						$car_id = $this->session->userdata('user_id').$car_id;

						$datos=array(
						'id_automovil'=>$car_id,	
						'tipo_combustible' => $datos[0],
						'marca' => $datos[1],
						'modelo' => $datos[2],
						'year' => $datos[3],
						'capacidad_de_motor' => $datos[4],
						'tipo_vehiculo' => $datos[5],
						'tipo_transmision' => $datos[6],
						'traccion' => $datos[7],
						'color_externo' => $datos[8],
						'color_interno' => $datos[9],
						'numero_puertas' => $datos[10],
						'numero_asientos' => $datos[11],
						'tipo_ingreso' => $datos[12],
						'numero_de_placa' => $datos[13],
						'kilometraje' => $datos[14],
						'estado' => 'pendiente',
						'pais' => $this->session->userdata('pais'),
						'precio' => $datos[15],
						'usuario' => $usuario,
						'lote' => $lote_id
						
						);
						
						$this->Savedata_model->guardar('cq_automovil', $datos);
						
					}
					
				}
				
			}else{
				echo 'error al copiar archivo';
			}
			
			$data['template'] = 'template/add-autolote';
        	$this->load->view('template/masterpage', $data);
		}
	}

}