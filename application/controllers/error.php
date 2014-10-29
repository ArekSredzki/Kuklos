<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_partial('header', 'layouts/header')->set_partial('footer', 'layouts/footer');
	}

	public function index() {
		$this->template
			->title('404 Page Not Found', 'Kuklos')
			->set('page_name', 'contact-page')
			->build('pages/404');
	}
}

/* End of file error.php */
/* Location: ./application/controllers/error.php */