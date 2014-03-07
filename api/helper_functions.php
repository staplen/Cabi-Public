<?php

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}

// Get and parse CaBi XML station data
function getStationData($json = false) {
	global $config;

	$stations = array();
	$xml = new fXML($config['system_url']);

	foreach ($xml->xpath("//station") as $station) {
		if ($json) {
			$averages = $config['environment'] == 'dev' ? getHistoricData($station->id,time(),true) : false;
			// $averages = getHistoricData($station->id,time(),true);
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
				'averages'			 => $averages
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

function orderStations($stations,$userLat,$userLon) {

	$stationsWithDistance = $stations;

	$userLocationAvailable = false;
	if ($userLat != 'null') {
		$userLocationAvailable = true;
	}

	if ($userLat != 'null') {
		foreach ($stations as $station) {
			$distance = distance($userLat, $userLon, $station->lat, $station->long, 'M');
			$stationsWithDistance[$station->id] = $distance;
		}

		asort($stationsWithDistance);
	}

	$stationListHtml = '<ul id="station-list">';
	$bikeSvg = file_get_contents('assets/img/bike.svg');

	foreach ($stationsWithDistance as $key => $value) {
		$bikeClass = '';
		$dockClass = '';
		if ($stations[$key]->nbBikes <= 3) {
			$bikeClass = ' bikes-low';
		    if ($stations[$key]->nbBikes == 0) {
				$bikeClass = ' bikes-empty';
		    }
		}
		if ($stations[$key]->nbEmptyDocks <= 3) {
			$dockClass = ' low';
		    if ($stations[$key]->nbEmptyDocks == 0) {
				$dockClass = ' empty';
		    }
		}
		if ($userLocationAvailable) {
			$roundedValue = round($value, 2);
		}
		$stationListHtml .= 
			'<li class="station-item'.$bikeClass.'">'.
				'<a href="/api/stations/'.$key.'">'.
					$stations[$key]->name.' '. $bikeSvg .' <i class="icon-download'.$dockClass.'"></i>'.
				'</a>'.
			'</li>';
	}

	$stationListHtml .= '</ul>';

	return $stationListHtml;

}

function closestCounter($stations,$userLat,$userLon) {

	$stationsWithDistance = $stations;

	foreach ($stations as $station) {
		$distance = distance($userLat, $userLon, $station->lat, $station->long, 'M');
		$stationsWithDistance[$station->id] = $distance;
	}

	asort($stationsWithDistance);

	$stationData = $stations[key($stationsWithDistance)];

	$green = '#92EC00';
	$yellow = '#FF7C00';
	$red = '#FF1800';

	$bikeColor = $green;
	$dockColor = $green;
	if ($stationData->nbBikes <= 3) {
		$bikeColor = $yellow;
	    if ($stationData->nbBikes == 0) {
			$bikeColor = $red;
	    }
	}
	if ($stationData->nbEmptyDocks <= 3) {
		$dockColor = $yellow;
	    if ($stationData->nbEmptyDocks == 0) {
			$dockColor = $red;
	    }
	}


	$glassHtml = 
		'<div class="layout-two-column" style="color:#000;">'.
		  '<div class="align-center" style="background-color:'.$bikeColor.'; padding-top:20px;">'.
		    '<img src="http://cabi.nicostaple.com/img/bike.png" />'.
		    '<p class="text-x-large">'.$stationData->nbBikes.'</p>'.
		  '</div>'.
		  '<div class="align-center" style="background-color:'.$dockColor.'; padding-top:27px;">'.
		    '<img src="http://cabi.nicostaple.com/img/dock.png" />'.
		    '<p class="text-x-large" style="padding-top:13px">'.$stationData->nbEmptyDocks.'</p>'.
		  '</div>'.
		'</div>'.
		'<footer>'.
		  '<span style="background:rgba(0,0,0,0.6); padding:10px; color:#fff;">'.$stationData->name.'</span>'.
		'</footer>'
	;

	// $closestCounterHtml =
	// 	'<div class="row-fluid num-container'.$bikeClass.'" id="num-bikes">'.
	// 	  '<div class="span12">'.
	// 	    '<p>'.$stationData->nbBikes.' <img src="/api/assets/img/bike.svg" alt="" /></p>'.
	// 	  '</div>'.
	// 	'</div>'.
	// 	'<div class="row-fluid num-container'.$dockClass.'" id="num-docks">'.
	// 	  '<div class="span12">'.
	// 	    '<p>'.$stationData->nbEmptyDocks.' <i class="icon-download"></i></p>'.
	// 	  '</div>'.
	// 	'</div>';

	// $stationBannerHtml =
	// 	'<div class="station-banner">'.
	// 		'<p>'.$stationData->name.'</p>'.
	// 	'</div>';

	// $counterHtml = [];
	// $counterHtml[0] = $closestCounterHtml;
	// $counterHtml[1] = $stationBannerHtml;
	// $counterHtml[2] = $stationData->name;

	return $glassHtml;

}

function getHistoricData($station_id, $time = false, $averages = false) {
	global $cabi_db;

	$time 			= $time ? $time : time();
	$formatted_time = date("H:i:s", $time);
	$start_time     = date('H:i:s', strtotime($formatted_time . ' -15 minutes'));
	$end_time 		= date('H:i:s', strtotime($formatted_time . ' +15 minutes'));
	$weekday 		= date("l", $time);

	try {
		// search database for observations around $time for $station_id
		$historic_data = $cabi_db->query("SELECT * FROM `cabi_historic_data` WHERE (station_id = $station_id) AND (DATE_FORMAT(`server_time`, '%H:%i:%s') BETWEEN '$start_time' AND '$end_time') AND (DAYNAME(server_time) = '$weekday');");
		$historic_data->tossIfNoRows();

		foreach ($historic_data as $observation) {
			$observations[] = $observation;
		}

		if ($averages) {
			return calculateHistoricAverages($observations,$time,$weekday);
		}
		else {
			return($observations);
		}
	} catch (fNoRowsException $e) {
	    return false;
	}
}

function calculateHistoricAverages($observations,$time,$weekday) {
	$totalBikes = 0;
	$totalDocks = 0;
	$totalObservations = count($observations);
	// iterate through results to generate avg bikes and docks
	foreach ($observations as $observation) {
		$totalBikes += $observation['nbBikes'];
		$totalDocks += $observation['nbEmptyDocks'];
	}
	$avgBikes = round($totalBikes / $totalObservations);
	$avgDocks = round($totalDocks / $totalObservations);
	return array (
		'avgBikes'   => $avgBikes,
		'avgDocks'   => $avgDocks,
		'time'       => $time,
		'prettyTime' => date("g:iA"),
		'weekday'    => $weekday
	);
}


?>