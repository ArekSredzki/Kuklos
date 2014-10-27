<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('user_model');
		$this->template->set_partial('header', 'layouts/header')->set_partial('footer', 'layouts/footer');
	}

	public function index() {
		redirect(base_url());
	}

	//		$this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[4]|max_length[32]|is_unique[users.username]|xss_clean|strip_tags');

	public function register() {
		if ($this->user_model->loggedin())
			redirect('account/login');

		$this->load->library('form_validation','encrypt');

		$this->form_validation->set_rules('email', 'Email', 'required|trim|max_length[50]|xss_clean|strip_tags|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|max_length[30]');

		if ($this->form_validation->run() == False) {
			
		$data['page_name'] = "signup-page";
			$this->template
				->title('Signup', 'Kuklos')
				->set_layout('minimal')
				->build('pages/user/signup', $data);
		} else {

			// Setup validation email
			$this->load->library('email', array('mailtype'=>'html'));

			$this->email->from('hello@vikom.io', 'Kuklos');
			$this->email->to($this->input->post('email'));
			$this->email->subject("Welcome to Kuklos!");

			$message = "<p>Hello!</p>"
			$message .= "<p>Thanks for signing up for a Kuklos account!</p>";
			$message .= "<p>Your username is: ".$this->input->post('email')."</p>";
			$message .= "<p>You can login here: ".base_url('user/login')."</p>";
			$message .= "<p>We hope you enjoy the service.</p>";
			$message .= "<p>Thanks,<br/> - The Kuklos Team</p>";
			$message .= "<br/><p>This mailbox is not monitored</p>";

			$this->email->message($message);

			if ($this->user_model->add_user()) {
				if ($this->email->send()) {

					$data = array(
						'email' => $this->input->post('email'),
						'is_logged_in' => 1
					);
					$this->session->set_userdata($data);

					redirect('user');
				} else {
					echo "Error sending email";
				}
			} else echo "Error adding user to database";
		}
	}

	public function signup() {
	}

	public function login() {
		$this->load->library('form_validation');

		if ($this->user_model->loggedin())
			redirect('user');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger fade in">', '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|callback_validate_credentials');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == false) {
			$data['page_name'] = "login-page";
			$this->template
				->title('Login', 'Kuklos')
				->set_layout('minimal')
				->build('pages/user/login', $data);
		} else {

			$data = array(
				'email' => $this->input->post('email'),
				'is_logged_in' => 1
			);
			$this->session->set_userdata($data);

			redirect('user');
		}
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect(base_url('user/login'));
	}

	public function forgot() {
		$this->load->library('form_validation');

		if ($this->user_model->loggedin())
			redirect('user');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger fade in">', '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|valid_email|callback_valid_account_email');

		if($this->form_validation->run() === FALSE) {
			$data['page_name'] = "forgot-page";
			$this->template
				->title('Password Reset', 'Kuklos')
				->set_layout('minimal')
				->build('pages/user/forgot', $data);
		} else {
			$this->load->helper('gen');
			$userdata = $this->user_model->get_userdata($this->user_model->get_email($this->input->post('email')));

			// Generate new password
			$newpassword = _keyword(12);

			// Setup validation email
			$this->load->library('email', array('mailtype'=>'html'));

			$this->email->from('security@vikom.io', 'Kuklos');
			$this->email->to($userdata['email']);
			$this->email->subject("Kuklos Password Reset");

			$message = "<p>You have requested a password reset, you must now use the following password to login:</p>";
			$message .= "<p>".$newpassword."</p>";
			$message .= "<p>Your username is: ".$userdata['email']."</p>";
			$message .= "<p>You can login here: ".base_url('user/login')."</p>";
			$message .= "<p>If you did not request a new password then please email admin@vikom.io</p>";
			$message .= "<p>Thanks,<br/> - The Kuklos Team</p>";
			$message .= "<br/><p>This mailbox is not monitored</p>";

			$this->email->message($message);

			if ($this->user_model->reset_password($user_id , $newpassword)) {
				if ($this->email->send()) {
					//Send the success to our javascript file.
					$data['result'] = '<div class="alert alert-success fade in"><strong>Your password has been reset!</strong><br>Check your email for your password!<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
				} else {
					$data['result'] =  '<div class="alert alert-warning fade in"><strong>Your password has been reset!</strong><button type="button" class="close" data-dismiss="alert">&times;</button><br>However we were unable to send the email, please contact support.<p>';

				}
			} else
				$data['result'] =  '<div class="alert alert-danger fade in"><strong>Error</strong><button type="button" class="close" data-dismiss="alert">&times;</button><br>Unable to reset password.</div>';

			$data['page_name'] = "forgot-page";
			$this->template
				->title('Password Reset', 'Kuklos')
				->set_layout('minimal')
				->build('pages/user/forgot', $data);
		}
	}

	public function validate_credentials() {
		$this->load->model('user_model');

		if ($this->user_model->can_login($this->user_model->get_email($this->input->post('email')))) {
			return true;
		} else {
			$this->form_validation->set_message('validate_credentials', 'Incorrect email/password.');
			return false;
		}
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */