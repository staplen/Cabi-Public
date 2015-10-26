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
	else if ($config['systems'][$system_id]['data_format'] === 'json') {
		$json_data = fJSON::decode(file_get_contents($config['systems'][$system_id]['data_url']));

		foreach ($json_data->stationBeanList as $station) {
			array_push($stations, [
				'id' 				    => $station->id,
				'name' 				    => $station->stationName,
				'terminalName' 		    => null,
				'lastCommWithServer'    => strtotime($station->lastCommunicationTime) * 1000,
				'lat' 				    => $station->latitude,
				'long' 				    => $station->longitude,
				'installed' 		    => $station->statusKey,
				'locked' 			    => $station->statusValue === 'In Service' ? false : true,
				'installDate' 		    => null,
				'removalDate' 		    => null,
				'temporary' 		    => false,
				'public' 			    => true,
				'nbBikes' 			    => $station->availableBikes,
				'nbEmptyDocks' 		    => $station->availableDocks,
				'latestUpdateTime'      => strtotime($station->lastCommunicationTime),
				'lastCommunicationTime' => $station->lastCommunicationTime
			]);
		}
	}

	return $stations;
}

?>