window.cabiApp.StationCollection = Backbone.Collection.extend({
	model: window.cabiApp.Station,

	url: function() {
		return '/api/data/' + window.cabiApp.settings.activeSystemId + '/stations.json'
	},

	order: 'distance',

	comparator: function(station) {
		if (this.order === 'name') {
            return station.get('name');
        } else {
            return station.get('distance');
        }
	},

	initialize: function() {
		this.on("reset", function() {
			window.cabiApp.utils.updateStationDistances();
		});
	}
});


window.cabiApp.SystemCollection = Backbone.Collection.extend({
	model: window.cabiApp.System,

	url: '/api/src/systems.json',

	comparator: function(system) {
		return system.get('location_name');
	}

});