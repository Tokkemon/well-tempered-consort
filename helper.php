<?php
//The main helper file to put useful functions



function debug_print($str, $line = 1, $dump = 0, $third = 0, $fourth = 0) {
	$final_str = "<pre>";
	ob_start();
	if($dump == true) {
		var_dump($str, false);
	}
	else {
		print_r($str);
	}
	$final_str .= ob_get_contents();
	ob_end_clean();
	if($line == true) {
		$final_str .= "<br>==========================<br>";
	}
	$final_str .= "</pre>";
	echo $final_str;
}