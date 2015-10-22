window.cabiApp.CabiRouter = Backbone.Router.extend({

  routes: {
    ""		  			  :      "stationList",
    "stations/:stationId" :      "stationCounter"
  },

  stationList: function() {
  	if ($('#stations-list-container').children().length === 0) {
		window.cabiApp.stationListView.render().delegateEvents();
  	}
	$('#station-counter-container').remove();
	if (window.stationId) {
		var scrollToEl = $('#station-'+window.stationId);
		$('#stations-list-container').show();
		$('body').scrollTo( scrollToEl, 0 );
	}
	else {
		$('#stations-list-container').show();
	}
	document.title = "Cabi Glance - Station List";
	ga('send', 'pageview', {
	  'page': '/' + Backbone.history.fragment,
	  'title': "Cabi Glance - Station List"
	});
  },

  stationCounter: function(stationId) {
  	if (stationId) {
	  	var stationModel = stationId === 'closest' ? window.cabiApp.stations.sort().first() : window.cabiApp.stations.get(stationId);
		window.cabiApp.stationCounterView = new window.cabiApp.StationCounterView({model: stationModel});
		window.cabiApp.stationCounterView.render();
		$('#stations-list-container, #geolocation-error').hide();
		$('#station-counter-container').show();
		window.stationId = stationId;
		document.title = stationModel.get('name');
		ga('send', 'pageview', {
		  'page': '/' + Backbone.history.fragment,
		  'title': stationModel.get('name')
		});
	}
	else {
		stationList();
	}
  }

});