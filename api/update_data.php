<?php

// Create systems data JSON
$systems = array();
foreach ($config['systems'] as $system) {
	array_push($systems, [
		'id'			 => $system['id'],
		'location_name'  => $system['location_name'],
		'system_name'	 => $system['system_name'],
		'lat'            => $system['lat'],
		'lon'            => $system['lon'],
		'distance_units' => $system['distance_units'],
		'country'		 => $system['country']
	]);
}
$systems_file_js = SYSROOT . DS . 'data' . DS . 'systems.js';
$systems_file_json = SYSROOT . DS . 'data' . DS . 'systems.json';
file_put_contents($systems_file_js, "window.cabiApp.systemsData = ".fJSON::encode($systems).";", LOCK_EX);
file_put_contents($systems_file_json, fJSON::encode($systems), LOCK_EX);

// Create station data JSON for each system
foreach ($config['systems'] as $key => $value) {

	$stationData = getStationData($key);

	$json = SYSROOT . DS . 'data' . DS . $key . DS . 'stations.json';
	file_put_contents($json, fJSON::encode($stationData), LOCK_EX);

	echo $value['location_name'] . " data successfully updated.\n";

}

?>