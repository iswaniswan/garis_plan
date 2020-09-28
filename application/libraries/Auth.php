<?php 

require_once (APPPATH.'libraries/Utils.php');
require_once (APPPATH.'libraries/interface/User.php');

class Auth {

    protected $CI;
    private $utils;

    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->Model('MFacility');
        $this->CI->load->Model('MUsers');
        $this->utils    = new Utils();
    }
    
    public function login($data){
        $nik = $data['nik'];
        $password = $data['password'];

        $login = false;
        if( (isset($nik) && isset($password)) && (!empty($nik) && !empty($password))){
            $data = array('id'=>$nik, 'password'=>$password);
            $sql = "SELECT password FROM users WHERE id='" . $nik . "';";
            $hashed = $this->CI->db->query($sql)->row();
            
            if(!empty($hashed)){
                $hashed = $hashed->password;
                if(password_verify($data['password'], $hashed)){
                    $login = true;
                }
            }
        }
        return $login;  
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('');
    }
	
}

?>
