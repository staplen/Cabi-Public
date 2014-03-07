<?php

$stationData = getStationData(true);
$statement = $cabi_db->prepare("INSERT INTO cabi_historic_data (station_id, nbBikes, nbEmptyDocks, station_time) VALUES (%i, %i, %i, %p)");

foreach ($stationData as $station) {
	$station_id = $station['id'];
	$nbBikes = $station['nbBikes'];
	$nbEmptyDocks = $station['nbEmptyDocks'];
	$station_time = date("Y-m-d H:i:s", substr($station['lastCommWithServer'], 0, 10));

	$cabi_db->query($statement, $station_id, $nbBikes, $nbEmptyDocks, $station_time);

	// $cabi_db->execute("INSERT INTO `cabi_historic_data` (`station_id`, `nbBikes`, `nbEmptyDocks`, `station_time`) VALUES ($station_id, $nbBikes, $nbEmptyDocks, '$station_time');");
}

?>