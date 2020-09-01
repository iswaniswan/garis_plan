<?php 

// require_once(APPPATH."libraries/interface/Event.php");

class Calendar {

    protected $CI;
    private $event;

    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->Model('MCalendar');
        // $this->event = new Event();
    }
	
	public function get_all_data(){
		return $this->CI->MCalendar->get(null, null, null, null);
    }
    
    public function event_add($meeting){
        return $this->CI->MCalendar->insert_new_events($meeting);
    }

}

?>
