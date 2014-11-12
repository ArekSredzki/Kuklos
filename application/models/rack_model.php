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
	function create_rack($address, $lat, $lon, $rack_count) {

		$data = array(
			'address' => strtolower($address),
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

	// Requires lat and lon of other coordinate and bounding distance to filter by (# of degrees of max difference between given coord and entries)
	// Returns all the racks ordered by distance to the provided coordinate
	// Distance is in meters
	function get_racks_by_distance_query($lat, $lon, $bounding_distance = 1) {

		$this->db->select(array('address',
			'round(6371000 * acos( cos(radians('.$lat.')) * cos(radians(`lat`)) * cos(radians( `lon`) - radians('.$lon.')) + sin(radians('.$lat.')) * sin(radians(`lat`)))) AS `distance`',
			'rack_count'));

		$where = "(
		  `lat` BETWEEN (".$lat." - ".$bounding_distance.") AND (".$lat." + ".$bounding_distance.")
		  AND `lon` BETWEEN (".$lon." - ".$bounding_distance.") AND (".$lon." + ".$bounding_distance.")
		)";
		$this->db->from('racks')->where($where)->order_by('distance', 'asc');
		$query = $this->db->get();

		return $query;
	}

	// Returns a CI query result object containing the address and rack_count fields of all the racks
	function get_all_racks_basic_query() {
		$this->db->select(array('address', 'rack_count'));
		$query = $this->db->get('racks');

		return $query;
	}

	// Returns a CI query result object containing all the racks
	function get_all_racks_query() {
		$this->db->select(array('rack_id', 'address', 'lat', 'lon', 'rack_count'));
		$query = $this->db->get('racks');

		return $query;
	}

	// Returns an array containing all the racks
	function get_all_racks() {
		return $this->get_all_racks_query()->result_array();
	}

	/*
	// Returns an array containing all favourite racks
	function get_favourite_racks() {
		$this->db->select(array('rack_id', 'address', 'lat', 'lon', 'rack_count'));
		$where = "('favourite' == true)";
		$this->db->from('racks')->where($where);
		$query = $this->db->get();

		return $query;
	}
	*/
	
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
	
	// Get comments for a specific rack
	function get_comments($rack_id) {		
		$query = $this->db->get_where('comments', array('rack_id' => $rack_id));
		return $query->result_array();
	}
	
	// Add a comment for a specific rack
	function add_comment($rack_id) {
		$data = array(
			'email' => $this->session->userdata('email'),
			'rack_id' => $rack_id,
			'timestamp' => time(),
			'text' => $this->input->post('text')
		);
		return $this->db->insert('comments', $data);
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