<?php

$observations = getHistoricData(intval($query));
echo fJSON::encode($observations);

?>