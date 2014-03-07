window.cabiApp.utils = {

	renderInitialPage: function() {
		if (navigator.geolocation) {
		  var timeoutVal = 10 * 1000 * 1000;
		  navigator.geolocation.getCurrentPosition(
		    this.geolocationSuccess, 
		    this.geolocationError,
		    { enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 120000 }
		  );
		}
		else {
			window.cabiApp.stationListView = new window.cabiApp.StationListView({collection: window.cabiApp.stations});
			window.cabiApp.cabiRouter = new window.cabiApp.CabiRouter();
			Backbone.history.start({pushState: false});
			$('#loading').hide();
		}	
	},

	geolocationError: function(error) {
		var errors = { 
			1: 'Permission denied',
			2: 'Position unavailable',
			3: 'Request timeout'
		};
		console.log("Error: " + errors[error.code]);
		$('#loading').hide();
		$('#content,#geolocation-error').show();
	},

	geolocationSuccess: function(position) {
		var completeRender = _.after(window.cabiApp.stations.length, function () {
	        window.cabiApp.stationListView = new window.cabiApp.StationListView({collection: window.cabiApp.stations});
			window.cabiApp.cabiRouter = new window.cabiApp.CabiRouter();
			Backbone.history.start({pushState: false});
			$('#loading').hide();
	    });

		window.cabiApp.stations.each(function(station,key,list){
			var lat2 = station.get('lat');
			var lon2 = station.get('long');
			station.set('distance',window.cabiApp.utils.calculateDistance(position.coords.latitude, position.coords.longitude, lat2, lon2));
			completeRender();
		});
	},

	calculateDistance: function(lat1, lon1, lat2, lon2) {
		function deg2rad (angle) {
		  return angle * (Math.PI / 180);
		}
		function rad2deg (angle) {
		  return angle * (180 / Math.PI);
		}

		var theta = lon1 - lon2;
		var dist = Math.sin(deg2rad(lat1)) * Math.sin(deg2rad(lat2)) + Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * Math.cos(deg2rad(theta));
		var dist = Math.acos(dist);
		var dist = rad2deg(dist);
		var miles = dist * 60 * 1.1515;

		return miles;
	}
}