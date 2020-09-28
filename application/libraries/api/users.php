<?php 

require_once(APPPATH."libraries/interface/Event.php");
require_once(APPPATH."libraries/interface/EventPassive.php");
require_once(APPPATH."libraries/interface/User.php");
require_once (APPPATH.'libraries/Utils.php');

class users {

    protected $CI;
    private $event;
    private $eventP;
    private $utils;
    private $user;

    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->Model('MUsers');
    }

    public function __users(){
        $sql = ' 
            u.id as id,
            u.name as name,
            d.name as department,
            p.name as position,
            b.name as branch,
            u.role as privilege
        FROM employee as e
        inner join users as u on u.id = e.nik
        inner join dept as d on e.dept_id = d.id
        inner join branch as b on e.id_cab = b.id
        inner join sub_div as sb on e.sub_div_id = sb.id
        inner join position as p on e.position_id = p.id
        ';
        $where = ' u.is_deleted = 0 ';
        return $this->CI->MUsers->get_join($sql, $where, null, null);
    }

    public function __user($id){
        $sql = '
            u.id as id,
            u.name as name,
            d.name as department,
            p.name as position,
            b.name as branch,
            u.role as privilege
        FROM acis.employee as e
        inner join users as u on u.id = e.nik
        inner join dept as d on e.dept_id = d.id
        inner join branch as b on e.id_cab = b.id
        inner join sub_div as sb on e.sub_div_id = sb.id
        inner join position as p on e.position_id = p.id
        ';
        $where = ' u.is_deleted = 0 AND u.id = ' . $id;
        return $this->CI->MUsers->get_join($sql, $where, null, null);
    }


}

?>
