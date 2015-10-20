<?php

$stationData = getStationData(true);

$file = SYSROOT . DS . 'json' . DS . 'latest-station-data.json';
file_put_contents($file, fJSON::encode($stationData), LOCK_EX);

$file = SYSROOT . DS . 'json' . DS . 'latest-station-data.js';
file_put_contents($file, "window.cabiApp.latestData = ".fJSON::encode($stationData).";", LOCK_EX);

echo 'JSON file successfully updated.';

?>