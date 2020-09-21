<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH.'controllers/Home.php');

class Report extends Home {

	public function __construct(){
		parent::__construct();
	}
	

	// room reservation

	public function room_reservation(){
		$data['room'] = $this->room->activity_room_past();
		$data['t'] = $this->load->view('pages/report/room_reservation/table', $data);
		return $data;
	}

	public function room_reservation_order(){
		$this->under_construction();
	}

	// event 

	public function event(){
		$data['event'] = $this->calendar->event_table_past();
		return $this->load->view('pages/report/event/table', $data);
	}

	// notification

	public function notification(){		
		$data['notification'] = $this->notification->get_all_past_notification_by_user();
		$this->load->view('pages/report/notification', $data);
	}

}
