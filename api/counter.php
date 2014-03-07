<div class="row-fluid num-container<?php echo $bikeClass; ?>" id="num-bikes">
  <div class="span12">
    <p><?php echo($stationData->nbBikes); ?> <img src="/assets/img/bike.svg" alt="" /></p>
  </div>
</div>
<div class="row-fluid num-container<?php echo $dockClass; ?>" id="num-docks">
  <div class="span12">
    <p><?php echo($stationData->nbEmptyDocks); ?> <i class="icon-download"></i></p>
  </div>
</div>
<div class="station-banner">
	<p><?php echo($stationData->name); ?></p>
</div>