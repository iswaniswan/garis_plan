<?php

require_once(APPPATH."models/MSql.php");

Class MRoom extends MSql {

  private $table = 'room';

  public function __construct(){
      parent::__construct($this->table);
  }

  private $id = 'id';
  private $name = 'name';
  private $capacity = 'capacity';
  private $facilities = 'facilities';
  private $floor = 'floor';
  private $location = 'location';
  private $is_available = 'is_available';
  private $is_deleted = 'is_deleted';
  private $updated_date = 'updated_date';
  private $updated_by = 'updated_by';

  public function insert_room($id = '', $name = '', $capacity = '', $facilities = [], 
    $floor = '', $location, $is_available = 1, $is_deleted = 0, $updated_date = null, $updated_by = 0){

      $insert = "INSERT INTO " . $this->table . " (" . $this->name . ", " . $this->capacity . 
        ", " . $this->facilities . ", " . $this->floor . ", " . $this->location . 
        ", " . $this->is_available . ", " . $this->is_deleted . ", " . $this->updated_by . ") ";

      $insert .= "VALUES ('" . $name . "', " . $capacity . ", '" . $facilities . "', " . $floor .
        ", '" . $location . "', " . $is_available . ", " . $is_deleted . ", " . $updated_by . ") ";

      $query = $this->db->query($insert);
      return parent::success_query();
  }

  public function update_room($id, $name, $capacity, $facilities, $floor, $location, $is_available, $updated_by){
    $update = "UPDATE " . $this->table . " SET " . 
      $this->name . "='" . $name . "', " .
      $this->capacity . "=" . $capacity . ", " .
      $this->facilities . "='" . $facilities . "', " .
      $this->floor . "= " . $floor . ", " .
      $this->location . "= '" . $location . "', " .
      $this->is_available . "= " . $is_available . ", " .
      $this->updated_by . "= " . $updated_by .
      " WHERE id='" . $id . "'";

    $query = $this->db->query($update);
    return parent::success_query();
  }

  public function update_delete_room($id, $updated_by = 0){
    $update = "UPDATE " . $this->table . " SET " . 
      $this->is_deleted . "=1" . ", " .
      $this->updated_by . "= " . $updated_by .
      " WHERE id='" . $id . "'";

    $query = $this->db->query($update);
    return parent::success_query();
  }

}
?>
