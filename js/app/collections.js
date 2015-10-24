window.cabiApp.StationCollection = Backbone.Collection.extend({
	model: window.cabiApp.Station,

	url: '/api/src/latest-station-data.json',

	order: 'distance',

	comparator: function(station) {
		if (this.order === 'name') {
            return station.get('name');
        } else {
            return station.get('distance');
        }
	}
});