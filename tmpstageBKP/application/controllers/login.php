<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller{

    function __construct() {
  		parent::__construct();

    }

    function index() {
    	$this->load->view('template/login.php');
	}

    function logout() {
        $this->session->destroy();
        redirect(base_url().'index.php/login');
    }

}