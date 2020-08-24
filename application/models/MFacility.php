<?php

require_once(APPPATH."models/MSql.php");

Class MFacility extends MSql {

  public function __construct(){
      parent::__construct("facility");
  }

}
?>
