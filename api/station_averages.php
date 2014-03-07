<?php

$station_id = intval($query);

$time = $subquery ? $subquery : time();

$averages = getHistoricData($station_id, $time, true);

$data = array(
	'station_id' => $station_id,
	'time' => $time,
	'avgBikes' => $averages['avgBikes'],
	'avgDocks' => $averages['avgDocks'],
	'weekday' => $averages['weekday']
);

echo fJSON::encode($data);

?>