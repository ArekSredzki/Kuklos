$(document).ready(function() {

    function lookup_location() {
        if (geoPosition.init()) {
            geoPosition.getCurrentPosition(show_pos, show_pos_error);
        }
    }

    function show_pos(loc) {
        var marker_icon = new google.maps.MarkerImage('http://kuklos.vikom.io/assets/images/noun_project/bicycle.svg', null, null, null, new google.maps.Size(64,37.64));  
        var markerOptions = {
            map: map,
            position: new google.maps.LatLng(loc.coords.latitude, loc.coords.longitude),
            icon: marker_icon,
            title: "My Position"        
        };
        myLocation = createMarker_map(markerOptions);
    }

    function show_pos_error() {
        alert('Unable to determine your location.');
    }

    lookup_location();

});