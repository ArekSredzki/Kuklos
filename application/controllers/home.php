<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_partial('header', 'layouts/header')->set_partial('footer', 'layouts/footer');
	}

	public function index() {
		$this->template->title('Kuklos', 'Vancouver\'s #1 Bike Rack Directory');

		if ($this->user_model->is_logged_in()) {
			$this->template->set('page_name', 'contact-page')->set_layout('application');
			if ($this->session->userdata('default_view') == 'map') {
				$this->map_view();
			} else {
				$this->table_view();
			}
		} else {
			$this->template->set('page_name', 'home-page');
			$this->splash();
		}
	}

	private function splash() {
		$this->template->build('pages/home');
	}

	private function table_view() {
		$this->load->library('table');

		$data = array();

		// Generate Table
		$tmpl = array ( 'table_open'  => '<table class="table table-hover">' );
		$this->table->set_template($tmpl);
		$this->table->set_heading('ID', 'Address', 'Latitude', 'Longitude', '# of Racks');
		$data['rack_table'] = $this->table->generate($this->rack_model->get_all_racks_query());

		$this->template->set('page_name', 'table-page');
		$this->template->build('pages/table_view', $data);
	}

	private function map_view() {
		$data = array();
		$this->load->helper('map');

		$data['map_elements'] = generate_map_rack_js($this->rack_model->get_all_racks());

		$this->template->set('page_name', 'map-page');
		$this->template->build('pages/map_view', $data);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */