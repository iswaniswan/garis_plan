<?php 

class Utils {

    function left($str, $length) {
        return substr($str, 0, $length);
    }

    function right($str, $length) {
        return substr($str, -$length);
    }

    function extract_square_bracket($str){
        $newStr = str_replace('[', '', $str);
        $data = str_replace(']', '', $newStr);
        return $data;
    }

    function random_color(){  
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    function dateTimeNow(){
        $tz = 'Asia/Jakarta';
		$timestamp = time();
		$dt = new DateTime("now", new DateTimeZone($tz)); 
		$dt->setTimestamp($timestamp); 
		return $dt->format('Y-m-d H:i:s');
    }

    function getUserIPAddress(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}

?>
