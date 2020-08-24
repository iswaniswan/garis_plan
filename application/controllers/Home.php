<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH."libraries/Room.php");
require_once (APPPATH."libraries/Facility.php");
require_once (APPPATH."libraries/Calendar.php");

class Home extends CI_Controller {

	private $room;
	private $facility;
	private $calendar;

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('parser');
		$this->load->helper('url');
		$this->room = new Room();
		$this->facility = new Facility();
		$this->calendar = new Calendar();
	}

	public function index(){
		$data['dashboard'] = 1;
		$this->load->view('index', $data);
	}

	public function calendar(){
		$data['t'] = $this->load->view('pages/dashboard/calendar', NULL);
		return $data;
	}

	public function calendar_events(){
		$q = $this->calendar->get_all_data();
		$i=0;
		foreach($q as $r){
			foreach($r as $key=>$val){
				$c[$i][$key] = $val;
			}
			$i++;
		}
		echo json_encode($c, true);
	}

	public function reserve_room_new(){
		$q = $this->room->get_all_data();
		$i=0;
		foreach($q as $r){
			foreach($r as $key=>$val){
				if($key == 'facilities'){
					$arrStr = $this->facility->get_facility_name_by_id($val);
					$room[$i][$key] = join(', ', $arrStr);
				}else{
					$room[$i][$key] = $val;
				}
			}
			$i++;
		}
		$d['room'] = $room;
		$data['t'] = $this->load->view('pages/activity/reserve_room/order', $d);
		return $data;
	}

	public function reserve_room_submit(){
		
	}

	public function room(){
		$q = $this->room->get_all_data();
		$i=0;
		foreach($q as $r){
			foreach($r as $key=>$val){
				$room[$i][$key] = $val;
			}
			$i++;
		}
		$d['room'] = $room;
		$data['t'] = $this->load->view('pages/settings/data/room', $d);
		return $data;
	}

	public function facilities(){
		$q = $this->facility->get_all_data();
		$i=0;
		foreach($q as $r){
			foreach($r as $key=>$val){
				$fa[$i][$key] = $val;
			}
			$i++;
		}
		$d['fa'] = $fa;
		$data['t'] = $this->load->view('pages/settings/data/facilities', $d);
		return $data;
	}

	public function test(){
		
		echo phpversion();
	}
}
