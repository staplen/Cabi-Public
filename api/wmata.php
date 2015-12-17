<?php

$service = $query;
$url = '';

switch ($service) {
	case 'stations':
		$url = "https://api.wmata.com/Rail.svc/json/jStations";
		break;
	case 'arrivals':
		$station = $subquery ? $subquery : 'All';
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
	die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
}
curl_close($curl);

header("Cache-Control: no-cache, must-revalidate");
header('Content-Type: application/json');
echo($resp);

?>