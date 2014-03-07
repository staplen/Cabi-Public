<?php

$userLat = fRequest::get('lat');
$userLon = fRequest::get('lon');

$closestCounter = closestCounter(getStationData(),$userLat,$userLon);

// echo fJSON::encode($closestCounter);
echo $closestCounter;

?>