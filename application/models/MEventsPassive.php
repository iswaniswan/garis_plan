<?php

require_once(APPPATH."models/MSql.php");

Class MEventsPassive extends MSql {

  public function __construct(){
      parent::__construct($this->table);
  }

  private $table = 'events_passive';
  private $id = 'id';
  private $user_id = 'user_id';
  private $event_id = 'event_id';
  private $is_join = 'is_join';
  private $is_cancel = 'is_cancel';
  private $updated_date = 'updated_date';

  public function insert_event_passive($event){
    $insert = "INSERT INTO " . $this->table . " (" . $this->user_id . ", " . $this->event_id . 
        ", " . $this->is_join . ") ";

      $insert .= "VALUES ('" . $event['user_id'] . "', " . $event['event_id'] . ", " . $event['is_join'] . ") ";

      $query = $this->db->query($insert);
      return parent::success_query();
  }

  public function update_events_passive($event){
    $update = "UPDATE " . $this->table . " SET " . 
      $this->user_id . "='" . $event['user_id'] . "', " .
      $this->event_id . "=" . $event['event_id'] . ", " .
      $this->is_cancel . "=" . $event['is_cancel'] . ", " .
      " WHERE id='" . $id . "'";

    $query = $this->db->query($update);
    return parent::success_query();
  }

}
?>
