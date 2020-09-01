<?php 

class User {

    // static user, for development only
	public $name = 'iswanto';
	public $id = '201137';
    public $department = 'IT';
    public $position = 'IT Staff';
    public $head = 'IT Manager';
    public $head_indirect = 'President Director';

    protected $CI;
    public $USER;

    public function __construct(){
        $this->CI =& get_instance();
    }


    public function setUser($user = null){
        $this->name = (!empty($user['name']) ? $this->name = $user['name'] : $this->name);
        $this->id = (!empty($user['id']) ? $this->id = $user['id'] : $this->id);
        $this->department = (!empty($user['department']) ? $this->department = $user['department'] : $this->department);
        $this->position = (!empty($user['position']) ? $this->position = $user['position'] : $this->position);
        $this->head = (!empty($user['head']) ? $this->head = $user['head'] : $this->head);
        $this->head_indirect = (!empty($user['head_indirect']) ? $this->head_indirect = $user['head_indirect'] : $this->head_indirect);
    }

    public function getUser(){
        $user['name'] = $this->name;
        $user['id'] = $this->id;
        $user['department'] = $this->department;
        $user['position'] = $this->position;
        $user['head'] = $this->head;
        $user['head_indirect'] = $this->head_indirect;
        return $user;
    }

}

?>
