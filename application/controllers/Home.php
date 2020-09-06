<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH."libraries/Room.php");
require_once (APPPATH."libraries/Facility.php");
require_once (APPPATH."libraries/Calendar.php");
require_once (APPPATH.'libraries/Utils.php');
require_once (APPPATH.'libraries/Notification.php');
require_once (APPPATH.'libraries/interface/User.php');
require_once (APPPATH.'libraries/interface/Event.php');

class Home extends CI_Controller {

	public $user;
	public $event;
	public $eventP;

	public $room;
	public $facility;
	public $calendar;
	public $notification;

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('parser');
		$this->load->helper('url');
		$this->room = new Room();
		$this->facility = new Facility();
		$this->calendar = new Calendar();
		$this->utils = new Utils();

		$this->user = new User();
		$this->event = new Event();
		$this->eventP = new EventPassive();
		$this->notification = new Notification();
	}

	// dashboard

	public function index(){
		// rest user
		$data['user'] = $this->user;		
		$this->load->view('index', $data);
	}

	public function calendar(){
		$data['t'] = $this->load->view('pages/dashboard/calendar', NULL);
		return $data;
	}

	public function calendar_events(){
		$q = $this->calendar->get_user_event();
		$i=0;
		foreach($q as $r){
			foreach($r as $key=>$val){
				$c[$i][$key] = $val;
			}
			$i++;
		}
		echo json_encode($c, true);
	}

	public function under_construction(){
		return $this->load->view('errors/under_construction');
	}

}
