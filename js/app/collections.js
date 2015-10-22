window.cabiApp.StationCollection = Backbone.Collection.extend({
	model: window.cabiApp.Station,

	url: '/api/src/latest-station-data.json',

	order: 'distance',

	parse: function(response) {
		var i = 0;
		_.each(response, function(){
			window.cabiApp.stations.add(response[i]);
			i++;
		});
	},

	comparator: function(station) {
		if (this.order === 'name') {
            return station.get('name');
        } else {
            return station.get('distance');
        }
	}
});