<?php
	class WTC extends CI_Controller {

		public function __construct() {
			parent::__construct();
			$this->load->helper('url_helper');
			$this->load->helper('form');
			$this->load->model('wtc_model');
		}

		public function index() {
			$data['title'] = 'Well-Tempered Consort';

			$this->load->view('templates/header', $data);
			$this->load->view('wtc/home', $data);
			$this->load->view('templates/footer');
		}

		public function pieces() {
			$data['title'] = 'Well-Tempered Consort';
			$data['pieces'][1] = $this->wtc_model->get_pieces(1);
			$data['pieces'][2] = $this->wtc_model->get_pieces(2);
			$data['ensembles'] = $this->wtc_model->get_ensembles();

			$this->load->view('templates/header', $data);
			$this->load->view('wtc/pieces', $data);
			$this->load->view('templates/footer');
		}

		public function view_piece($book, $piece_index) {
			$piece = $this->wtc_model->get_piece($book, $piece_index);
			$matrix = $this->wtc_model->get_instrument_matrix($piece['partCount']);
			$data['title'] = $this->wtc_model->get_piece_title($piece);
			$data['book'] = $book;
			$data['piece_index'] = $piece_index;
			$data['piece'] = $piece;
			$data['matrix'] = $matrix;
			$data['program_notes'] = 'Test program notes!'; //TODO: Fill this in with something meaningful at some point!
			$data['default_price'] = '3.50';    //TODO: Make this based on a new model.
			$data['part_price_increase'] = '1.25';

			$this->load->view('templates/header', $data);
			$this->load->view('wtc/piece', $data);
			$this->load->view('templates/footer');
		}

		public function view_confirm() {
			$post = $this->input->post();
			//debug_print($post);
			$piece = $this->wtc_model->get_piece($post['book'], $post['piece_index']);
			$choices = [];
			foreach($post['part'] as $partIndex => $part) {
				$choices[$partIndex] = [];
				foreach($part as $instrument) {
					$choices[$partIndex][] = $this->wtc_model->get_instrument_by_id($instrument);
				}
			}
			$data['quoted_price'] = $post['price'];
			$data['choices'] = $choices;
			$data['format'] = $post['part_format']; //TODO: Do more here.
			$data['title'] = 'Confirm Your Choices';
			$data['piece'] = $piece;
			$data['piece_link'] = base_url('piece/' . $post['book'] . '/' . $post['piece_index']);
			$data['piece_title'] = $this->wtc_model->get_piece_title($piece);

			$this->load->view('templates/header', $data);
			$this->load->view('wtc/confirm', $data);
			$this->load->view('templates/footer');
		}

		public function build_ensemble_view() {
			$data['title'] = 'Build Your Ensemble';
			$data['instruments'] = $this->wtc_model->get_instruments();
			$data['ensembles'] = $this->wtc_model->get_ensembles();

			$this->load->view('templates/header', $data);
			$this->load->view('wtc/build', $data);
			$this->load->view('templates/footer');
		}

		public function view($slug = null) {
			$data['news_item'] = $this->news_model->get_news($slug);

			if(empty($data['news_item'])) {
				show_404();
			}

			$data['title'] = $data['news_item']['title'];

			$this->load->view('templates/header', $data);
			$this->load->view('wtc/view', $data);
			$this->load->view('templates/footer');
		}

		public function create() {
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['title'] = 'Create a news item';

			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('text', 'Text', 'required');

			if($this->form_validation->run() === false) {
				$this->load->view('templates/header', $data);
				$this->load->view('news/create');
				$this->load->view('templates/footer');

			}
			else {
				$this->news_model->set_news();
				$this->load->view('templates/header', $data);
				$this->load->view('news/success');
				$this->load->view('templates/footer');
			}
		}
	}