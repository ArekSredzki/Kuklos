var map;
jQuery(document).ready(function(){

    map = new GMaps({
        div: '#map',
        lat: 49.281161,
        lng:  -123.121322,
    });
    map.addMarker({
        lat: 49.281161,
        lng:  -123.121322,
        title: 'Address',      
        infoWindow: {
            content: '<h5 class="title">Bike Rack</h5><p><span class="region">Address line goes here</span><br><span class="rack_count">Number of racks</span></p>'
        }
        
    });

});