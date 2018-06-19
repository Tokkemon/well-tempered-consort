<?php
	/*
	 * Model for the WTC database. Doesn't have that much in there...
	 */
	class WTC_Model extends CI_Model {
		var $config;
		var $instruments;
		var $ensembles;

		public function __construct() {
			$this->process_config();
			$this->process_instruments_config();
			$this->process_ensembles_config();
		}
		function process_config() {
			$this->config = json_decode(file_get_contents(dirname(__FILE__) . '/wtc_model.json'), true);
		}
		function process_instruments_config() {
			$this->instruments = json_decode(file_get_contents(dirname(__FILE__) . '/instruments.json'), true);
		}
		function process_ensembles_config() {
			$this->ensembles = json_decode(file_get_contents(dirname(__FILE__) . '/ensembles.json'), true);
		}

		function get_config() {
			return $this->config;
		}
		function get_instruments() {
			return $this->instruments;
		}
		function get_instrument_by_id($id) {
			$filtered = array_filter($this->get_instruments(), function($value) use ($id) {
				return ($value['id'] == $id);
			});
			$filtered = array_values($filtered);
			return (isset($filtered[0]) ? $filtered[0] : false);
		}
		function get_ensembles() {
			return $this->ensembles;
		}

		function get_pieces($book = null) {
			$config = $this->config;
			if($book == 1) {
				return $config['pieces']['Book I'];
			}
			else if($book == 2) {
				return $config['pieces']['Book II'];
			}
			return $config['pieces'];
		}

		function get_piece($book, $piece_index) {
			$book = $this->get_pieces($book);
			return $book[$piece_index];
		}
		function get_piece_title($piece) {
			return ucfirst($piece['kind']) . ' in ' . $piece['key'] . ' (BWV' . $piece['bwv'] . ')';
		}

		function get_instrument_matrix($ensemble = null) {
			$config = $this->config;
			if(is_numeric($ensemble) && (2 <= $ensemble && $ensemble <= 5)) {
				return $config['instrumentMatrix'][$ensemble];
			}
			return $config['instrumentMatrix'];
		}
	}