<?php 

require_once (APPPATH.'libraries/Utils.php');

class Facility {

    protected $CI;
    private $utils;

    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->Model('MFacility');
        $this->utils = new Utils();
    }
	
	public function get_facilities(){
        $q = $this->CI->MFacility->get(null, null, null, null);
        $i=0;
		foreach($q as $r){
			foreach($r as $key=>$val){
				$fa[$i][$key] = $val;
			}
			$i++;
		}
		return $fa;
    }

    public function get_facilities_id_name(){
        $select = 'id , name';
        $q = $this->CI->MFacility->get($select, null, null, null);
        $i=0;
		foreach($q as $r){
			foreach($r as $key=>$val){
				$fa[$i][$key] = $val;
			}
			$i++;
		}
		return $fa;
    }
    
    public function get_filter_data($filter_id){
        $select = 'id , name';
        $ids = $this->utils->extract_square_bracket($filter_id);
        $where = " id IN (" . $ids . ")";

        return $this->CI->MFacility->get($select, $where, "", "");        
    }

    public function get_facility_name_by_id($id){
        $ids = $this->utils->extract_square_bracket($id);
        $where = " id IN (" . $ids . ")";
        $query = $this->CI->MFacility->get(null, $where, "", "");   
        $facilities = []; 
        foreach($query as $r){
            foreach($r as $key=>$val){
                if($key == 'name' || $key == 'id'){
                    array_push($facilities, $val);
                }
            }
        }
        return $facilities;
    }

}

?>
