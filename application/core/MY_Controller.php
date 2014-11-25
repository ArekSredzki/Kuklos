<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('template');
	}
}

/* End of file my_controller.php */
/* Location: ./application/core/my_controller.php */