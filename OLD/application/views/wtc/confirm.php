<?php
	/**
	 * The confirmation page where the choices forms submit to.
	 */
	$str = '<h1>' . $title . '</h1>';
	//$str .= '<pre>' . print_r($choices,1) . '</pre>';

	$str .= '<dl>';
	$str .= '<dt>Piece: </dt>';
	$str .= '<dd><a href="' . $piece_link . '" title="' . $piece_title . '">' . $piece_title . '</a></dd>';
	$str .= '<dt>Format: </dt>';
	$str .= '<dd>' . ucfirst($format) . '</dd>';
	foreach($choices as $part_index => $part) {
		$str .= '<dt>Part ' . convert_number_to_roman($part_index) . ': </dt>';
		$str .= '<dd>' . implode(', ', array_column($part, 'name')) . '</dd>';
	}


	$str .= '</dl>';
	echo $str;