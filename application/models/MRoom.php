<?php

require_once(APPPATH."models/MSql.php");

Class MRoom extends MSql {

  public function __construct(){
      parent::__construct("room");
  }

}
?>
