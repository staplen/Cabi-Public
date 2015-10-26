<?php

// Get and parse CaBi XML station data
function getStationData($system_id) {
	global $config;

	$stations = array();

	if ($config['systems'][$system_id]['data_format'] === 'xml') {
		$xml = new fXML($config['systems'][$system_id]['data_url']);

		foreach ($xml->xpath("//station") as $station) {
			array_push($stations, [
				'id' 				 => $station->id,
				'name' 				 => $station->name,
				'terminalName' 		 => $station->terminalName,
				'lastCommWithServer' => $station->lastCommWithServer,
				'lat' 				 => $station->lat,
				'long' 				 => $station->long,
				'installed' 		 => $station->installed,
				'locked' 			 => $station->locked,
				'installDate' 		 => $station->installDate,
				'removalDate' 		 => $station->removalDate,
				'temporary' 		 => $station->temporary,
				'public' 			 => $station->public,
				'nbBikes' 			 => $station->nbBikes,
				'nbEmptyDocks' 		 => $station->nbEmptyDocks,
				'latestUpdateTime'   => $station->latestUpdateTime,
			]);
		}
	}

	return $stations;
}

function getRawStationData() {
	$xml = file_get_contents('http://www.capitalbikeshare.com/data/stations/bikeStations.xml');
	return $xml;
}

?>