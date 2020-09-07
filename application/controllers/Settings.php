<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH.'controllers/Home.php');

class Settings extends Home {

	public function __construct(){
		parent::__construct();
	}

	
	// room

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

	public function facility_get_by_id(){
		$id = $_POST['id'];
		$data = $this->facility->get_facility_by_id($id);
		echo json_encode($data, true);
	}

	public function facilities_id_name(){
		$data = $this->facility->get_facilities_id_name();
		echo json_encode($data, true);
	}

	// vehicle

	public function vehicle(){
		$this->under_construction();
		// return $this->load->view('pages/settings/data/vehicle');
	}

	// user

	public function user(){
		$this->under_construction();
		// return $this->load->view('pages/settings/data/user');
	}

	// settings

	public function holiday(){
		$data['event'] = $this->calendar->settings_holiday();
		return $this->load->view('pages/settings/data/holiday', $data);
	}

	public function holiday_order(){
		return $this->load->view('pages/settings/data/holiday_order');
	}

}
