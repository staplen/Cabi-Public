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
	else if ($config['systems'][$system_id]['type'] === 'subway' && $config['systems'][$system_id]['id'] === 'wmata') {
		$arrivals_by_station = array();
		$station_list = getWmataData('stations');
		$station_arrivals = getWmataData('arrivals');

		foreach ($station_list->Stations as $station) {
			$arrivals_by_station[$station->Code] = array();
		}

		// Special cleanup for WMATA "StationTogether1" aka transfer stations to combine these to one station in the feed
		foreach ($station_arrivals->Trains as $train) {
			if (array_key_exists($train->LocationCode, $arrivals_by_station)) {
				switch ($train->LocationCode) {
					case 'F01': // Gallery Pl.
						$station_id = 'B01';
						break;
					case 'F03': // L'Enfant Plaza
						$station_id = 'D03';
						break;
					case 'E06': // Fort Totten
						$station_id = 'B06';
						break;
					case 'C01': // Metro Center
						$station_id = 'A01';
						break;
					default:
						$station_id = $train->LocationCode;
						break;
				}
				if ($train->Destination === 'Train') {
					$train->DestinationName = 'Unknown';
				}
				if ($train->Min === 'ARR') {
					$train->Min = 'ARRIVING';
				}
				if ($train->Min === 'BRD') {
					$train->Min = 'BOARDING';
				}
				if ($train->Line === '--') {
					$train->Line = 'NA';
				}
				array_push($arrivals_by_station[$station_id],$train);
			}
		}

		foreach ($station_list->Stations as $station) {
			if ($station->Code !== 'F01' && $station->Code !== 'F03' && $station->Code !== 'E06' && $station->Code !== 'C01') {
				array_push($stations, [
					'id' 				    => $station->Code,
					'type' 				    => 'subway',
					'name' 				    => $station->Name,
					'lat' 				    => $station->Lat,
					'long' 				    => $station->Lon,
					'pairedStation'			=> $station->StationTogether1,
					'latestUpdateTime'      => time()*1000,
					'line'					=> $station->LineCode1,
					'trains'				=> $arrivals_by_station[$station->Code]
				]);
			}
		}
	}

	return $stations;
}

?>