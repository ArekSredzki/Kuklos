<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends My_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_partial('header', 'layouts/header')->set_partial('footer', 'layouts/footer')->set_layout('admin');

		if (!$this->user_model->is_logged_in())
			redirect(base_url());

		if (!$this->user_model->is_admin($this->session->userdata('email')))
			redirect(base_url('user'));
	}

	public function index() {
		// Load the file helper 
		$this->load->helper('file');
		$data['backups'] = get_filenames('/var/backups/kuklos/');
		sort($data['backups']);

		$data['page_name'] = "admin-page";
		$this->template
			->title('Home', 'Admin', 'Kuklos')
			->build('pages/admin/home', $data);
	}

	public function restore_success() {
		// Load the file helper 
		$this->load->helper('file');
		$data['backups'] = get_filenames('/var/backups/kuklos/');
		sort($data['backups']);
		$data['restore_result'] = '<div class="alert alert-success fade in"><strong>Success!</strong>  The database has been restored<button type="button" class="close" data-dismiss="alert">&times;</button></div>';

		$data['page_name'] = "admin-page";
		$this->template
			->title('Home', 'Admin', 'Kuklos')
			->build('pages/admin/home', $data);
	}

	public function backup_success() {
		// Load the file helper 
		$this->load->helper('file');
		$data['backups'] = get_filenames('/var/backups/kuklos/');
		sort($data['backups']);
		$data['restore_result'] = '<div class="alert alert-success fade in"><strong>Success!</strong>  The database has been backed up to disk<button type="button" class="close" data-dismiss="alert">&times;</button></div>';

		$data['page_name'] = "admin-page";
		$this->template
			->title('Home', 'Admin', 'Kuklos')
			->build('pages/admin/home', $data);
	}

	public function save_backup() {
		// Load the file helper 
		$this->load->helper('file');

		// Load the DB utility class
		$this->load->dbutil();

		// Backup the entire database and assign it to a variable
		$prefs = array(
            'format'      => 'txt',             // gzip, zip, txt
            'add_drop'    => FALSE,              // Whether to add DROP TABLE statements to backup file
            'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
            'newline'     => "\n"               // Newline character used in backup file
          );

		$backup =& $this->dbutil->backup($prefs); 

		// Get number of existing backups in order to properly name the new backup
		$number_of_backups = count(get_filenames('/var/backups/kuklos/'));

		// write the file to your server
		write_file('/var/backups/kuklos/backup_'.$number_of_backups.'.sql', $backup);

		// // Load the download helper and send the file to your desktop
		// $this->load->helper('download');
		// force_download('mybackup.gz', $backup);

		redirect(base_url('admin/backup_success'));
	}

	public function restore_backup($file_name) {
		// Load the file helper 
		$this->load->helper('file');

		$file_path = '/var/backups/kuklos/'.$file_name;

		$backup = read_file($file_path);

		if (!$backup) {
			//FAILURE File Doesn't exist
			print("Error: File does not exist ");
			print($file_path);
			redirect(base_url('admin'));
		}

		// Truncate all tables
		$query = $this->db->query("SHOW TABLES");
		$name = $this->db->database;
		foreach ($query->result_array() as $row) {
			$table = $row['Tables_in_' . $name];
			$this->db->query("TRUNCATE " . $table);
			$this->db->query("ALTER TABLE ".$table." AUTO_INCREMENT = 1");
		}
        
		$sql_clean = '';
		foreach (explode("\n", $backup) as $line) {
			if(isset($line[0]) && $line[0] != "#")
				$sql_clean .= $line."\n";
		}

		//echo $sql_clean;

		foreach (explode(";\n", $sql_clean) as $sql) {
			$sql = trim($sql);
			//echo  $sql.'<br/>============<br/>';
			if ($sql)
				$this->db->query($sql);
		}

		// Load the download helper and send the file to your desktop
		// $this->load->helper('download');
		// force_download('backup.sql', $backup);

		redirect(base_url('admin/restore_success'));
	}

	public function load_xls() {
		$this->load->helper('parsing');

		$file_path = (APPPATH . 'cache/temp.xls');
		if (file_exists($file_path)) {
			unlink($file_path);
		}

		// Get file from external server
		$this->load->library('ftp');
		$config['hostname'] = 'webftp.vancouver.ca';
		$config['username'] = 'anonymous';
		$config['password'] = '';
		$config['debug']	= TRUE;
		$this->ftp->connect($config);
		$this->ftp->download($this->input->post('url'), $file_path);
		$this->ftp->close();

		$data['output'] = parse($file_path);

		if ($data['output'] == '') {
			$data['output'] = 'Successfully imported all racks.';
		} else {
			$data['output'] .= 'Successfully imported racks.';
		}

		$data['page_name'] = "admin-page";
		$this->template
			->title('XLS', 'Admin', 'Kuklos')
			->build('pages/admin/xls', $data);
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */