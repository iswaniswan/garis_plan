<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH.'controllers/Home.php');

class Activity extends Home {

	public function __construct(){
		parent::__construct();
	}
	

	// room reservation

	public function room_reservation_summary(){
		$data['room'] = $this->room->get_room_summary();
		return $this->load->view('pages/activity/room_reservation/summary', $data);
	}

	public function room_reservation_order(){
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
		$data['t'] = $this->load->view('pages/activity/room_reservation/order', $d);
		return $data;
	}

	public function room_reservation_table_get(){
		$id = (empty($_POST['id']) || $_POST['id'] == null ? $valid = false : $_POST['id'] );
		if($id){
			$data = $this->room->activity_room_by_id($id);
			echo json_encode($data, true);
		}
	}

	public function room_reservation_table(){
		$data['room'] = $this->room->activity_room();
		$data['t'] = $this->load->view('pages/activity/room_reservation/table', $data);
		return $data;
	}

	public function room_reservation_order_submit(){		
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

	// event 
	public function event_summary(){
		$data['event'] = $this->calendar->event_summary();
		return $this->load->view('pages/activity/event/summary', $data);
	}

	public function event_order(){
		$data['t'] = $this->load->view('pages/activity/event/order');
		return $data;
	}

	public function event_table(){
		$data['event'] = $this->calendar->event_table();
		return $this->load->view('pages/activity/event/table', $data);
	}

	// notification

	public function notification(){		
		$data['notification'] = $this->notification->get_all_notification_by_user();
		$this->load->view('pages/activity/notification', $data);
	}

	public function notification_get_user_alert(){
		$notification = $this->notification->get_user_notification_alert();
		echo json_encode($notification, true);
	}

	public function notification_get_by_id(){
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$notification = $this->notification->get_detail_notification($id);
			echo json_encode($notification, true);
		}
	}

	public function notification_set_has_read(){
		if(isset($_POST['id'])){
			$notification = $this->notification->update_notification_by_id($_POST['id']);
		}
	}

	public function notification_insert_update_event_passive(){
		$event['event_id'] = $_POST['event_id'];
		$event['is_join'] = ( empty($_POST['is_join']) || $_POST['is_join'] == null ? 0 : $_POST['is_join'] );
		$event['is_cancel'] = ( empty($_POST['is_cancel']) || $_POST['is_cancel'] == null ? 0 : $_POST['is_cancel'] );
		$event['user_id'] = $this->user->id;

		$this->eventP->setEvent($event);
		$response['data'] = $this->calendar->eventPassive_insert_update($this->eventP->getEvent());

		echo json_encode($response, true);
		
	}

}
