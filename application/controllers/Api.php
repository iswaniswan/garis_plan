<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH."libraries/api/users.php");

class Api extends CI_Controller {

    private $users;

    public function __construct(){
        parent::__construct();
        $this->load->library('session');
		$this->load->library('parser');
        $this->load->helper('url');
        $this->load->Model('MUsers');
    }

    private function __data(){
        $data['data'] = [];
        $data['status'] = false;
        $data['message'] = 'Some error occured';
        return $data;
    }

    public function get_users(){
        $data = $this->__data();
        $query = $this->MUsers->__users();
        if($query){
            $data['data'] = $query;
            $data['status'] = true;
            $data['message'] = 'Success';
        }
        echo json_encode($data, true);
    }

    public function get_user_by_id(){
        $data = $this->__data();
        $id = ( isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : false );
        if(!$id){
            $data['message'] = 'id not defined';
            echo json_encode($data, true);
        }else{
            $query = $this->MUsers->__user($id)[0];
            if($query){
                $data['data'] = $query;
                $data['status'] = true;
                $data['message'] = 'Success';
            }
            echo json_encode($data, true);
        }
    }


}

?>