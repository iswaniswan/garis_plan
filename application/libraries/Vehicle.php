<?php 

class Vehicle {

    protected $CI;

    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->Model('MRoom');
    }
	
	public function get_all_data(){
		return $this->CI->MRoom->get();
	}

}

?>
