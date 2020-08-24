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
	
	public function get_all_data(){
		return $this->CI->MFacility->get();
    }
    
    public function get_filter_data($filter_id){
        $ids = $this->utils->extract_square_bracket($filter_id);
        $where = " id IN (" . $ids . ")";
        return $this->CI->MFacility->get("", $where, "", "");        
    }

    public function get_facility_name_by_id($id){
        $ids = $this->utils->extract_square_bracket($id);
        $where = " id IN (" . $ids . ")";
        $query = $this->CI->MFacility->get("", $where, "", "");   
        $facilities = []; 
        foreach($query as $r){
            foreach($r as $key=>$val){
                if($key == 'name'){
                    array_push($facilities, $val);
                }
            }
        }
        return $facilities;
    }

}

?>
