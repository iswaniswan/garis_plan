<?php

require_once(APPPATH."models/MSql.php");

Class MVehicle extends MSql {

  public function __construct(){
      parent::__construct("vehicle");
  }

}
?>
