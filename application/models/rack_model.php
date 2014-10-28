<?php
class Rack_Model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

		//*****************************//
	   //                             //
	  //      CREATION FUNCTIONS     //
	 //                             //
	//*****************************//


	// Add new rack to database
	function create_rack($rack_id, $address, $lat, $lon, $rack_count) {

		$data = array(
			'rack_id' => $rack_id,
			'address' => $address,
			'lat' => $lat,
			'lon' => $lon,
			'rack_count' => $rack_count
		);

		return ($this->db->insert('racks', $data));
	}

		//*****************************//
	   //                             //
	  //      EDITING FUNCTIONS      //
	 //                             //
	//*****************************//

	function edit_rack($rack_id) {

		// Update database with new info
		$data = array(
			'address' => $address,
			'lat' => $lat,
			'lon' => $lon,
			'rack_count' => $rack_count
		);

		$this->db->where('rack_id', $rack_id);
		return ($this->db->update('racks', $data));
	}

		//*****************************//
	   //                             //
	  //     RETRIEVAL FUNCTIONS     //
	 //                             //
	//*****************************//
	
	  ///////////////////////
	 // GENERAL FUNCTIONS //
	///////////////////////

	function get_all_racks() {
		$query = $this->db->get('racks');

		return $query;
	}
	
	  /////////////////////////////
	 // RACK SPECIFIC FUNCTIONS //
	/////////////////////////////

	// Get info for an individual rack
	function get_rack_info($rack_id) {
		// Get rack row (there should only be one)
		$this->db->where('rack_id', $rack_id);
		$row = $this->db->get('racks');

		if ($row) {
			$row = $row->row();
			return array(
				'rack_id' => $row->rack_id,
				'address' => $row->address,
				'lat' => $row->lat,
				'lon' => $row->lon,
				'rack_count' => $row->rack_count
			);
		}
	}

		//*****************************//
	   //                             //
	  //       CHECK FUNCTIONS       //
	 //                             //
	//*****************************//

	// Check if valid rack
	function rack_check($rack_id) {
		$this->db->where('rack_id', $rack_id)->from('racks');
		if ($this->db->count_all_results() == 1)
			return true;
		else
			return false;
	}

		//*****************************//
	   //                             //
	  //      DELETION FUNCTIONS     //
	 //                             //
	//*****************************//

	function delete_rack($rack_id) {
		return ($this->db->delete('racks', array('rack_id' => $rack_id)));
	}
}

/* End of file rack_model.php */
/* Location: ./application/models/rack_model.php */