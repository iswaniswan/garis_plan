<?php

require_once(APPPATH."models/MSql.php");

Class MNotification extends MSql {

  public function __construct(){
      parent::__construct($this->table);
  }

  private $table = 'notification';
  private $id = 'id';
  private $event_id = 'event_id';
  private $is_read = 'is_read';
  private $updated_date = 'updated_date';
  private $user_id = 'user_id';
  private $title = 'title';
  private $message = 'message';

  public function insert_notification($event_id, $is_read=0, $user_id, $title, $message=''){
    $insert = "INSERT INTO " . $this->table . " (" . $this->event_id . ", " . $this->is_read . 
        ", " . $this->user_id . ", " . $this->title . ", " . $this->message . ") ";

      $insert .= "VALUES (" . $event_id . ", " . $is_read . ", " . $user_id .
      ", '" . $title . "', '" . $message . "') ";

      $query = $this->db->query($insert);
      return parent::success_query();
  }

  public function update_notification($id, $event_id, $is_read, $user_id, $title, $message){
    $update = "UPDATE " . $this->table . " SET " . 
      $this->event_id . "=" . $event_id . ", " .
      $this->is_read . "=" . $is_read . ", " .
      $this->user_id . "=" . $user_id . ", " .
      $this->title . "=" . $title . ", " .
      $this->message . "=" . $message . ", " .
      " WHERE id='" . $id . "'";

    $query = $this->db->query($update);
    return parent::success_query();
  }

  public function get_detail_notification_by_id($id){
    $get = "SELECT n.id, n.event_id, n.is_read, n.updated_date, n.user_id, n.title, n.message, 
      e.date_start, e.date_end, e.type, e.note, e.participant, e.room_id, e.branch, e.updated_by
      FROM " . $this->table . " as n inner join events as e on n.event_id = e.id WHERE n.id=" . $id ;
    
    $query = $this->db->query($get)->result_array();    
    return $query;
  }

  public function update_notification_has_read($id){
    $update = "UPDATE " . $this->table . " SET " . 
      $this->is_read . "=1 WHERE id='" . $id . "'";

    $query = $this->db->query($update);
    return parent::success_query();
  }

}
?>
