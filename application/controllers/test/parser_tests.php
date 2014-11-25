<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/test/Toast.php');
define('TEST_XLS_FOLDER', (APPPATH . 'cache/parser_test_source/'));

class Parser_tests extends Toast {

	function __construct() {
		parent::__construct(__FILE__);
		// Load any models, libraries etc. you need here
		$this->load->helper('parsing');
	}

	/**
	 * OPTIONAL; Anything in this function will be run before each test
	 * Good for doing cleanup: resetting sessions, renewing objects, etc.
	 */
	function _pre() {
		// Use testing database
		$new_db = $this->load->database('testing', TRUE);
		$this->db = $new_db;

		// Truncate racks table
		$this->db->query("TRUNCATE `racks`" );
		$this->db->query("ALTER TABLE `racks` AUTO_INCREMENT = 1");
	}

	/**
	 * OPTIONAL; Anything in this function will be run after each test
	 * I use it for setting $this->message = $this->My_model->getError();
	 */
	function _post() {}

	function test_empty() {
		$output1 = parse(TEST_XLS_FOLDER.'empty_col_skip.xls');
		$output2 = parse(TEST_XLS_FOLDER.'empty_no_col_skip.xls');

		$this->_assert_equals($output1, '<div class="alert alert-danger" role="alert">Document contains zero entries</div>');
		$this->_assert_equals($output2, '<div class="alert alert-danger" role="alert">Document contains zero entries</div>');

		$this->_assert_equals(count($this->rack_model->get_all_racks()), 0);
	}

	function test_single_col_skip() {
		$output = parse(TEST_XLS_FOLDER.'single_col_skip.xls');
		$this->_assert_equals($output, '');
		$this->_assert_equals(count($this->rack_model->get_all_racks()), 1);
	}

	function test_single_no_col_skip() {
		$output = parse(TEST_XLS_FOLDER.'single_no_col_skip.xls');
		$this->_assert_equals($output, '');
		$this->_assert_equals(count($this->rack_model->get_all_racks()), 1);
	}

	function test_many_no_duplicates_col_skip() {
		$output = parse(TEST_XLS_FOLDER.'many_no_duplicates_col_skip.xls');
		$this->_assert_equals($output, '');
		$this->_assert_equals(count($this->rack_model->get_all_racks()), 31);
	}

	function test_many_no_duplicates_no_col_skip() {
		$output = parse(TEST_XLS_FOLDER.'many_no_duplicates_no_col_skip.xls');
		$this->_assert_equals($output, '');
		$this->_assert_equals(count($this->rack_model->get_all_racks()), 31);
	}

	function test_many_one_duplicate_col_skip() {
		$output = parse(TEST_XLS_FOLDER.'many_one_duplicate_col_skip.xls');
		$this->_assert_equals($output, '<div class="alert alert-warning" role="alert">Rack at address: 401 Burrard, Vancouver, Canada already exists</div>');
		$this->_assert_equals(count($this->rack_model->get_all_racks()), 30);
	}

	function test_many_one_duplicate_no_col_skip() {
		$output = parse(TEST_XLS_FOLDER.'many_one_duplicate_no_col_skip.xls');
		$this->_assert_equals($output, '<div class="alert alert-warning" role="alert">Rack at address: 401 Burrard, Vancouver, Canada already exists</div>');
		$this->_assert_equals(count($this->rack_model->get_all_racks()), 30);
	}

	function test_many_multiple_duplicates_col_skip() {
		$output = parse(TEST_XLS_FOLDER.'many_multiple_duplicates_col_skip.xls');
		$this->_assert_equals($output, '<div class="alert alert-warning" role="alert">Rack at address: 401 Burrard, Vancouver, Canada already exists</div><div class="alert alert-warning" role="alert">Rack at address: 401 Burrard, Vancouver, Canada already exists</div><div class="alert alert-warning" role="alert">Rack at address: 227 W Hastings, Vancouver, Canada already exists</div>');
		$this->_assert_equals(count($this->rack_model->get_all_racks()), 28);
	}

	function test_many_multiple_duplicates_no_col_skip() {
		$output = parse(TEST_XLS_FOLDER.'many_multiple_duplicates_no_col_skip.xls');
		$this->_assert_equals($output, '<div class="alert alert-warning" role="alert">Rack at address: 401 Burrard, Vancouver, Canada already exists</div><div class="alert alert-warning" role="alert">Rack at address: 401 Burrard, Vancouver, Canada already exists</div><div class="alert alert-warning" role="alert">Rack at address: 227 W Hastings, Vancouver, Canada already exists</div>');
		$this->_assert_equals(count($this->rack_model->get_all_racks()), 28);
	}

	function test_malformed_entries_col_skip() {
		$output = parse(TEST_XLS_FOLDER.'malformed_entries_col_skip.xls');
		$this->_assert_equals($output, '<div class="alert alert-danger" role="alert">Invalid entry at key: 10</div><div class="alert alert-danger" role="alert">Invalid entry at key: 11</div><div class="alert alert-danger" role="alert">Invalid entry at key: 12</div>');
		$this->_assert_equals(count($this->rack_model->get_all_racks()), 4);
	}

	function test_malformed_entries_no_col_skip() {
		$output = parse(TEST_XLS_FOLDER.'malformed_entries_no_col_skip.xls');
		$this->_assert_equals($output, '<div class="alert alert-danger" role="alert">Invalid entry at key: 10</div><div class="alert alert-danger" role="alert">Invalid entry at key: 11</div><div class="alert alert-danger" role="alert">Invalid entry at key: 12</div>');
		$this->_assert_equals(count($this->rack_model->get_all_racks()), 4);
	}
}

// End of file parser_tests.php */
// Location: ./system/application/controllers/test/parser_tests.php */