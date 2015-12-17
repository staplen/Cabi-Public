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
require_once (CONFIG_DIR . DS . 'config_private.php');
require_once (CONFIG_DIR . DS . 'autoload.php');
require_once (CONFIG_DIR . DS . 'environment.php');
require_once (CONFIG_DIR . DS . 'locale.php');


/* Get queries
------------------------------------------------------------------*/
$page         = strtolower(fRequest::get('page') ?      fRequest::get('page')     : FALSE);
$query        = strtolower(fRequest::get('query') ?     fRequest::get('query')    : FALSE);
$subquery     = strtolower(fRequest::get('subquery') ?  fRequest::get('subquery') : FALSE);

require_once ('helper_functions.php');



if ($page == 'latestjson') {
  require_once('update_data.php');
  exit;
}
else if ($page == 'latestxml') {
  require_once('raw_xml.php');
  exit;
}
else if ($page == 'data') {
	require_once('get_data.php');
	exit;
}
else if ($page == 'wmata') {
	require_once('wmata.php');
	exit;
}
else {
  http_response_code(403);
  exit;
}