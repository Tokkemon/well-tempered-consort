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

//TODO: All of these should save the json once as globals.
function get_pieces_data($bwv_number = null) {
	global $site_path;
	$json_file = $site_path . 'data/pieces.json';
	$json = file_get_contents($json_file);
	$pieces = json_decode($json, true);
	//If a bwv number is provided, use that to filter out the single piece.
	if($bwv_number !== null) {
		foreach($pieces as $book_num => $book_data) {
			$piece_data = array_values(array_filter($book_data, function($value) use ($bwv_number) {
				return ($value['bwv'] == $bwv_number);
			}));
			$piece_data = (isset($piece_data[0]) ? $piece_data[0] : $piece_data);
			if(!empty($piece_data)) {
				$book = $book_num;
				break;
			}
		}
		$piece_data['book'] = $book_num;
		return $piece_data;
	}
	return $pieces;
}


function get_parts_data($type = null) {
	global $site_path;
	$json_file = $site_path . 'data/parts.json';
	$json = file_get_contents($json_file);
	$parts_data = json_decode($json, true);
	//If a specific type is requested, filter down the final results;
	if($type !== null) {
		$part = array_values(array_filter($parts_data, function($value) use ($type) {
			return ($value['label'] == strtolower($type));
		}))[0]['parts'];
		return $part;
	}
	return $parts_data;
}

function get_instruments($id = null) {
	global $site_path;
	$json_file = $site_path . 'data/instruments.json';
	$json = file_get_contents($json_file);
	$instrument_data = json_decode($json, true);
	if($id !== null) {
		$instrument = array_values(array_filter($instrument_data, function($value) use ($id) {
			return ($value['id'] == strtolower($id));
		}))[0];
		return $instrument;
	}
	return $instrument_data;
}
