	function lookup_location() {
		if (geoPosition.init()) {
			geoPosition.getCurrentPosition(update_pos, function(){});
		}
	}

	function update_pos(loc) {
		var redirect = 'http://kuklos.vikom.io/';
		$.redirectPost(redirect, {lat: loc.coords.latitude, lon: loc.coords.longitude});
	}

	// jquery extend function
	$.extend(
	{
	    redirectPost: function(location, args)
	    {
	        var form = '';
	        $.each( args, function( key, value ) {
	            form += '<input type="hidden" name="'+key+'" value="'+value+'">';
	        });
	        $('<form action="'+location+'" method="POST">'+form+'</form>').appendTo('body').submit();
	    }
	});


$(document).ready(function() {

	var southWest = new google.maps.LatLng( 49.0, -123.3 );
	var northEast = new google.maps.LatLng( 49.5, -122.9 );
	var vancouverBounds = new google.maps.LatLngBounds( southWest, northEast );

	var placesAutocomplete;
	var autocompleteOptions = {bounds: vancouverBounds}
	var autocompleteInput = document.getElementById('search-form-input');
	
	placesAutocomplete = new google.maps.places.Autocomplete(autocompleteInput, autocompleteOptions);
	google.maps.event.addListener(placesAutocomplete, 'place_changed', function() {
		document.getElementById("search-form-input").value = placesAutocomplete.getPlace().formatted_address;
		document.getElementById("search-form").submit();
	});

	if (gotPosition) {
	    $('#rack-table').dataTable( {
	        "order": [[ 1, "asc" ]],
	    } );
	} else {
	    $('#rack-table').dataTable( {
	        "order": [[ 1, "desc" ]],
	    } );
	    lookup_location();
	};

} );