window.cabiApp.Station = Backbone.Model.extend({
	
	defaults: {
		"distance" : 0
	},

	initialize: function() {
		this.on("change:nbBikes change:nbEmptyDocks change:lastCommWithServer", function() {
			this.setViewVariables();
		});
		this.setViewVariables();
	},

	setViewVariables: function() {
		var listBikeClass = 'progress-bar-success';
		var listDockClass = 'progress-bar-success';
		var singleBikeClass, singleDockClass;
		var updateTime = this.get('lastCommWithServer') ? new Date(parseInt(this.get('lastCommWithServer'))) : false;

		var bikePlural = parseInt(this.get('nbBikes')) === 1 ? '' : 's';
		var dockPlural = parseInt(this.get('nbEmptyDocks')) === 1 ? '' : 's';

		var intBikes = parseInt(this.get('nbBikes'));
		var intDocks = parseInt(this.get('nbEmptyDocks'));
		var totalDocks = intBikes + intDocks;

		var bikePercent = intBikes / totalDocks;
		bikePercent = Math.floor(bikePercent * 100);
		var dockPercent = intDocks / totalDocks;
		dockPercent = Math.floor(dockPercent * 100);
		var percentTotal = dockPercent + bikePercent;

		if (percentTotal !== 100) {
			if (dockPercent < bikePercent) {
				dockPercent = dockPercent + (100 - percentTotal);
			}
			else if (dockPercent > bikePercent) {
				bikePercent = bikePercent + (100 - percentTotal);
			}
		}

		// Set percentage min and max for bar chart display and classes for progress bars
		if (this.get('nbBikes') <= 3) {
			listBikeClass = 'progress-bar-warning';
			singleBikeClass = ' low'
			bikePercent = 25;
			dockPercent = 75;
			if (this.get('nbBikes') == 0) {
				listBikeClass = 'progress-bar-danger';
				singleBikeClass = ' empty';
				bikePercent = 15;
				dockPercent = 85;
			}
		}
		if (this.get('nbEmptyDocks') <= 3) {
			listDockClass = 'progress-bar-warning';
			singleDockClass = ' low';
			bikePercent = 75;
			dockPercent = 25;
			if (this.get('nbEmptyDocks') == 0) {
				listDockClass = 'progress-bar-danger';
				singleDockClass = ' empty';
				bikePercent = 85;
				dockPercent = 15;
			}
		}

		var progressClass = (intBikes > 0 && intDocks > 0) ? '' : ' singular';

		this.set('viewVariables', {
			progressClass: progressClass,
			listBikeClass: listBikeClass,
			singleBikeClass: singleBikeClass,
			bikePercent: bikePercent,
			listDockClass: listDockClass,
			singleDockClass: singleDockClass,
			dockPercent: dockPercent,
			updateTime: updateTime,
			bikePlural: bikePlural,
			dockPlural: dockPlural
		});
	}

});


window.cabiApp.System = Backbone.Model.extend({
	
	defaults: {}

});