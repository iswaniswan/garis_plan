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
  private $updated_date = 'updated_date';
  private $is_join = 'is_join';

  public function insert_events_passive($user_id, $event_id, $is_join=0){
    $insert = "INSERT INTO " . $this->table . " (" . $this->user_id . ", " . $this->event_id . 
        ", " . $this->is_join . ") ";

      $insert .= "VALUES ('" . $user_id . "', " . $event_id . ", '" . $is_join . ") ";

      $query = $this->db->query($insert);
      return parent::success_query();
  }

  public function update_events_passive($id, $user_id, $event_id, $is_join){
    $update = "UPDATE " . $this->table . " SET " . 
      $this->user_id . "='" . $user_id . "', " .
      $this->event_id . "=" . $event_id . ", " .
      $this->is_join . "=" . $is_join . ", " .
      " WHERE id='" . $id . "'";

    $query = $this->db->query($update);
    return parent::success_query();
  }

}
?>
