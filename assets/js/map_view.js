$(document).ready(function() {

    function lookup_location() {
        geoPosition.getCurrentPosition(show_pos, show_pos_error);
    }

    function show_pos(loc) {
        window.location.replace("http://kuklos.vikom.io/?lat="+loc.coords.latitude+"&lon="+loc.coords.longitude);
    }

    function show_pos_error() {
        alert('Unable to determine your location.');
    }

});