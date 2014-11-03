<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_partial('header', 'layouts/header')->set_partial('footer', 'layouts/footer')->set_layout('admin');

		if (!$this->user_model->is_logged_in())
			redirect(base_url());

		if (!$this->user_model->is_admin($this->session->userdata('email')))
			redirect(base_url('user'));
	}

	public function index() {
		$data['page_name'] = "admin-page";
		$this->template
			->title('Home', 'Admin', 'Kuklos')
			->build('pages/admin/home', $data);
	}

	public function load_xls() {
		$data['output'] = '';

		$file_path = (APPPATH . 'cache/temp.xls');
		if (file_exists($file_path)) {
			unlink($file_path);
		}

		// Load library for getting GPS Coordinates of racks
		$this->load->library('googlemaps');
		$config['geocodeCaching'] = TRUE;
		$this->googlemaps->initialize($config);

		// Get file from external server
		$this->load->library('ftp');
		$config['hostname'] = 'webftp.vancouver.ca';
		$config['username'] = 'anonymous';
		$config['password'] = '';
		$config['debug']	= TRUE;
		$this->ftp->connect($config);
		$this->ftp->download($this->input->post('url'), $file_path);
		$this->ftp->close();

		// Load XLS Reader
		include(APPPATH . 'libraries/SpreadsheetReader_XLS.php');
		$Reader = new SpreadsheetReader_XLS($file_path);

		$rows_to_skip = 6; // Number of blank header rows before data starts
		$cols_to_skip = 0; // Number of blank columns before data starts

		for ($i=0; $i < $rows_to_skip; $i++) { 
			$Reader->next();
		}

		if ($Reader->current()[0] == '') {
			$cols_to_skip = 1;
		}
		
		while ($Reader->valid()) {
			$row = $Reader->current();

			if ($row[$cols_to_skip] == '') {
				break; // End of data has been reached, break loop
			}

			if ($row[$cols_to_skip] != '' && $row[$cols_to_skip + 1] != '' && $row[$cols_to_skip + 5] != '') {
				$address = $row[$cols_to_skip].' '.$row[$cols_to_skip + 1].', Vancouver, Canada';

				$gmaps_result = $this->googlemaps->get_lat_long_from_address($address);
				$lat = $gmaps_result[0];
				$lon = $gmaps_result[1];

				if (!$this->rack_model->create_rack($address, $lat, $lon, $row[$cols_to_skip + 5])) {
					$data['output'] .= '<div class="alert alert-warning" role="alert">Rack at address: '.$address.' already exists</div>';
				}
				
			} else {
				$data['output'] .= '<div class="alert alert-danger" role="alert">Invalid entry at key: '.$Reader->key().'</div>';
			}
			$Reader->next();
		}


		if ($data['output'] == '') {
			$data['output'] = 'Successfully imported all racks.';
		} else {
			$data['output'] .= 'Successfully imported racks.';
		}

		$data['page_name'] = "admin-page";
		$this->template
			->title('XLS', 'Admin', 'Kuklos')
			->build('pages/admin/xls', $data);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */