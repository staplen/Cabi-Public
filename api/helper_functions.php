<?php

function getWmataData($service,$station = 'All') {
	global $config;
	$url = '';

	switch ($service) {
		case 'stations':
			$url = "https://api.wmata.com/Rail.svc/json/jStations";
			break;
		case 'arrivals':
			$url = "https://api.wmata.com/StationPrediction.svc/json/GetPrediction/$station";
			break;
	}

	$curl = curl_init();
	curl_setopt_array($curl, array(
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => $url,
	    CURLOPT_HTTPHEADER => array('api_key: ' . $config['wmata_api_key'])
	));
	$resp = curl_exec($curl);
	if(!$resp){
		// die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
	}
	curl_close($curl);
	return fJSON::decode($resp);
}


// Get and parse XML and JSON station data
function getStationData($system_id) {
	global $config;

	$stations = array();

	if ($config['systems'][$system_id]['type'] === 'bikeshare') {
		if ($config['systems'][$system_id]['data_format'] === 'xml') {
			$xml = new fXML($config['systems'][$system_id]['data_url']);

			foreach ($xml->xpath("//station") as $station) {
				array_push($stations, [
					'id' 				 => $station->id,
					'type' 				 => 'bikeshare',
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
					'type' 				    => 'bikeshare',
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
		else if ($config['systems'][$system_id]['data_format'] === 'json3') {
			$json_data = fJSON::decode(file_get_contents($config['systems'][$system_id]['data_url']));

			foreach ($json_data->features as $station) {
				array_push($stations, [
					'id' 				    => $station->properties->kioskId,
					'type' 				    => 'bikeshare',
					'name' 				    => $station->properties->name,
					'terminalName' 		    => null,
					'lastCommWithServer'    => null,
					'lat' 				    => $station->geometry->coordinates[1],
					'long' 				    => $station->geometry->coordinates[0],
					'installed' 		    => null,
					'locked' 			    => $station->properties->kioskPublicStatus === 'Active' ? false : true,
					'installDate' 		    => null,
					'removalDate' 		    => null,
					'temporary' 		    => false,
					'public' 			    => true,
					'nbBikes' 			    => $station->properties->bikesAvailable,
					'nbEmptyDocks' 		    => $station->properties->docksAvailable,
					'latestUpdateTime'      => null,
					'lastCommunicationTime' => null
				]);
			}
		}
	}
	else if ($config['systems'][$system_id]['type'] === 'subway') {
		$station_list = getWmataData('stations');

			foreach ($station_list->Stations as $station) {
				$station_arrivals = getWmataData('arrivals',$station->Code);

				array_push($stations, [
					'id' 				    => $station->Code,
					'type' 				    => 'subway',
					'name' 				    => $station->Name,
					'lat' 				    => $station->Lat,
					'long' 				    => $station->Lon,
					'pairedStation'			=> $station->StationTogether1,
					'latestUpdateTime'      => time()*1000,
					'line'					=> $station->LineCode1,
					'trains'				=> $station_arrivals->Trains
				]);
			}
	}

	return $stations;
}

?>