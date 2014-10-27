<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_partial('header', 'layouts/header')->set_partial('footer', 'layouts/footer');
	}

	public function index() {
		$data['page_name'] = "home-page";
		$this->template
			->title('Home', 'Admin', 'Kuklos')
			->build('pages/home', $data);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */