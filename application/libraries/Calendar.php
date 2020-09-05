<?php 

require_once(APPPATH."libraries/interface/Event.php");
require_once(APPPATH."libraries/interface/EventPassive.php");
require_once(APPPATH."libraries/interface/User.php");
require_once (APPPATH.'libraries/Utils.php');

class Calendar {

    protected $CI;
    private $event;
    private $eventP;
    private $utils;
    private $user;

    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->Model('MEvents');
        $this->CI->load->Model('MEventsPassive');
        $this->CI->load->Model('MNotification');

        // $this->event = new Event();
        $this->utils = new Utils();
        $this->user = new User();

        // $this->eventP = new EventPassive();
    }
	
	public function get_all_data(){
		return $this->CI->MEvents->get(null, null, null, null);
    }

    public function get_user_event(){
        $user = $this->user->id;
        $where = '(type="global" or updated_by=' . $user . ') ';
        return $this->CI->MEvents->get(null, $where, null, null);
    }
    
    public function event_add($event){
        // if query success will returning last inserted id
        $query = $this->CI->MEvents->insert_new_events($event);
        
        if($query >= 1){
            if(strLen($event['participant']) > 3){
                // create notification for each participants
                $event_id = $query;
                $participants = explode(",", $this->utils->extract_square_bracket($event['participant']));
                foreach($participants as $p){
                    try{
                        $query = $this->CI->MNotification->insert_notification($event_id, 0, $p, $event['title'], null);
                    }catch(\Exception $e){
                        return $e;
                    }
                }
            }
            return true;
        }
    }

    public function eventPassive_add($event){
        return $this->CI->MEventsPassive->insert_event_passive($event);
    }

    public function eventPassive_update($event){
        return $this->CI->MEventsPassive->update_event_passive($event);
    }

}

?>
