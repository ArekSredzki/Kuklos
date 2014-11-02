$(document).ready(function() {
	
	function lookup_location() {
		geoPosition.getCurrentPosition(update_pos);
	}

	function update_pos(loc) {
		window.location.replace("http://kuklos.vikom.io/?lat="+loc.coords.latitude+"&lon="+loc.coords.longitude);
	}

	var southWest = new google.maps.LatLng( 49.119610, -123.326877 );
	var northEast = new google.maps.LatLng( 49.381364, -122.848972 );
	var vancouverBounds = new google.maps.LatLngBounds( southWest, northEast );

	var placesAutocomplete;
	var autocompleteOptions = {bounds: vancouverBounds}
	var autocompleteInput = document.getElementById('search-form-input');
	
	placesAutocomplete = new google.maps.places.Autocomplete(autocompleteInput, autocompleteOptions);
	google.maps.event.addListener(placesAutocomplete, 'place_changed', function() {
		document.getElementById("search-form").submit();
	});

    $('#map-table').dataTable( {
        "order": [[ 2, "desc" ]]
    } );

} );