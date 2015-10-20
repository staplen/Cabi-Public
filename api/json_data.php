<?php

$stationData = getStationData(true);
$file = SYSROOT . DS . 'json' . DS . 'latest-station-data.json';
file_put_contents($file, fJSON::encode($stationData), LOCK_EX);

echo 'JSON file successfully updated.';

?>