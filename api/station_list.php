<ul id="station-list">
	<?php foreach ($stationList as $station) { ?>
		<li class="station-item">
			<a href="/api/stations/<?php echo $station->id; ?>">
				<?php echo $station->name; ?> <i class="icon-circle-arrow-right"></i>
			</a>
		</li>
	<?php } ?>
</ul>