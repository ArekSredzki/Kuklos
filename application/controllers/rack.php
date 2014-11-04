<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rack extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_partial('header', 'layouts/header')->set_partial('footer', 'layouts/footer')->set_layout('application');
	}

	public function display() {
		// Get rack_id
		$rack_id = urldecode($this->uri->segment(2,-1));
		if ($rack_id == -1 || !$this->rack_model->rack_check($rack_id)) 
			redirect(base_url('rack/notfound'));

		$data['rack_data'] = $this->rack_model->get_rack_info($rack_id);

		$this->load->library('googlemaps');
		$config['minifyJS'] = TRUE;
		$config['zoom'] = '14';
		$config['center'] = $data['rack_data']['lat'].', '.$data['rack_data']['lon'];
		$this->googlemaps->initialize($config);

		$marker = array();

		$marker['position'] = $data['rack_data']['lat'].', '.$data['rack_data']['lon'];
		$marker['title'] = $data['rack_data']['address'];
		$marker['infowindow_content'] = "<h4 class=\"title\">Bike Rack</h4><p><span class=\"region\">".$data['rack_data']['address'].
			"</span><br><span class=\"rack_count\">Number of racks: ".$data['rack_data']['rack_count']."</span></p>";

		if ($data['rack_data']['rack_count'] == 1) {
			$icon_url = base_url()."assets/images/noun_project/bike-rack-1.svg";
		} else if ($data['rack_data']['rack_count'] == 2) {
			$icon_url = base_url()."assets/images/noun_project/bike-rack-2.svg";
		} else if ($data['rack_data']['rack_count'] == 3) {
			$icon_url = base_url()."assets/images/noun_project/bike-rack-3.svg";
		} else {
			$icon_url = base_url()."assets/images/noun_project/bike-rack.svg";
		}
		
		$marker['marker_image'] = "new google.maps.MarkerImage('".$icon_url."', null, null, null, new google.maps.Size(64,64))";

		$this->googlemaps->add_marker($marker);

		$data['map'] = $this->googlemaps->create_map();



		$data['page_name'] = "rack-page";
		$this->template
			->title('Rack Not Found', 'Kuklos')
			->build('pages/rack/home', $data);
	}

	public function notfound() {
		$data['page_name'] = "rack-page";
		$this->template
			->title('Rack Not Found', 'Kuklos')
			->build('pages/rack/notfound', $data);
	}
}

/* End of file rack.php */
/* Location: ./application/controllers/rack.php */