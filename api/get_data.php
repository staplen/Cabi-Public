<?php

$format = $query ? $query : 'json';
$file = $file = SYSROOT . DS . 'src' . DS . 'latest-station-data.' . $format;

switch ($format) {
    case 'json':
        $content_type = "Content-Type: application/json";
        break;
    case 'js':
        $content_type = "Content-Type: text/javascript";
        break;
    default:
        $content_type = "Content-Type: application/json";
        break;
}

header("Cache-Control: no-cache, must-revalidate");
header($content_type);
echo file_get_contents($file);


?>