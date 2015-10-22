window.cabiApp.StationCollection = Backbone.Collection.extend({
	model: window.cabiApp.Station,

	url: '/api/src/latest-station-data.json',

	parse: function(response) {
		var i = 0;
		_.each(response, function(){
			window.cabiApp.stations.add(response[i]);
			i++;
		});
	},

	comparator: function(station) {
		return station.get("distance");
	}
});