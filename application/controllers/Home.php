<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH."libraries/Room.php");
require_once (APPPATH."libraries/Facility.php");
require_once (APPPATH."libraries/Calendar.php");
require_once (APPPATH.'libraries/Utils.php');
require_once (APPPATH.'libraries/Notification.php');
require_once (APPPATH.'libraries/interface/User.php');
require_once (APPPATH.'libraries/interface/Event.php');
require_once (APPPATH.'libraries/Auth.php');

class Home extends CI_Controller {

	public $user;
	public $event;
	public $eventP;

	public $room;
	public $facility;
	public $calendar;
	public $notification;

	public $auth;

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('parser');
		$this->load->helper('url');
		$this->load->Model('MUsers');
		$this->room = new Room();
		$this->facility = new Facility();
		$this->calendar = new Calendar();
		$this->user = new User(isset($_SESSION['logged_in']['user']));
		$this->utils = new Utils();
		$this->event = new Event();
		$this->eventP = new EventPassive();
		$this->notification = new Notification();
	}

	public function index(){
		$this->load->view('index');
	}

	public function login(){
		$data['nik'] = $_POST['nik'];
		$data['password'] = $_POST['password'];

		$this->auth = new Auth();
		$login = $this->auth->login($data);
		if($login){
			$user = $this->MUsers->__user($data['nik'])[0];

			$log['login_time'] = $this->utils->dateTimeNow();
			$log['ip'] = $this->utils->getUserIPAddress();

			$session_data['log'] = $log;

			$session_data['user'] = new User($user);
			$this->session->set_userdata('logged_in', $session_data);
		}
		echo json_encode($login, true);
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('');
	}

	// dashboard

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
