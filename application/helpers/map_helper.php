<?php  if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');

function generate_map_rack_js($racks){
    $js = "";

    foreach ($racks as $rack) {
    	$js .= "
            map.addMarker({
                lat: ".$rack['lat'].",
                lng:  ".$rack['lon'].",
                title: '".$rack['address']."',      
                infoWindow: {
                    content: '<h5 class=\"title\">Bike Rack</h5><p><span class=\"region\">".$rack['address']."</span><br><span class=\"rack_count\">Number of racks: ".$rack['rack_count']."</span></p>'
                }
            });";
    }
    
    return $js;
}