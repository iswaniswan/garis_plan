<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
	}

	public function index()
	{
		if(isset($this->session->userdata['logged_in'])){
			$this->load->view('template/home');
		}else{
			redirect('Home');
		}
	}
}
