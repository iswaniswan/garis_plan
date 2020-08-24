<?php

require_once(APPPATH."models/MSql.php");

Class MCalendar extends MSql {

  public function __construct(){
      parent::__construct("holiday");
  }

}
?>
