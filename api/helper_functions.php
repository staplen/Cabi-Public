<?php

// Get and parse CaBi XML station data
function getStationData($json = false) {
	global $config;

	$stations = array();
	$xml = new fXML($config['system_url']);

	foreach ($xml->xpath("//station") as $station) {
		if ($json) {
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
		else {
			$stations[$station->id] = $station;
		}
	}

	return $stations;
}

function getRawStationData() {
	$xml = file_get_contents('http://www.capitalbikeshare.com/data/stations/bikeStations.xml');
	return $xml;
}

?>