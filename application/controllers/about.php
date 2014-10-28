<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_partial('header', 'layouts/header')->set_partial('footer', 'layouts/footer');
	}

	public function index() {
		$this->template
			->title('About', 'Kuklos')
			->set('page_name', 'about-page')
			->build('pages/about');
	}
}

/* End of file about.php */
/* Location: ./application/controllers/about.php */