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

		$this->load->library('googlemaps');

		$config['geocodeCaching'] = TRUE;
		$config['minifyJS'] = TRUE;

		// Generate Table
		$tmpl = array ( 'table_open'  => '<table class="table table-hover">' );
		$this->table->set_template($tmpl);
		$this->table->set_heading('ID', 'Address', 'Distance', '# of Racks');
		$data['rack_table'] = $this->table->generate($this->rack_model->get_all_racks_query());

		$this->template->set('page_name', 'table-page');
		$this->template->build('pages/table_view', $data);
	}

	private function map_view() {
		$data = array();
		$this->load->library('googlemaps');

		$config['geocodeCaching'] = TRUE;
		$config['minifyJS'] = TRUE;
		$config['center'] = '49.28, -123.13';
		$config['zoom'] = 'auto';
		$config['places'] = TRUE;
		$config['placesAutocompleteInputID'] = 'search-form-input';
		$config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
		$config['placesAutocompleteOnChange'] = 'document.getElementById("search-form").submit();';
		$this->googlemaps->initialize($config);

		$racks = $this->rack_model->get_all_racks();

		foreach ($racks as $rack) {
			$marker = array();

			$marker['position'] = $rack['lat'].', '.$rack['lon'];
			$marker['title'] = $rack['address'];
			$marker['infowindow_content'] = "<h4 class=\"title\">Bike Rack</h4><p><span class=\"region\">".$rack['address'].
				"</span><br><span class=\"rack_count\">Number of racks: ".$rack['rack_count']."</span></p>";
			$marker['icon'] = "new google.maps.MarkerImage('".base_url()."assets/images/noun_project/bike_rack.svg', null, null, null, new google.maps.Size(64,64))";

			$this->googlemaps->add_marker($marker);
		}



		$data['map'] = $this->googlemaps->create_map();

		$this->template->set('page_name', 'map-page');
		$this->template->build('pages/map_view', $data);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */