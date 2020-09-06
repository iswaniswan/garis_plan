<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH.'controllers/Home.php');

class Report extends Home {

	public function __construct(){
		parent::__construct();
	}
	

	// room reservation

	public function room_reservation_list(){
		$this->under_construction();
	}

	public function room_reservation_order(){
		$this->under_construction();
	}

	// event 

	public function event_daily(){
		$this->under_construction();
	}

	// notification

	public function notification(){		
		$this->under_construction();
	}

}
