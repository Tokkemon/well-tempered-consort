	<?php
//The main helper file to put useful functions

function debug_print($str, $line = 1, $dump = 0, $third = 0, $fourth = 0) {
	$final_str = "<pre>";
	ob_start();
	if($dump == true) {
		var_dump($str);
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

function load_json_data_file($file_name) {
    global $site_path;
    //TODO add the json extension by default???
    $json_file = $site_path . 'data/' . $file_name;
    $json = file_get_contents($json_file);
    $data = json_decode($json, true);
    return $data;
}

//TODO: All of these should save the json once as globals.
function get_pieces_data($bwv_number = null) {
    $pieces = load_json_data_file('pieces.json');
	//If a bwv number is provided, use that to filter out the single piece.
	$book = null;
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
		$piece_data['book'] = $book;
		return $piece_data;
	}
	return $pieces;
}


function get_parts_data($type = null, $instruments = true) {
    $parts_data = load_json_data_file('parts.json');
	//get the instrument data if that's requested
	$instrument_data = get_instruments();
	//Reorganize so the ids are the top level bits.
	$instrument_data = array_combine(array_column($instrument_data, 'id'), $instrument_data);
	//If a specific type is requested, filter down the final results;
	if($type !== null) {
		$part = array_values(array_filter($parts_data, function($value) use ($type) {
			return ($value['label'] == strtolower($type));
		}))[0]['parts'];
		//Add the instruments if required
		if($instruments === true) {
			foreach($part as &$parts) {
				foreach($parts as &$inst) {
					$inst = $instrument_data[$inst]['label'];
				}
			}
		}
		return $part;
	}
	//Add the instruments if required
	if($instruments === true) {
		foreach($parts_data as &$parts_datum) {
			foreach($parts_datum['parts'] as &$parts) {
				foreach($parts as &$inst) {
					$inst = $instrument_data[$inst]['label'];
				}
			}
		}
	}
	return $parts_data;
}

function get_instruments($id = null) {
    $instrument_data = load_json_data_file('instruments.json');
	if($id !== null) {
		$instrument = array_values(array_filter($instrument_data, function($value) use ($id) {
			return ($value['id'] == strtolower($id));
		}))[0];
		return $instrument;
	}
	return $instrument_data;
}

function get_ensembles($raw = false) {
    $ensemble_data = load_json_data_file('ensembles.json');
    return $ensemble_data;
}