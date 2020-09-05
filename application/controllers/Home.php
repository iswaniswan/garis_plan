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

	// just for develeop, static user
	private $user;
	private $event;
	private $eventP;

	private $room;
	private $facility;
	private $calendar;
	private $notification;

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

	// notification
	public function notification(){		
		$data['notification'] = $this->notification->get_all_notification_by_user();
		$this->load->view('pages/activity/event/notification', $data);
	}

	public function get_user_notification_alert(){
		$notification = $this->notification->get_user_notification_alert();
		echo json_encode($notification, true);
	}

	public function get_notification_by_id(){
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$notification = $this->notification->get_detail_notification($id);
			echo json_encode($notification, true);
		}
	}

	public function set_notification_has_read(){
		if(isset($_POST['id'])){
			$notification = $this->notification->update_notification_by_id($_POST['id']);
		}
	}

	// public function get_event_passive(){
	// 	if(isset($_POST['id'])){
	// 		$notification = $this->notification->update_notification_by_id($_POST['id']);
	// 	}
	// }

	public function add_event_passive(){
		$event['event_id'] = $_POST['event_id'];
		$event['is_join'] = $_POST['is_join'];

		$event['user_id'] = $this->user->id;

		$this->eventP->setEvent($event);
		$response['data'] = $this->calendar->eventPassive_add($this->eventP->getEvent());

		echo json_encode($response, true);
		
	}

	public function update_event_passive(){
		$event['event_id'] = $_POST['event_id'];
		$event['is_cancel'] = $_POST['is_cancel'];

		$event['user_id'] = $this->user->id;

		$this->eventP->setEvent($event);
		$response['data'] = $this->calendar->eventPassive_update($this->eventP->getEvent());

		echo json_encode($response, true);
		
	}


	// activity event

	public function reserve_room_new(){
		$q = $this->room->get_room();
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
		$data['t'] = $this->load->view('pages/activity/event/reservation', $d);
		return $data;
	}

	public function reserve_room_submit(){		
		$response['data'] = [];
		$response['error'] = 0;
		$response['message'] = '';

		$valid = true;
		
		$event['date_start'] = (empty($_POST['start']) || $_POST['start'] == null ? $valid = false : $_POST['start'] );
		$event['date_end'] = (empty($_POST['end']) || $_POST['end'] == null ? $valid = false : $_POST['end'] );
		$event['title'] = (empty($_POST['title']) || $_POST['title'] == null ? $valid = false : $_POST['title'] );
		$event['type'] = (empty($_POST['type']) || $_POST['type'] == null ? $valid = false : $_POST['type'] );
		$event['note'] = (empty($_POST['note']) || $_POST['note'] == null ? '' : $_POST['note'] );
		$event['participant'] = (empty($_POST['participant']) || $_POST['participant'] == null ? '[]' : $_POST['participant'] );		
		$event['room_id'] = (empty($_POST['room_id']) || $_POST['room_id'] == null ? '' : $_POST['room_id'] );
		$event['branch'] = (empty($_POST['branch']) || $_POST['branch'] == null ? '' : $_POST['branch'] );

		if($valid){
			$event['updated_by'] = $this->user->id;

			$this->event->setEvent($event);
			$response['data'] = $this->calendar->event_add($this->event->getEvent());
			$response['message'] = 'success';
		}else{
			$response['error'] = 1;
		}

		echo json_encode($response, true);
	}

	public function set_day_off(){
		$data['t'] = $this->load->view('pages/activity/event/dayoff');
		return $data;
	}

	// settings->data->room

	public function room(){
		$d['room'] = $this->room->get_room();
		$data['t'] = $this->load->view('pages/settings/data/room', $d);
		return $data;
	}

	public function room_view(){
		$id = $_POST['id'];
		$combined['room'] = $this->room->get_room_by_id($id);
		$combined['facilities'] = $this->facility->get_facilities_id_name();
		
		// string array to array conversion
		if($combined['room'][0]['facilities']){						
			$q = $this->utils->extract_square_bracket($combined['room'][0]['facilities']);
			
			$arr = explode(",", $q);
			$arrInt = Array();
			foreach($arr as $key=>$val){
				$arrInt[] = (int)$val ;
			}
			$combined['room'][0]['facilities'] = $arrInt;
		}
		$data['data'] = $combined;
		echo json_encode($data, true);
	}

	public function room_insert(){
		$data['name'] = $_POST['name'];
		$data['capacity'] = $_POST['capacity'];
		$data['facilities'] = $_POST['facilities'];
		$data['floor'] = $_POST['floor'];
		$data['location'] = $_POST['branch'];
		$result = $this->room->insert_room($data);
		
		echo json_encode($result, true);
	}

	public function room_update(){
		$data['id'] = $_POST['id'];
		$data['name'] = $_POST['name'];
		$data['capacity'] = $_POST['capacity'];
		$data['facilities'] = $_POST['facilities'];
		$data['floor'] = $_POST['floor'];
		$data['location'] = $_POST['branch'];
		$data['is_available'] = $_POST['is_available'];
		$data['updated_by'] = (!empty($_POST['updated_by']) ? $_POST['updated_by'] : 0);
		$result = $this->room->update_room($data);
		
		echo json_encode($result, true);
	}

	public function room_update_delete(){
		$data['id'] = $_POST['id'];
		$data['updated_by'] = (!empty($_POST['updated_by']) ? $_POST['updated_by'] : 0);
		$result = $this->room->update_delete_room($data);
		
		echo json_encode($result, true);
	}

	public function room_delete(){
		$id = $_POST['id'];
		$result = $this->room->delete_room($id);
		
		echo json_encode($result, true);
	}

	// settings->data->facilities

	public function facilities(){
		$q = $this->facility->get_facilities();
		$d['fa'] = $q;
		$data['t'] = $this->load->view('pages/settings/data/facilities', $d);
		return $data;
	}

	public function fetchFacilityById(){
		$id = $_POST['id'];
		$data = $this->facility->get_facility_by_id($id);
		echo json_encode($data, true);
	}

	public function fetchFacilities(){
		$data = $this->facility->get_facilities_id_name();
		echo json_encode($data, true);
	}

	/**
	 *  request component 
	 */

	public function component_table(){
		$data['c'] = $this->load->view('components/table/table_hover');
		return $data;
	}

}
