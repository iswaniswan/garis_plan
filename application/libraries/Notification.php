<?php 

require_once(APPPATH."libraries/interface/Event.php");
require_once(APPPATH."libraries/interface/User.php");
require_once (APPPATH.'libraries/Utils.php');

class Notification {

    protected $CI;
    private $event;
    private $utils;
    private $user;

    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->Model('MEvents');
        $this->CI->load->Model('MNotification');

        $this->event = new Event();
        $this->utils = new Utils();
        $this->user = new User();
    }
	
	public function get_simple_notification_by_user(){
        $where = '( user_id=' . $this->user->id . ') ';
		return $this->CI->MNotification->get(null, $where, null, null);
    }

    public function get_all_notification_by_user(){
        $i=0;
        $query = $this->get_simple_notification_by_user();
        
		foreach($query as $q){        
			foreach($q as $key=>$val){
				$notif[$i]['id'] = ($key == 'id' ? $val : '');
				$notif[$i]['event_id'] = ($key == 'event_id' ? $val : '');
				$notif[$i]['is_read'] = ($key == 'is_read' ? $val : '');
				$notif[$i]['updated_date'] = ($key == 'updated_date' ? $val : '');
				$notif[$i]['title'] = ($key == 'title' ? $val : '');
				$notif[$i]['message'] = ($key == 'message' ? $val : '');
                // unfinished, sebaiknya paka nama bukan user id
                // if($key == 'user_id'){
				// 	$notif[$i]['sender'] = 
                // }
                $notif[$i]['user_id'] = ($key == 'user_id' ? $val : '');
            }
            $i++;
        }
        var_dump($notif);
        return $notif;
    }

}

?>
