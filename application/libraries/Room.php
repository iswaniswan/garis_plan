<?php 

class Room {

    protected $CI;

    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->Model('MRoom');
    }
	
	public function get_room(){
		$q = $this->CI->MRoom->get(null, null, null, null);
		$i=0;
		foreach($q as $r){
			foreach($r as $key=>$val){
				$room[$i][$key] = $val;
			}
			$i++;
		}
		return $room;
    }

    public function get_room_by_id($id){
        $where = "id='" . $id . "'";
        $q = $this->CI->MRoom->get(null, $where, null, null);
        
		$i=0;
		foreach($q as $r){
			foreach($r as $key=>$val){
                $room[$i][$key] = $val;
			}
			$i++;
        }
		return $room;
    }
    
    public function insert_room($data){
        $inserted = $this->CI->MRoom->insert_room($data['id'] = null, $data['name'], $data['capacity'], 
            $data['facilities'], $data['floor'], $data['location']
        );
        return $inserted;
    }

    public function update_room($data){
        $updated = $this->CI->MRoom->update_room($data['id'], $data['name'], $data['capacity'], 
            $data['facilities'], $data['floor'], $data['location'], $data['is_available'], $data['updated_by']
        );
        return $updated;
    }

    public function update_delete_room($data){
        $updated = $this->CI->MRoom->update_delete_room($data['id'], $data['updated_by']);
        return $updated;
    }

    public function delete_room($id){
        $deleted = $this->CI->MRoom->delete($id);
        return $deleted;
    }

}

?>
