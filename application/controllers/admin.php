<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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

		redirect(base_url('admin'));
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

		redirect(base_url('admin'));
	}

	public function load_xls() {
		$data['output'] = '';

		$file_path = (APPPATH . 'cache/temp.xls');
		if (file_exists($file_path)) {
			unlink($file_path);
		}

		// Load library for getting GPS Coordinates of racks
		$this->load->library('googlemaps');
		$config['geocodeCaching'] = TRUE;
		$this->googlemaps->initialize($config);

		// Get file from external server
		$this->load->library('ftp');
		$config['hostname'] = 'webftp.vancouver.ca';
		$config['username'] = 'anonymous';
		$config['password'] = '';
		$config['debug']	= TRUE;
		$this->ftp->connect($config);
		$this->ftp->download($this->input->post('url'), $file_path);
		$this->ftp->close();

		// Load XLS Reader
		include(APPPATH . 'libraries/SpreadsheetReader_XLS.php');
		$Reader = new SpreadsheetReader_XLS($file_path);

		$rows_to_skip = 6; // Number of blank header rows before data starts
		$cols_to_skip = 0; // Number of blank columns before data starts

		for ($i=0; $i < $rows_to_skip; $i++) { 
			$Reader->next();
		}

		if ($Reader->current()[0] == '') {
			$cols_to_skip = 1;
		}
		
		while ($Reader->valid()) {
			$row = $Reader->current();

			if ($row[$cols_to_skip] == '') {
				break; // End of data has been reached, break loop
			}

			if ($row[$cols_to_skip] != '' && $row[$cols_to_skip + 1] != '' && $row[$cols_to_skip + 5] != '') {
				$address = $row[$cols_to_skip].' '.$row[$cols_to_skip + 1].', Vancouver, Canada';

				$gmaps_result = $this->googlemaps->get_lat_long_from_address($address);
				$lat = $gmaps_result[0];
				$lon = $gmaps_result[1];

				if (!$this->rack_model->create_rack($address, $lat, $lon, $row[$cols_to_skip + 5])) {
					$data['output'] .= '<div class="alert alert-warning" role="alert">Rack at address: '.$address.' already exists</div>';
				}
				
			} else {
				$data['output'] .= '<div class="alert alert-danger" role="alert">Invalid entry at key: '.$Reader->key().'</div>';
			}
			$Reader->next();
		}


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