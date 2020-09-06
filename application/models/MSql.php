<?php

Class MSql extends CI_Model {

  private $table;
  private $select;
  private $where;
  private $order;
  private $group;

  public function __construct($table_name){
      parent::__construct();
      $this->table = ' FROM ' . $table_name;
      $this->select = 'SELECT ';
      $this->where = ' WHERE ';
      $this->order = ' ORDER BY ';
      $this->group = ' GROUP BY ';
  }

  public function get($column='', $where='', $group='', $order=''){
    $select = ($column !== null ? $column : ' * ');
    $sql = $this->select . $select . $this->table;
    if($where != ''){
        $sql .= $this->where . $where . ' AND is_deleted=0 ';
    }else{
        $sql .= $this->where . $where . ' is_deleted=0';
    }
    if($group != ''){
        $sql .= $this->group . $group;
    }
    if($order != ''){
        $sql .= $this->order . $order;
    }
    return $this->db->query($sql)->result_array(); 
  }

  public function get_join($select='', $where='', $group='', $order=''){
    $select = ($select !== null ? $select : ' * ');
    $sql = $this->select . $select;
    if($where != ''){
      $sql .= $this->where . $where ;
    }
    if($group != ''){
        $sql .= $this->group . $group;
    }
    if($order != ''){
        $sql .= $this->order . $order;
    }
    return $this->db->query($sql)->result_array(); 
  }

  public function insert(){

  }

  public function update(){
  }

  public function delete($id){
    $delete = "DELETE " . $this->table . " WHERE id=" . $id . "";
    $query = $this->db->query($delete);
    return $this->success_query();
  }

  public function success_query(){
    return ($this->db->affected_rows() >= 1 ? true : false);
  }

}
?>
