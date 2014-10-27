<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_partial('header', 'layouts/header')->set_partial('footer', 'layouts/footer');
	}

	public function index() {
		$data['page_name'] = "home-page";
		$this->template
			->title('Kuklos', 'Vancouver\'s #1 Bike Rack Directory')
			->build('pages/home', $data);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */