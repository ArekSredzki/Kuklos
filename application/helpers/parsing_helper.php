<?php  if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');

function parse($file_path) {
    $CI =& get_instance();

	// Load XLS Reader
	require_once(APPPATH . 'libraries/SpreadsheetReader_XLS.php');
	$Reader = new SpreadsheetReader_XLS($file_path);

	// Load library for getting GPS Coordinates of racks
	$CI->load->library('googlemaps');
	$config['geocodeCaching'] = TRUE;
	$CI->googlemaps->initialize($config);

	$rows_to_skip = 6; // Number of blank header rows before data starts
	$cols_to_skip = 0; // Number of blank columns before data starts

	$output = '';

	for ($i=0; $i < $rows_to_skip; $i++) { 
		$Reader->next();
	}

	if (!$Reader->valid() || !array_key_exists(0, $Reader->current())) {
		return '<div class="alert alert-danger" role="alert">Document contains zero entries</div>';
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

			$gmaps_result = $CI->googlemaps->get_lat_long_from_address($address);
			$lat = $gmaps_result[0];
			$lon = $gmaps_result[1];

			if (!$CI->rack_model->create_rack($address, $lat, $lon, $row[$cols_to_skip + 5])) {
				$output .= '<div class="alert alert-warning" role="alert">Rack at address: '.$address.' already exists</div>';
			}
			
		} else {
			$output .= '<div class="alert alert-danger" role="alert">Invalid entry at key: '.$Reader->key().'</div>';
		}
		$Reader->next();
	}

	return $output;
}