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
		$this->load->helper('inflector');

		$data = array();

		$this->load->library('googlemaps');
		$data['gotPosition'] = FALSE;

		if ($this->input->get('search') != '') {
			$data['gotPosition'] = TRUE;

			$config['geocodeCaching'] = TRUE;
			$this->googlemaps->initialize($config);
			$gmaps_result = $this->googlemaps->get_lat_long_from_address($this->input->get('search'));
			$lat = $gmaps_result[0];
			$lon = $gmaps_result[1];
		} else if ($this->input->post('lat') != '' && $this->input->post('lon') != '') {
			$data['gotPosition'] = TRUE;
			$lat = $this->input->post('lat');
			$lon = $this->input->post('lon');
		}

		// Generate Table
		$tmpl = array ( 'table_open'  => '<table id="rack-table" class="table table-hover table-responsive">' );
		$this->table->set_template($tmpl);

		$rack_result = array();

		if ($data['gotPosition']) {
			$this->table->set_heading('Address', 'Distance (m)', '# of Racks');
			$rack_result = $this->rack_model->get_racks_by_distance($lat, $lon);
		} else {
			$this->table->set_heading('Address', '# of Racks');
			$rack_result = $this->rack_model->get_all_racks_basic();
		}

		foreach ($rack_result as $key => $rack) {
			$rack_result[$key]['address'] = humanize($rack['address']);
		}

		$data['rack_table'] = $this->table->generate($rack_result);
		
		$this->template->set('page_name', 'table-page');
		$this->template->build('pages/table_view', $data);
	}

	private function map_view() {
		$data = array();
		$this->load->library('googlemaps');
		$this->load->helper('inflector');

		$config['geocodeCaching'] = TRUE;
		$config['minifyJS'] = FALSE;
		if ($this->input->get('search') != '') {
			$config['center'] = $this->input->get('search');
			$config['zoom'] = '14';

			$marker = array();
			$marker['position'] = $this->input->get('search');
			$marker['title'] = $this->input->get('search');
			$marker['marker_image'] = "new google.maps.MarkerImage('".base_url()."assets/images/noun_project/marker.svg', null, null, null, new google.maps.Size(42.67,64))";
			$this->googlemaps->add_marker($marker);
		} else {
			$config['center'] = '49.28, -123.13';
			$config['zoom'] = 'auto';
		}

		$config['places'] = TRUE;
		$config['cluster'] = TRUE;
		$config['placesAutocompleteInputID'] = 'search-form-input';
		$config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
		$config['placesAutocompleteOnChange'] = 'document.getElementById("search-form-input").value = placesAutocomplete.getPlace().formatted_address;
document.getElementById("search-form").submit();';
		$this->googlemaps->initialize($config);

		$racks = $this->rack_model->get_all_racks();

		foreach ($racks as $rack) {
			$marker = array();

			$marker['position'] = $rack['lat'].', '.$rack['lon'];
			$marker['title'] = humanize($rack['address']);
			$rack_url = base_url()."rack/".$rack['rack_id'];
			$marker['infowindow_content'] = "<h4 class=\"title\">Bike Rack</h4><p><span class=\"region\">".humanize($rack['address']).
				"</span><br><span class=\"rack_count\">Number of racks: ".$rack['rack_count']."</span><br><a href=".$rack_url.">Click for details</a></p>";

			/*
			$fav = $this->rack_model->get_fav_info($rack['rack_id'])

			if ($fav['email'] == $this->session->userdata('email')) {
				$icon_url = base_url()."assets/images/noun_project/yellow-star.svg";
			} else
			*/

			if ($rack['rack_count'] == 1) {
				$icon_url = base_url()."assets/images/noun_project/bike-rack-1.svg";
			} else if ($rack['rack_count'] == 2) {
				$icon_url = base_url()."assets/images/noun_project/bike-rack-2.svg";
			} else if ($rack['rack_count'] == 3) {
				$icon_url = base_url()."assets/images/noun_project/bike-rack-3.svg";
			} else {
				$icon_url = base_url()."assets/images/noun_project/bike-rack.svg";
			}
			
			$marker['marker_image'] = "new google.maps.MarkerImage('".$icon_url."', null, null, null, new google.maps.Size(64,64))";

			$this->googlemaps->add_marker($marker);
		}

		$data['map'] = $this->googlemaps->create_map();

		$this->template->set('page_name', 'map-page');
		$this->template->build('pages/map_view', $data);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */