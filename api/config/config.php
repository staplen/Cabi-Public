<?php 
/**
 * App Configuration
 * 
 * Defines main app settings and calls various
 * other system configuration files.
 * 
 * @package     Cabi API
 * @author      Nico Staple <nico@getmighty.com>
 *
 */


/* system/app config 
------------------------------------------------------------------*/
$config = array();
$config['timezone']     =   'America/New_York';
$config['locale']       =   'en-US';
$config['environment']  =   'dev';

$config['systems'] = array(

	'dca' => array(
		'id'			 => 'dca',
		'data_url'       => 'http://www.capitalbikeshare.com/data/stations/bikeStations.xml',
		'location_name'  => 'Washington, DC',
		'system_name'	 => 'Capital Bikeshare',
		'data_format'    => 'xml',
		'lat'            => 38.907192,
		'lon'            => -77.036871,
		'distance_units' => 'mi',
		'country'		 => 'USA'
	),

	'msp' => array(
		'id'			 => 'msp',
		'data_url'       => 'https://secure.niceridemn.org/data2/bikeStations.xml',
		'location_name'  => 'Minneapolis',
		'system_name'	 => 'Nice Ride',
		'data_format'    => 'xml',
		'lat'            => 44.977753,
		'lon'            => -93.265011,
		'distance_units' => 'mi',
		'country'		 => 'USA'
	),

	'yyz' => array(
		'id'			 => 'yyz',
		'data_url'       => 'http://www.bikesharetoronto.com/data/stations/bikeStations.xml',
		'location_name'  => 'Toronto',
		'system_name'	 => 'Bike Share Toronto',
		'data_format'    => 'xml',
		'lat'            => 43.653226,
		'lon'            => -79.383184,
		'distance_units' => 'km',
		'country'		 => 'Canada'
	),

	'yul' => array(
		'id'			 => 'yul',
		'data_url'       => 'http://montreal.bixi.com/data/bikeStations.xml',
		'location_name'  => 'Montreal',
		'system_name'	 => 'BIXI',
		'data_format'    => 'xml',
		'lat'            => 45.501689,
		'lon'            => -73.567256,
		'distance_units' => 'km',
		'country'		 => 'Canada'
	),

	'bos' => array(
		'id'			 => 'bos',
		'data_url'       => 'http://thehubway.com/data/stations/bikeStations.xml',
		'location_name'  => 'Boston',
		'system_name'	 => 'Hubway',
		'data_format'    => 'xml',
		'lat'            => 42.360082,
		'lon'            => -71.058880,
		'distance_units' => 'mi',
		'country'		 => 'USA'
	),

	'lhr' => array(
		'id'			 => 'lhr',
		'data_url'       => 'http://www.tfl.gov.uk/tfl/syndication/feeds/cycle-hire/livecyclehireupdates.xml',
		'location_name'  => 'London',
		'system_name'	 => 'Santander Cycles',
		'data_format'    => 'xml',
		'lat'            => 51.507351,
		'lon'            => -0.127758,
		'distance_units' => 'mi',
		'country'		 => 'UK'
	),

	'jfk' => array(
		'id'			 => 'jfk',
		'data_url'       => 'http://www.citibikenyc.com/stations/json',
		'location_name'  => 'New York City',
		'system_name'	 => 'Citi Bike',
		'data_format'    => 'json',
		'lat'            => 40.712784,
		'lon'            => -74.005941,
		'distance_units' => 'mi',
		'country'		 => 'USA',
		'timezone'		 => 'America/New_York'
	),

	'ord' => array(
		'id'			 => 'ord',
		'data_url'       => 'http://www.divvybikes.com/stations/json',
		'location_name'  => 'Chicago',
		'system_name'	 => 'Divvy',
		'data_format'    => 'json',
		'lat'            => 41.878114,
		'lon'            => -87.629798,
		'distance_units' => 'mi',
		'country'		 => 'USA',
		'timezone'		 => 'America/Chicago'
	),

	// 'mel' => array(
	// 	'id'			 => 'mel',
	// 	'data_url'       => 'http://www.melbournebikeshare.com.au/stationmap/data',
	// 	'location_name'  => 'Melbourne',
	// 	'system_name'	 => 'Melbourne Bike Share',
	// 	'data_format'    => 'json2',
	// 	'lat'            => -37.817466,
	// 	'lon'            => 144.971681,
	// 	'distance_units' => 'km',
	// 	'country'		 => 'Australia',
	// 	'timezone'		 => 'Australia/Melbourne'
	// ),

	'sfo' => array(
		'id'			 => 'sfo',
		'data_url'       => 'http://www.bayareabikeshare.com/stations/json',
		'location_name'  => 'San Francisco',
		'system_name'	 => 'Bay Area Bike Share',
		'data_format'    => 'json',
		'lat'            => 37.774929,
		'lon'            => -122.419416,
		'distance_units' => 'mi',
		'country'		 => 'USA',
		'timezone'		 => 'America/Los_Angeles'
	),

	'phl' => array(
		'id'			 => 'phl',
		'data_url'       => 'https://api.phila.gov/bike-share-stations/v1',
		'location_name'  => 'Philadelphia',
		'system_name'	 => 'Indego',
		'data_format'    => 'json3',
		'lat'            => 39.952584,
		'lon'            => -75.165222,
		'distance_units' => 'mi',
		'country'		 => 'USA',
		'timezone'		 => 'America/New_York'
	),

);