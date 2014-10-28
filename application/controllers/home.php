<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_partial('header', 'layouts/header')->set_partial('footer', 'layouts/footer');
	}

	public function index() {
		$this->template
			->title('Kuklos', 'Vancouver\'s #1 Bike Rack Directory')
			->set('page_name', 'home-page');

		if ($this->user_model->is_logged_in()) {
			$this->application();
		} else {
			$this->splash();
		}
		
	}

	private function splash() {
		$this->template->build('pages/home');
	}

	private function application() {
		$this->template->build('pages/home');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */