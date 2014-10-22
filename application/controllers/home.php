<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index() {
		$this->load->view('layouts/header');
		$this->load->view('pages/home');
		$this->load->view('layouts/footer');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */