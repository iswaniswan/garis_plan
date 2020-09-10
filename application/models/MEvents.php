<?php

require_once(APPPATH."models/MSql.php");

Class MEvents extends MSql {

  public function __construct(){
      parent::__construct($this->table);
  }

  private $table = 'events';

  private $id = 'id';
  private $date_start = 'date_start';
  private $date_end = 'date_end';
  private $title = 'title';
  private $type = 'type';
  private $note = 'note';
  private $participant = 'participant';
  private $room_id = 'room_id';
  private $branch = 'branch';
  private $updated_date = 'updated_date';
  private $updated_by = 'updated_by';
  private $is_deleted = 'is_deleted';

  public function insert_new_events($event){

    $insert = "INSERT INTO " . $this->table . " (" . $this->date_start . ", " . $this->date_end . 
      ", " . $this->title . ", " . $this->type . ", " . $this->note . 
      ", " . $this->participant . ", " . $this->room_id . ", " . $this->branch . ", " . $this->updated_by . ", " . $this->is_deleted . ") ";

    $insert .= "VALUES ('" . $event['date_start'] . "', '" . $event['date_end'] . "', '" . 
      $event['title'] . "', '" . $event['type'] . "', '" . $event['note'] . "', '" . 
      $event['participant'] . "', '" . $event['room_id'] . "', '" . $event['branch'] . "', '" . $event['updated_by'] . "', " . $event['is_deleted'] . ") ";

    $query = $this->db->query($insert);
    return (parent::success_query() ? $this->db->insert_id() : false);
    
  }

  public function update_event($event){
    $update = "UPDATE " . $this->table . " SET " . $this->date_start . "='" . $event['date_start'] . "', " .
      $this->date_end . "='" . $event['date_end'] . "', " .
      $this->title . "='" . $event['title'] . "', " .
      $this->type . "='" . $event['type'] . "', " .
      $this->note . "='" . $event['note'] . "', " .
      $this->participant . "='" . $event['participant'] . "', " .
      $this->room_id . "=" . $event['room_id'] . ", " .
      $this->branch . "='" . $event['branch'] . "', " .
      $this->updated_by . "=" .$event['updated_by'] .
      " WHERE id=" . $event['id'];

    $query = $this->db->query($update);
    return (parent::success_query() ? true : false);

  }

  public function delete_event($event){
    $update = "UPDATE " . $this->table . " SET " . $this->is_deleted . "=1, " . $this->updated_by . "=" . $event['updated_by'] .
      " WHERE id=" . $event['id'];

    $query = $this->db->query($update);
    return (parent::success_query() ? true : false);
  }

}
?>
