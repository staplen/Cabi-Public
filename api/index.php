<?php 



/* Set global directory / system root variables
------------------------------------------------------------------*/
define('DS',              DIRECTORY_SEPARATOR);
define('SYSROOT',         dirname(__FILE__));
define('LIB_DIR',         SYSROOT . DS . 'lib');
define('CONFIG_DIR',      SYSROOT . DS . 'config');
define('ASSETS_DIR',      SYSROOT . DS . 'assets');
define('SYSPATH',         SYSROOT);



/* Call config files
------------------------------------------------------------------*/
require_once (CONFIG_DIR . DS . 'config.php');
require_once (CONFIG_DIR . DS . 'autoload.php');
require_once (CONFIG_DIR . DS . 'environment.php');
require_once (CONFIG_DIR . DS . 'locale.php');
define('URL_ROOT',        $config['site_url']);


/* Connect to the database
------------------------------------------------------------------*/
$cabi_db  = new fDatabase($config['db_type'], $config['db_name'], $config['db_user'], $config['db_pass'], $config['db_url']);

/* Start the session
------------------------------------------------------------------*/
fSession::setPath(SYSROOT . DS . 'tmp' . DS . 'sessions');
fSession::open();



/* Get queries
------------------------------------------------------------------*/
$page         = strtolower(fRequest::get('page') ?      fRequest::get('page')     : 'stations');
$query        = strtolower(fRequest::get('query') ?     fRequest::get('query')    : FALSE);
$subquery     = strtolower(fRequest::get('subquery') ?  fRequest::get('subquery') : FALSE);

require_once ('helper_functions.php');

if ($page == 'sha256') {
  require_once('sha256-hasher.php');
  exit;
}
if ($page == 'stationdistance') {
  require_once('station_distance.php');
  exit;
}
if ($page == 'closestcounter') {
  require_once('closest_counter.php');
  exit;
}
if ($page == 'latestxml') {
  require_once('raw_xml.php');
  exit;
}
if ($page == 'latestjson') {
  require_once('json_data.php');
  exit;
}
if ($page == 'datacron') {
  require_once('data_cron.php');
  exit;
}
if ($page == 'historicstation') {
  require_once('historic_station.php');
  exit;
}
if ($page == 'stationaverages') {
  require_once('station_averages.php');
  exit;
}

$stationData = false;



if (is_numeric($query)) {
  /* Query CaBi and set station specific data from given id ($query) 
  --------------------------------------------------------------------------*/
  $stationData = getStationData()[$query];

  /* Set bike/dock quantity variables 
  -----------------------------------------------------------*/
  $bikeClass = '';
  $dockClass = '';

  if ($stationData->nbBikes <= 3) {
    $bikeClass = ' low';
    if ($stationData->nbBikes == 0) {
      $bikeClass = ' empty';
    }
  }

  if ($stationData->nbEmptyDocks <= 3) {
    $dockClass = ' low';
    if ($stationData->nbEmptyDocks == 0) {
      $dockClass = ' empty';
    }
  }
}
else if (!$query) {
  /* Query CaBi for current station list
  --------------------------------------------------------------------------*/
  $stationList = getStationData();
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php if ($query && $stationData) {echo $stationData->name;}else{echo 'Cabi - Station List';} ?></title>
  <link rel="shortcut icon" href="<?php echo $config['site_url']; ?>/assets/img/favicon.ico" />
  <link rel="apple-touch-icon" href="<?php echo $config['site_url']; ?>/assets/img/ios/icon.png" />
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $config['site_url']; ?>/assets/img/ios/icon-72.png" />
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $config['site_url']; ?>/assets/img/ios/icon@2x.png" />
  <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $config['site_url']; ?>/assets/img/ios/icon-72@2x.png" />

	<!-- Stylesheets -->
	<link href="<?php echo $config['site_url']; ?>/assets/css/lib/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $config['site_url']; ?>/assets/css/lib/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="<?php echo $config['site_url']; ?>/assets/css/lib/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo $config['site_url']; ?>/assets/css/style.css" rel="stylesheet">
	
	<!-- Javascript that needs to be in the head -->
	<?php /* <script src="<?php echo $config['site_url']; ?>/assets/js/lib/modernizr-2.6.2.min.js"></script> */ ?>
	<?php /* <script src="<?php echo $config['site_url']; ?>/assets/js/lib/responsive-safari-fix.js"></script> */ ?>
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-28679304-1']);
    _gaq.push(['_setDomainName', 'nicostaple.com']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
</head>

<body>

  <div id="wrapper">
    <div id="loading">
      <img src="<?php echo $config['site_url']; ?>/assets/img/ajax-loader.gif" alt="Loading..." height="32" width="32" />
    </div>
    <div id="geolocation-error">
      <h1>There was an error determining your location. Please make sure location services are enabled and you've allowed Cabi to use your location information. <a href="/stations">Return to station list &rarr;</a></h1>
    </div>
    <div id="content">
      <?php if (is_numeric($query)) {
        require_once('counter.php');
      }
      else if (!$query) {
        require_once('station_list.php');
      } ?>
    </div>
  </div><!-- END #wrapper -->

	<!-- Javascript -->
	<script src="<?php echo $config['site_url']; ?>/assets/js/lib/jquery-1.9.1.min.js"></script>
	<?php /* <script src="<?php echo $config['site_url']; ?>/assets/js/lib/bootstrap.min.js"></script> */ ?>

  <?php if ($page == 'stations' && !$query) { ?>
    <script src="<?php echo $config['site_url']; ?>/assets/js/station_list.js"></script>
  <?php } ?>
  <?php if ($page == 'stations' && $query) { ?>
    <script>
      $(function() {
        $('#loading').hide();
        $('#content').show();
      });
    </script>
  <?php } ?>
  <?php if ($page == 'stations' && $query == 'closest') { ?>
    <script src="<?php echo $config['site_url']; ?>/assets/js/closest_counter.js"></script>
  <?php } ?>

  <script>
    $(window).load(function() {

      function setWrapperHeight() {
        var height = $(window).height();
        $('#content').height(height);
      }
      function setBannerWidth() {
        var width = $(window).width();
        $('.station-banner').width(width);
      }

      $(window).resize(function() {
        setWrapperHeight();
        setBannerWidth()
      });

      setWrapperHeight();
      setBannerWidth();

    });
  </script>

</body>
</html>