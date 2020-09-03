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

}

?>
