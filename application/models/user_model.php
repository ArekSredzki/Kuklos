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
		$this->load->helper('time');

		// Populate user table
		$data1 = array(
			'username' => $this->input->post('username'),
			'password' => $this->hash_password($this->input->post('password')),
			'timestamp' => now()
		);
		
		$query = $this->db->insert('users', $data1);
		//$username = $this->input->post('username');


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

	function edit_user($user_id) {
		// Update user_info table with new info
		$data = array(
			'name' => $this->input->post('name')
		);

		$this->db->where('user_id', $user_id);
		if ($this->db->update('user_info', $data)) {
			// Update users table with new info
			$data = array(
				'email' => $this->input->post('email')
			);

			$this->db->where('user_id', $user_id);
			if ($this->db->update('users', $data)) {
				return true;
			}
		}
	}

	function reset_password($user_id,$newpassword) {

		// Update database with new info
		$data = array(
			'password' => $this->hash_password($newpassword)
		);

		$this->db->where('user_id', $user_id);
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


	// Get all users in order by user_id
	function get_users($limit = -1) {

		// Get all users by order
		if ($limit == -1){
			$user_query = mysql_query("SELECT user_id
				FROM users
				ORDER BY user_id DESC");
		} else {
			$user_query = mysql_query("SELECT user_id
				FROM users
				ORDER BY user_id DESC
				LIMIT 0, $limit");
		}
		
		// Init array
		$users = array();
		// Add each image & it's info to images array
		while ($user = mysql_fetch_assoc($user_query)) {
			$users[] = $this->get_userdata($user['user_id']);
		}
		return $users;
	}

      ////////////////////
	 // USER FUNCTIONS //
	////////////////////

	public function get_userdata($user_id = '0') {
		if ($user_id == '0')
			$user_id = $this->session->userdata('user_id');
		

		$this->db->where('user_id', $user_id);
		$userrow = $this->db->get('users');

		if ($userrow) {
			$row = $userrow->row();
			$data = array(
				'username' => $row->username
			);

			return $data;
		}
	}

    public function hash_password($password) {
        $site_key = 'ea26b464795010fa1d3a19f2d7febec29a4625e3';
        return hash_hmac('sha1', $password . '293296', $site_key);
    }

	    //*****************************//
	   //                             //
	  //       CHECK FUNCTIONS       //
	 //                             //
	//*****************************//

	// Check if valid user
	function user_check($username) {
		$this->db->where('username', $username)->from('users');
		if ($this->db->count_all_results() == 1)
			return true;
		else
			return false;
	}

	// Check if user is logged in
    function loggedin() {
        if($this->session->userdata('is_logged_in')) {
        	if ($this->user_check($this->session->userdata('username')))
            	return true;
            else {
				$this->session->sess_destroy();
            	return false;
            }
        } else
            return false;
    }

    /// THIS HAS TO BE CHANGED FOR FB LOGIN
	public function can_login($username = '') {
		if ($username == '') {
			$username = $this->input->post('username');
		}
		$this->db->where('username', $username);
		$this->db->where('password', $this->hash_password($this->input->post('password')));
		$query = $this->db->get('users');

		if ($query->num_rows() == 1) {
			return true;
		} else {
			$this->db->where('email', $this->input->post('username'));
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