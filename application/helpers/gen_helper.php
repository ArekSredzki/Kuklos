<?php  if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');

function _keyword($length = 6, $chars = 'abcdefghijklmnopqrstuvwxyz1234567890'){
    $chars_length = (strlen($chars) - 1);

    $string = $chars{rand(0, $chars_length)};

    for ($i = 1; $i < $length; $i = strlen($string)) {
        $r = $chars{rand(0, $chars_length)};
        if ($r != $string{$i - 1}) $string .=  $r;
    }
    
    return $string;
}