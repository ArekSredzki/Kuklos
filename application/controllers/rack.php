<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rack extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_partial('header', 'layouts/header')->set_partial('footer', 'layouts/footer')->set_layout('application');
	}

	public function display() {
		$this->load->helper('inflector');

		// Get rack_id
		$rack_id = urldecode($this->uri->segment(2,-1));
		if ($rack_id == -1 || !$this->rack_model->rack_check($rack_id)) 
			redirect(base_url('rack/notfound'));

		$data['rack_data'] = $this->rack_model->get_rack_info($rack_id);
		$data['rack_data']['address'] = humanize($data['rack_data']['address']);

		$this->load->library('googlemaps');
		$config['minifyJS'] = TRUE;
		$config['zoom'] = '14';
		$config['center'] = $data['rack_data']['lat'].', '.$data['rack_data']['lon'];
		$this->googlemaps->initialize($config);

		$marker = array();

		$marker['position'] = $data['rack_data']['lat'].', '.$data['rack_data']['lon'];
		$marker['title'] = $data['rack_data']['address'];
		$rack_url = base_url()."rack/".$data['rack_data']['rack_id'];
		$marker['infowindow_content'] = "<h4 class=\"title\">Bike Rack</h4><p><span class=\"region\">".$data['rack_data']['address'].
			"</span><br><span class=\"rack_count\">Number of racks: ".$data['rack_data']['rack_count']."</span></p>";

		if ($this->rack_model->is_favourited($rack_id, $this->session->userdata('email'))) {
			$icon_url = base_url()."assets/images/noun_project/star.svg";
		}

		else if ($data['rack_data']['rack_count'] == 1) {
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
		
		// Show and allow adding comments
		$data['comments'] = $this->rack_model->get_comments($rack_id);

		// Gets the rating for a rack
		$data['rating'] = $this->rack_model->get_rating($rack_id);

		$data['is_logged_in'] = $this->user_model->is_logged_in();

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger fade in">', '<button type="button" class="close" data-dismiss="alert">&times;</button></div>'); 
		$this->form_validation->set_rules('text', 'text', 'required');

		if ($this->form_validation->run() === TRUE) {
			$this->rack_model->add_comment($rack_id);
			redirect('rack/'.$rack_id.'');
		}
		
		$this->template
			->title('Rack - '.$data['rack_data']['address'].'', 'Kuklos')
			->build('pages/rack/home', $data);
	}

	public function notfound() {
		$data['page_name'] = "rack-page";
		$this->template
			->title('Rack Not Found', 'Kuklos')
			->build('pages/rack/notfound', $data);
	}

	public function favourite_rack() {
		//Check if user is logged in
		if (!$this->user_model->is_logged_in())
			redirect($_SERVER['HTTP_REFERER']);

		// Get rack_id
		$rack_id = urldecode($this->uri->segment(2, -1));
		if ($rack_id == -1 || !$this->rack_model->rack_check($rack_id))
			redirect(base_url('rack/notfound'));

		if ($this->rack_model->is_favourited($rack_id, $this->session->userdata('email'))) {
			$this->rack_model->unfavourite_rack($rack_id);
		} else {
			$this->rack_model->favourite_rack($rack_id);
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function thumbs_up() {
		//Check if user is logged in
		if (!$this->user_model->is_logged_in())
			redirect($_SERVER['HTTP_REFERER']);

		// Get rack_id
		$rack_id = urldecode($this->uri->segment(2,-1));
		if ($rack_id == -1 || !$this->rack_model->rack_check($rack_id)) 
			redirect(base_url('rack/notfound'));

		$this->rack_model->thumbs_up($rack_id, $this->session->userdata('email'));

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function thumbs_down() {
		//Check if user is logged in
		if (!$this->user_model->is_logged_in())
			redirect($_SERVER['HTTP_REFERER']);

		// Get rack_id
		$rack_id = urldecode($this->uri->segment(2,-1));
		if ($rack_id == -1 || !$this->rack_model->rack_check($rack_id)) 
			redirect(base_url('rack/notfound'));

		$this->rack_model->thumbs_down($rack_id, $this->session->userdata('email'));

		redirect($_SERVER['HTTP_REFERER']);
	}

}

/* End of file rack.php */
/* Location: ./application/controllers/rack.php */