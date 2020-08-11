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

class Credito extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('data_model');
		$this->load->model('function_model');
		$this->load->model('Savedata_model');
		
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
	function solicitud($tipo){
		$this->general();
		
		$data['template'] = 'template/solicitud_nuevos_1';
		$this->load->view('template/masterpage.php', $data);
	
	}

	


}