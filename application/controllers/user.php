<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends My_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_partial('header', 'layouts/header')->set_partial('footer', 'layouts/footer');
	}

	public function index() {
		redirect(base_url());
	}

	public function switch_view() {
		if (!$this->user_model->is_logged_in())
			redirect(base_url());

		if ($this->session->userdata('default_view') == 'map') {
			$this->session->set_userdata('default_view', 'table');
		} else {
			$this->session->set_userdata('default_view', 'map');
		}
		
		redirect(base_url());
	}

	public function signup() {
		if ($this->user_model->is_logged_in())
			redirect('user/login');

		$this->load->library('form_validation','encrypt');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger fade in">', '<button type="button" class="close" data-dismiss="alert">&times;</button></div>'); 
		$this->form_validation->set_rules('email', 'Email', 'required|trim|max_length[50]|xss_clean|strip_tags|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|max_length[30]');
		$this->form_validation->set_message('is_unique', 'That %s is taken.');

		if ($this->form_validation->run() == False) {
			$data['page_name'] = "signup-page";
			$this->template
				->title('Signup', 'Kuklos')
				->set_layout('minimal')
				->build('pages/user/signup', $data);
		} else {

			if ($this->user_model->add_user()) {
				if ($this->send_welcome_email($this->input->post('email'))) {
					$this->set_login_userdata($this->input->post('email'));
					redirect('user');
				} else {
					echo "Error sending email";
				}
			} else echo "Error adding user to database";
		}
	}

	public function connect_with_oauth2($provider_name) {
		if ($this->user_model->is_logged_in())
			redirect('user/login');

		switch ($provider_name) {
			case 'facebook':
				$provider = new League\OAuth2\Client\Provider\Facebook(array(
					'clientId'  =>  '738761806197904',
					'clientSecret'  =>  '913fab2aabe36d3af31dc738e3964d69',
					'redirectUri'   =>  'http://kuklos.vikom.io/user/connect/facebook',
					'scopes' => array('email'),
				));
				break;

			case 'github':
				$provider = new League\OAuth2\Client\Provider\Github(array(
					'clientId'  =>  'e100df6b5305c00f58e3',
					'clientSecret'  =>  'b27953bc5421ce1e109e2b49c7fbb170de51108c',
					'redirectUri'   =>  'http://kuklos.vikom.io/user/connect/github',
					'scopes' => array('email'),
				));
				break;

			case 'google':
				$provider = new League\OAuth2\Client\Provider\Google(array(
					'clientId'  =>  '246372104087-gf5re27h5ds69p09ubs25qmlf4bh3oim.apps.googleusercontent.com',
					'clientSecret'  =>  '4ccpNZwabW817I6jhN1n8TdB',
					'redirectUri'   =>  'http://kuklos.vikom.io/user/connect/google',
					'scopes' => array('email'),
				));
				break;
			
			default:
				exit('Unsupported OAuth2 Provider: '.$provider_name);
		}

		if (!isset($_GET['code'])) {
			// If we don't have an authorization code then get one
			header('Location: '.$provider->getAuthorizationUrl());
			exit;
		} else {
			// Try to get an access token (using the authorization code grant)
			$token = $provider->getAccessToken('Authorization_Code', [
				'code' => $_GET['code']
			]);

			// Get user email
			$email = '';
			try {
				// We got an access token, let's now get the user's details
				$userDetails = $provider->getUserDetails($token);

				// Use these details to create a new profile
				$email = $userDetails->email;
			} catch (Exception $e) {
				// Failed to get user details
				exit('Something went wrong. Contact Admin.');
			}

			// Create account if it does not exist
			if ($this->user_model->add_oauth_user($email)) {
				$this->send_welcome_email($email);
			}
			$this->set_login_userdata($email);
			redirect('user');

			// // Use this to interact with an API on the users behalf
			// echo $token->accessToken;

			// // Use this to get a new access token if the old one expires
			// echo $token->refreshToken;

			// // Number of seconds until the access token will expire, and need refreshing
			// echo $token->expires;
		}
	}

	public function login() {
		$this->load->library('form_validation');

		if ($this->user_model->is_logged_in())
			redirect('user');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger fade in">', '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|callback_validate_credentials');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == false) {
			$data['page_name'] = "signup-page";
			$this->template
				->title('Login', 'Kuklos')
				->set_layout('minimal')
				->build('pages/user/login', $data);
		} else {
			$this->set_login_userdata($this->input->post('email'));
			redirect('user');
		}
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect(base_url('user/login'));
	}

	public function forgot() {
		$this->load->library('form_validation');

		if ($this->user_model->is_logged_in())
			redirect('user');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger fade in">', '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|valid_email|callback_valid_account_email');

		if ($this->form_validation->run() === FALSE) {
			$data['page_name'] = "forgot-page";
			$this->template
				->title('Password Reset', 'Kuklos')
				->set_layout('minimal')
				->build('pages/user/forgot', $data);
		} else {
			$this->load->helper('gen');
			$userdata = $this->user_model->get_userdata($this->input->post('email'));

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

			if ($this->user_model->reset_password($userdata['email'], $newpassword)) {
				if ($this->email->send()) {
					//Send the success to our javascript file.
					$data['result'] = '<div class="alert alert-success fade in"><strong>Your password has been reset!</strong><br>Check your email for your password!<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
				} else {
					$data['result'] =  '<div class="alert alert-warning fade in"><strong>Your password has been reset!</strong><button type="button" class="close" data-dismiss="alert">&times;</button><br>However we were unable to send the email, please contact support.<p>';
				}
			} else {
				$data['result'] =  '<div class="alert alert-danger fade in"><strong>Error</strong><button type="button" class="close" data-dismiss="alert">&times;</button><br>Unable to reset password.</div>';
			}

			$data['page_name'] = "forgot-page";
			$this->template
				->title('Password Reset', 'Kuklos')
				->set_layout('minimal')
				->build('pages/user/forgot', $data);
		}
	}

	public function validate_credentials() {
		if ($this->user_model->can_login($this->user_model->get_email($this->input->post('email')))) {
			return true;
		} else {
			$this->form_validation->set_message('validate_credentials', 'Incorrect email/password.');
			return false;
		}
	}

	private function send_welcome_email($email_address) {
		// Setup validation email
		$this->load->library('email', array('mailtype'=>'html'));

		$this->email->from('hello@vikom.io', 'Kuklos');
		$this->email->to($email_address);
		$this->email->subject("Welcome to Kuklos!");

		$message = "<p>Hello!</p>";
		$message .= "<p>Thanks for signing up for a Kuklos account!</p>";
		$message .= "<p>Your username is: ".$email_address."</p>";
		$message .= "<p>You can login here: ".base_url('user/login')."</p>";
		$message .= "<p>We hope you enjoy the service.</p>";
		$message .= "<p>Thanks,<br/> - The Kuklos Team</p>";
		$message .= "<br/><p>This mailbox is not monitored</p>";

		$this->email->message($message);

		return $this->email->send();
	}

	private function set_login_userdata($email)	{
		$data = array(
			'email' => $email,
			'is_logged_in' => 1,
			'default_view' => 'map'
		);
		$this->session->set_userdata($data);
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */