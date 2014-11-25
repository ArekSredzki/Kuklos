<?php

class User_Model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

		//*****************************//
	   //                             //
	  //      CREATION FUNCTIONS     //
	 //                             //
	//*****************************//


	function add_user() {
		$this->load->helper('date');

		// Populate user table
		$data = array(
			'email' => $this->input->post('email'),
			'password' => $this->hash_password($this->input->post('password')),
			'timestamp' => now()
		);
		
		$query = $this->db->insert('users', $data);
		//$email = $this->input->post('email');


		// Report findings
		if ($query)
			return true;
		else
			return false;
	}

	function add_oauth_user($email) {
		$this->load->helper('date');

		// Populate user table
		$data = array(
			'email' => $email,
			'timestamp' => now()
		);
		
		$query = $this->db->insert('users', $data);
		//$email = $this->input->post('email');


		// Report findings
		if ($query)
			return true;
		else
			return false;
	}

		//*****************************//
	   //                             //
	  //      EDITING FUNCTIONS      //
	 //                             //
	//*****************************//

	function edit_user($email) {
		// Update users table with new info
		$data = array(
			'username' => $this->input->post('username')
		);

		$this->db->where('email', $email);
		if ($this->db->update('users', $data)) {
			return true;
		}
	}

	function reset_password($email, $new_password) {
		// Update database with new info
		$data = array(
			'password' => $this->hash_password($new_password)
		);

		$this->db->where('email', $email);
		if ($this->db->update('users', $data)) {
			return true;
		}
	}

		//*****************************//
	   //                             //
	  //     RETRIEVAL FUNCTIONS     //
	 //                             //
	//*****************************//
	
	  ///////////////////////
	 // GENERAL FUNCTIONS //
	///////////////////////


	// Get all users in order by creation timestamp
	function get_users($limit = -1) {

		// Get all users by order
		if ($limit == -1){
			$user_query = mysql_query("SELECT email
				FROM users
				ORDER BY timestamp ASC");
		} else {
			$user_query = mysql_query("SELECT email
				FROM users
				ORDER BY timestamp ASC
				LIMIT 0, $limit");
		}
		
		// Init array
		$users = array();
		// Add each user & it's info to users array
		while ($user = mysql_fetch_assoc($user_query)) {
			$users[] = $this->get_userdata($user['email']);
		}
		return $users;
	}

	  ////////////////////
	 // USER FUNCTIONS //
	////////////////////

	public function get_userdata($email = '0') {
		if ($email == '0')
			$email = $this->session->userdata('email');
		

		$this->db->where('email', $email);
		$query = $this->db->get('users');

		if ($query->num_rows() > 0) {
			$row = $query->row();
			$data = array(
				'email' => $row->email,
				'username' => $row->username
			);

			return $data;
		}
	}

	// returns email if valid username otherwise just returns input
	public function get_email($email) {
		if ($this->user_check($email)) {
			return $email;
		} else {
			$this->db->where('username', $email);
			$query = $this->db->get('users');

			if ($query->num_rows() > 0) {
				$row = $query->row();
				return $row->email;
			} else
				return $email;
		}
	}

	public function hash_password($password) {
		$site_key = 'ea26b464795010va1d3a19f2d7fdbec29a4625e3';
		return hash_hmac('sha1', $password . '293296', $site_key);
	}

		//*****************************//
	   //                             //
	  //       CHECK FUNCTIONS       //
	 //                             //
	//*****************************//

	// Check if valid user
	function user_check($email) {
		$this->db->where('email', $email)->from('users');
		return $this->db->count_all_results() == 1;
	}

	// Check if user is logged in
	function is_logged_in() {
		if($this->session->userdata('is_logged_in')) {
			if ($this->user_check($this->session->userdata('email')))
				return true;
			else {
				$this->session->sess_destroy();
				return false;
			}
		} else
			return false;
	}

	// Check if user is admin
	function is_admin($email = '') {
		if ($email == '')
			$email = $this->session->userdata('email');

		$this->db->where('email', $email);
		$query = $this->db->get('users');

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return ($row->is_admin == 1);
		} else
			return false;
	}

	// Check if user has entered valid credentials
	public function can_login($email = '') {
		if ($email == '')
			$email = $this->input->post('email');
		
		$this->db->where('email', $email);
		$this->db->where('password', $this->hash_password($this->input->post('password')));
		$query = $this->db->get('users');

		if ($query->num_rows() == 1) {
			return true;
		} else {
			$this->db->where('username', $this->input->post('username'));
			$this->db->where('password', $this->hash_password($this->input->post('password')));
			$query = $this->db->get('users');

			if ($query->num_rows() == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */