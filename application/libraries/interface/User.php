<?php 

class User {

    public $id;
    public $name;
    public $department;
    public $position;
    public $branch;
    public $privilege;

    public function __construct($user=null){
        $this->setUser($user);
    }

    public function setUser($user){
        $this->id           = $user['id'];
        $this->name         = $user['name'];
        $this->department   = $user['department'];
        $this->position     = $user['position'];
        $this->branch       = $user['branch'];
        $this->privilege    = $user['privilege'];
    }

    public function getUser(){
        $user['id']         = $this->id;
        $user['name']       = $this->name;
        $user['department'] = $this->department;
        $user['position']   = $this->position;
        $user['branch']     = $this->branch;
        $user['privilege']  = $this->privilege;
        return $user;
    }

}

?>
