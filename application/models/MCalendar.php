<?php

require_once(APPPATH."models/MSql.php");

Class MCalendar extends MSql {

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
  private $updated_date = 'updated_date';
  private $updated_by = 'updated_by';
  private $is_deleted = 'is_deleted';

  public function insert_new_events($meeting){

    $insert = "INSERT INTO " . $this->table . " (" . $this->date_start . ", " . $this->date_end . 
      ", " . $this->title . ", " . $this->type . ", " . $this->note . 
      ", " . $this->participant . ", " . $this->updated_by . ", " . $this->is_deleted . ") ";

    $insert .= "VALUES ('" . $meeting['date_start'] . "', '" . $meeting['date_end'] . "', '" . 
      $meeting['title'] . "', '" . $meeting['type'] . "', '" . $meeting['note'] . "', '" . 
      $meeting['participant'] . "', '" . $meeting['updated_by'] . "', " . $meeting['is_deleted'] . ") ";

    $query = $this->db->query($insert);
    return parent::success_query();
  }

}
?>
