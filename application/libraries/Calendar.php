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

        $this->utils = new Utils();
        $this->user = new User();
    }
	
	// public function get_all_data(){
	// 	return $this->CI->MEvents->get(null, null, null, null);
    // }

    // public function get_user_event(){
    //     $user = $this->user->id;
    //     $where = '(type="global" or updated_by=' . $user . ') ';
    //     return $this->CI->MEvents->get(null, $where, null, null);
    // }

    public function get_user_event(){
        $user = $this->user->id;
        $select_join = " * FROM events as e left join events_passive as ep on e.id = ep.event_id ";
        $where = " (e.type='global' or e.updated_by=" . $user . " or ep.is_join=1) AND is_deleted=0 ";
        return $this->CI->MEvents->get_join($select_join, $where, null, null);
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

    public function event_update($event){
        return $this->CI->MEvents->update_event($event);
    }

    public function event_update_delete($id){
        return $this->CI->MEvents->delete_event($id);
    }

    public function eventPassive_insert_update($event){
        return $this->CI->MEventsPassive->insert_update_event_passive($event);
    }

    public function event_summary(){
        $user = $this->user->id;
        $select_join = " count(e.id) as event_count, e.type, e.updated_by,
        ep.id as event_passive_id, ep.is_join, ep.is_cancel
        FROM events as e left join events_passive as ep on e.id = ep.event_id ";
        $where = " (e.type='group' or e.type='global' or e.updated_by=" . $user ." or ep.is_join=1) AND is_deleted=0 ";
        $group = " e.type ";
        $order = " e.updated_date desc ";
        return $this->CI->MEvents->get_join($select_join, $where, $group, $order);
    }

    public function events_holiday(){
        $where = " type='global' and is_deleted=0 ";
        $order = " date_start ASC ";
        return $this->CI->MEvents->get(null, $where, null, $order);
    }

    public function event_table(){
        $user = $this->user->id;
        $select_join = " e.id, e.date_start, e.date_end, e.title, e.type, e.note, e.participant, e.room_id, e.branch, e.updated_by,
        ep.id as event_passive_id, ep.is_join, ep.is_cancel
        FROM events as e left join events_passive as ep on e.id = ep.event_id ";
        $where = " (e.type='group' or e.updated_by=" . $user ." or ep.is_join=1) AND is_deleted=0 AND (e.date_end >= NOW()) ";
        $order = " e.updated_date desc ";
        return $this->CI->MEvents->get_join($select_join, $where, null, $order);
    }

    public function event_table_past(){
        $user = $this->user->id;
        $select_join = " e.id, e.date_start, e.date_end, e.title, e.type, e.note, e.participant, e.room_id, e.branch, e.updated_by,
        ep.id as event_passive_id, ep.is_join, ep.is_cancel
        FROM events as e left join events_passive as ep on e.id = ep.event_id ";
        $where = " (e.type='group' or e.updated_by=" . $user ." or ep.is_join=1) AND is_deleted=0 AND (e.date_end < NOW())";
        $order = " e.updated_date desc ";
        return $this->CI->MEvents->get_join($select_join, $where, null, $order);
    }

    public function event_table_with_global(){
        $user = $this->user->id;
        $select_join = " e.id, e.date_start, e.date_end, e.title, e.type, e.note, e.participant, e.room_id, e.branch, e.updated_by,
        ep.id as event_passive_id, ep.is_join, ep.is_cancel
        FROM events as e left join events_passive as ep on e.id = ep.event_id ";
        $where = " ((e.type='group' AND ep.is_join=1) or e.updated_by=" . $user . " or e.type='global' or e.type='branch') AND is_deleted=0 ";
        $order = " e.updated_date desc ";
        return $this->CI->MEvents->get_join($select_join, $where, null, $order);
    }

    public function event_table_get_by_id($id){
        $select_join = " r.id as id, r.name, r.location, e.id as event_id, e.date_start, e.date_end, e.title, e.type, e.note, e.participant, e.updated_date, e.updated_by FROM room as r 
        right join events as e on e.room_id=r.id ";
        $where = " e.id=" . $id ." ";
        return $this->CI->MEvents->get_join($select_join, $where, null, null)[0];
    }

    public function settings_holiday(){
        $where = " type='global' ";
        return $this->CI->MEvents->get(null, $where, null, null);
    }

}

?>
