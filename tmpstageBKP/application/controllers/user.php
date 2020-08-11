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

class User extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('data_model');
		$this->load->model('Secure_model');
		$this->load->model('filter_model'); 
		if(!$this->session->userdata('user_id'))
		redirect(base_url()."index.php/login");
	}

	function index()
	{
		redirect(base_url());
	}
	function general(){
		//Categorias (Tipos de Vehiculo)
		$data['admin'] = true;
		$data['categories'] = $this->data_model->getCategories();
		$data['paises']  = $this->data_model->getPaises();

		return $data;
	}
	function acount()
	{
		//MASTERPAGE
		//Categorias (Tipos de Vehiculo)
        $data = $this->general();
		
		$data['activeCars'] = $this->data_model->getUserCars($this->session->userdata('user_id'));
		
		$data['categories'] = $this->data_model->getCategories();
		$data['paises']  = $this->data_model->getPaises();
		//Publicidad
		$data['banners'] = $this->data_model->getBanners();
                
            
		//mostrar todo
		$data['template'] = 'template/acount';
		$this->load->view('template/masterpage', $data);
	}
	
	function detalle($id){
		$data = $this->general();
		
		//$this->session->set_userdata('pais', 1);
		//Categorias (Tipos de Vehiculo)
		
		//Productos (Carros)
		$data['car'] = $this->data_model->getUserCar($id, $this->session->userdata('pais'));

		if ( empty($data['car']) )
			$data['car'] = $this->data_model->getUserCar($id, $this->session->userdata('user_pais'));
		
		//echo 'total='.count($data['car']);
				
		//Colores del Carro
		$data['color_interior'] = $this->data_model->getColor($data['car']['color_interno']);
		$data['color_exterior'] = $this->data_model->getColor($data['car']['color_externo']);
		//Marcas
		//$data['marks'] = $this->data_model->getMarks();

		$data['tumbnails'] = $this->data_model->getTumbnails($id);
		
		$data['equipamiento']=$this->data_model->GetEquipamiento($id);

		$data['userReview'] =true;


		//mostrar todo
		$data['template'] = 'template/detalle-corto';
		$this->load->view('template/masterpage.php', $data);


	}
	
	function lista($lap=0){
		/*if(!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1)))
		{ redirect(base_url()); }
		    else
		{*/
			$data=$this->general();

			$limite='LIMIT '. $lap .', 12 ' ;

			$data['usuarios']=$this->data_model->getUsers($limite);

			$data['template'] = 'template/administrar-usuarios';

			$this->load->library('pagination');
			
			$total_result=count($this->data_model->getUsers(''));
		
			if($total_result>12){
				$config = $this->config->item('pagination');
				$config['base_url'] = base_url().'index.php/user/lista/';
				$config['total_rows'] = $total_result;
				$config['per_page'] = 12;
				$this->pagination->initialize($config);
				$data['pagination'] = $this->pagination->create_links();	
			}
			$this->load->view('template/masterpage', $data);
		/*}*/	

	}
	function modificar($id){
		/*if(!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1)))
		{ redirect(base_url()); }
		    else
		{*/
			$data=$this->general();

			$data['usuario'] = $this->data_model->getUser($id);

			$data['tipo_user'] = $this->data_model->getTipoUser();

			$data['telefonos'] = $this->Secure_model->getTelefonos($id);
			$data['template'] = 'template/update-user';

			$this->load->view('template/masterpage', $data);
		/*}*/
	}
	function crear(){

			$data=$this->general();

			$data['usuario']=$this->data_model->getUser($id);

			$data['tipo_user']=$this->data_model->getTipoUser();

			$data['template'] = 'template/user-crear';

			$this->load->view('template/masterpage', $data);
		/*}*/
	}

}
