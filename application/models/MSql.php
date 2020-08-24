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
    $select = ($column !== '' ? $column : ' * ');
    $sql = $this->select . $select . $this->table;
    if($where != ''){
        $sql .= $this->where . $where;
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

  public function delete(){

  }

}
?>
