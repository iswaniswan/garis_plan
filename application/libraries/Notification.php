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

        $this->event    = new Event();
        $this->utils    = new Utils();
        $this->user     = $_SESSION['logged_in']['user'];
    }
	
	public function get_user_notification_alert(){
        $where = '( user_id=' . $this->user->id . ' AND is_read=0 ) ';
		return $this->CI->MNotification->get(null, $where, null, null);
    }

    public function get_all_notification_by_user(){
        $where = '( user_id=' . $this->user->id . ') AND updated_date >= NOW()';
        $order = ' updated_date DESC ';
        $query = $this->CI->MNotification->get(null, $where, null, $order);

        $notif = null;
        $i=0;
		foreach($query as $q){        
			foreach($q as $key=>$val){
				$key == 'id' ? $notif[$i]['id'] = $val : '';
				$key == 'event_id' ? $notif[$i]['event_id'] = $val : '';
				$key == 'is_read' ? $notif[$i]['is_read'] = $val : '';
				$key == 'updated_date' ? $notif[$i]['updated_date'] = $val : '';
				$key == 'title' ? $notif[$i]['title'] = $val : '';
				$key == 'message' ? $notif[$i]['message'] = $val : '';
                // unfinished, sebaiknya paka nama bukan user id
                // if($key == 'user_id'){
				// 	$notif[$i]['sender'] = 
                // }
                $key == 'user_id' ? $notif[$i]['user_id'] = $val : '';
            }
            $i++;
        }
        // echo json_encode($notif);
        $result = ($notif != null ? $notif : null);
        return $result;
    }

    public function get_all_past_notification_by_user(){
        $where = '( user_id=' . $this->user->id . ') AND updated_date < NOW() ';
        $order = ' updated_date DESC ';
        $query = $this->CI->MNotification->get(null, $where, null, $order);

        $notif = null;
        $i=0;
		foreach($query as $q){        
			foreach($q as $key=>$val){
				$key == 'id' ? $notif[$i]['id'] = $val : '';
				$key == 'event_id' ? $notif[$i]['event_id'] = $val : '';
				$key == 'is_read' ? $notif[$i]['is_read'] = $val : '';
				$key == 'updated_date' ? $notif[$i]['updated_date'] = $val : '';
				$key == 'title' ? $notif[$i]['title'] = $val : '';
				$key == 'message' ? $notif[$i]['message'] = $val : '';
                // unfinished, sebaiknya paka nama bukan user id
                // if($key == 'user_id'){
				// 	$notif[$i]['sender'] = 
                // }
                $key == 'user_id' ? $notif[$i]['user_id'] = $val : '';
            }
            $i++;
        }
        // echo json_encode($notif);
        $result = ($notif != null ? $notif : null);
        return $result;
    }

    public function get_detail_notification($id){
        $query = $this->CI->MNotification->get_detail_notification_by_id($id);
        foreach($query as $q){
            foreach($q as $key=>$val){
                $detail[$key] = $val;
                if($key == 'participant'){
                    $detail[$key] = explode(',',$this->utils->extract_square_bracket($val));
                }
            }
        };
        return $detail;
    }

    public function update_notification_by_id($id){
        return $query = $this->CI->MNotification->update_notification_has_read($id);
    }

}

?>
