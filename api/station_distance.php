<?php

$userLat = fRequest::get('lat');
$userLon = fRequest::get('lon');

$orderedStations = orderStations(getStationData(),$userLat,$userLon,$json);

echo $orderedStations;

?>