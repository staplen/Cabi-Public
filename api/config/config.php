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

$config['system_url']   =   'http://www.capitalbikeshare.com/data/stations/bikeStations.xml'; /* DC */
// $config['system_url']   =   'https://secure.niceridemn.org/data2/bikeStations.xml'; /* MSP */
// $config['system_url']   =   'http://www.bikesharetoronto.com/data/stations/bikeStations.xml'; /* Toronto */
// $config['system_url']   =   'http://montreal.bixi.com/data/bikeStations.xml'; /* Montreal */
// $config['system_url']   =   ''; /* Ottawa */
// $config['system_url']   =   'http://thehubway.com/data/stations/bikeStations.xml'; /* Boston */
// $config['system_url']   =   'http://www.tfl.gov.uk/tfl/syndication/feeds/cycle-hire/livecyclehireupdates.xml'; /* London */