<?php

/*
Usage:
	$location_one = array('latitude' => '50.010083','longitude' => '-110.113006');
	$location_two = array('latitude' => '-21.805149','longitude' => '-49.089977');
	print_r(distance_by_haversine($location_one, $location_two));
	
	returns:  Array ( [meters] => 9979048.23 [kilometers] => 9979.05 )

Inspiration: 
	http://en.wikipedia.org/wiki/Haversine_formula
	http://www.movable-type.co.uk/scripts/latlong.html
*/
function distance_by_haversine($location_one, $location_two) {

	if (!isset($location_one) || !isset($location_two)) { 
		return array('error' => 'locations must be arrays of coordinates');
	}
	
	if (!is_array($location_one) || !is_array($location_two)) { 
		return array('error' => 'locations must be arrays of coordinates');
	} else {
		if (!isset($location_one['latitude']) || !isset($location_two['latitude'])) { 
			return array('error' => 'locations must include latitude key');
		} 
		if (!isset($location_one['longitude']) || !isset($location_two['longitude'])) { 
			return array('error' => 'locations must include longitude key');
		}
	}
	
	$radius = 6371000; // The equilateral radius of Earth = 6,378,100 meters.  Average radius is 6,371,000 meters.
	$latitude_distance = deg2rad($location_two['latitude'] - $location_one['latitude']);
	$longitude_distance = deg2rad($location_two['longitude'] - $location_one['longitude']);
	$latitude_one_radius = deg2rad($location_one['latitude']);
	$latitude_two_radius = deg2rad($location_two['latitude']);
	
	$a = sin($latitude_distance/2) * sin($latitude_distance/2) + sin($longitude_distance/2) * sin($longitude_distance/2) * cos($latitude_one_radius) * cos($latitude_two_radius);
	$c = 2 * atan2(sqrt($a), sqrt(1-$a));
	$distance = $radius * $c;
	return array('meters' => round($distance,2), 'kilometers' => round($distance/1000, 2));
}
?>
