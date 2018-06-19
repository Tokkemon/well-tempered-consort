<?php
	/**
	 * Any standalone helper functions should go here.
	 */
	//Prints out a result for debugging purposes
	function debug_print($var, $line = true, $dump = false, $pre = true, $no_style = true) {
		if($no_style === false) {
			echo '<div class="debug"><h1>Debugging</h1>';
		}
		if($pre){
			echo '<pre>';
		}
		if($dump){
			var_dump($var);
		}
		else{
			print_r($var);
		}
		if($pre){
			echo "</pre>";
		}
		if($line){
			echo "<br />===========================<br />";
		}
		else{
			echo "<br />";
		}
		if($no_style === false) {
			echo '</div>';
		}
	}

	function convertIntToEnsemble($int) {
		switch($int) {
			case 1:
				return 'solo';
				break;
			case 2:
				return 'duet';
				break;
			case 3:
				return 'trio';
				break;
			case 4:
				return 'quartet';
				break;
			case 5:
				return 'quintet';
				break;
			case 6:
				return 'sextet';
				break;
			case 7:
				return 'septet';
				break;
			case 8:
				return 'octet';
				break;
			case 9:
				return 'nonet';
				break;
			case 10:
				return 'dectet';
				break;
			default:
				return 'ensemble';
		}
	}

	/*
	 * Number Conversion Functions
	 */
	function convert_number($number, $output_format, $locale = 'en_US') {
		//If roman, short-circuit NumberFormatter stuff and go directly to the Roman function.
		if($output_format == "roman") {
			return convert_number_to_roman($number);
		}

		if(!class_exists('NumberFormatter')) {
			//TODO: Graceful die?
			debug_print('The "NumberFormatter" class, part of the php_intl.dll must be present! Please adjust your PHP settings.');
			return false;
		}

		switch($output_format) {
			case 'words-decimal':
				$style = NumberFormatter::SPELLOUT;
				$output_format = '%spellout-decimal';
				break;
			case 'words-ordinal':
				//Short circuit if the number is zero. This avoids "Zeroth" nonsense.
				if($number == 0) {
					return '';
				}
				$style = NumberFormatter::SPELLOUT;
				$output_format = '%spellout-ordinal';
				break;
			default:
				return $number;
		}

		$formatter = new NumberFormatter($locale,$style);
		$formatter->setTextAttribute(NumberFormatter::DEFAULT_RULESET, $output_format);
		return($formatter->format($number));
	}

	function convert_number_to_roman($number) {
		// Convert the integer into an integer (just to make sure)
		$number = intval($number);
		$result = '';

		// Create a lookup array that contains all of the Roman numerals.
		$lookup = ['M' => 1000,
			'CM' => 900,
			'D' => 500,
			'CD' => 400,
			'C' => 100,
			'XC' => 90,
			'L' => 50,
			'XL' => 40,
			'X' => 10,
			'IX' => 9,
			'V' => 5,
			'IV' => 4,
			'I' => 1];

		foreach($lookup as $roman => $value){
			// Determine the number of matches
			$matches = intval($number/$value);

			// Add the same number of characters to the string
			$result .= str_repeat($roman,$matches);

			// Set the integer to be the remainder of the integer and the value
			$number = $number % $value;
		}

		// The Roman numeral should be built, return it
		return $result;
	}

	function convert_number_to_words($number) {
		return convert_number($number, 'words-decimal');
	}

	function convert_number_to_words_ordinal($number) {
		return convert_number($number, 'words-ordinal');
	}

	/**
	 * Simple function that converts shorthand keys, such as Eb, to their longhand form, such as E-flat.
	 * @param $key
	 */
	function convert_key_to_longhand($key) {
		$key = preg_replace('/b$/', '-flat', $key);
		$key = preg_replace('/#$/', '-sharp', $key);
		return $key;
	}

	function sanitize_instrument($instrument) {
		$instrument = strtolower($instrument);
		$instrument = str_replace(' ', '_', $instrument);
		$instrument = preg_replace('/[\s_]in[\s_](?>bb|Bb|eb|Eb|f|F|B-flat|b-flat|E-flat|e-flat)/', '', $instrument);
		$instrument = str_replace(['t.c.','T.C.','T.c.','t.C.'], 'tc', $instrument);
		return $instrument;
	}