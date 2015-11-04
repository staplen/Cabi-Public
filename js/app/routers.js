window.cabiApp.CabiRouter = Backbone.Router.extend({

  routes: {
  	""								:      "systemList",
    ":systemId"		  			    :      "stationList",
    ":systemId/stations/:stationId" :      "stationCounter"
  },

  systemList: function() {
  	$('#systems-list-container').show();
  	$('#station-single-container, #geolocation-error, #stations-list-container, #loading').hide();

    document.title = "Cabi Glance - System List";
    ga('send', 'pageview', {
      'page': '/' + Backbone.history.fragment,
      'title': "Cabi Glance - System List"
    });
  },

  stationList: function(systemId) {
  	$('#systems-list-container').hide();

  	if ($('#stations-list-container').children().length === 0) {
  		$('#loading').show();
  		window.cabiApp.settings.activeSystemId = systemId;
  		window.cabiApp.stations = new window.cabiApp.StationCollection;
		window.cabiApp.stations.fetch( { cache: false, success: window.cabiApp.utils.renderInitialPage } );

		window.cabiApp.utils.asyncUpdateTimeout();
  	}

  	if (window.cabiApp.settings.activeSystemId !== systemId) {
  		$('#loading').show();
  		window.stationId = false;
  		$('body').scrollTop(0);
  		window.cabiApp.settings.activeSystemId = systemId;
  		window.cabiApp.stations.fetch( { cache: false, success: window.cabiApp.utils.renderInitialPage, reset: true } );
  	}

  	$('#station-single-container').remove();
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

  stationCounter: function(systemId,stationId) {
  	function completeRoute() {
  		console.log('completeRoute');
  		var stationModel = stationId === 'closest' ? window.cabiApp.stations.sort().first() : window.cabiApp.stations.get(stationId);
  		if (!stationModel) { alert('Station not found.'); }
  		if (window.cabiApp.stationSingleView) { window.cabiApp.stationSingleView.remove(); }
		window.cabiApp.stationSingleView = new window.cabiApp.StationSingleView({model: stationModel});
		$('#stations-list-container, #geolocation-error, #systems-list-container').hide();
		$('#station-single-container').show();
		window.stationId = stationId;
		document.title = stationModel.get('name');
		ga('send', 'pageview', {
		  'page': '/' + Backbone.history.fragment,
		  'title': stationModel.get('name')
		});
  	}

  	function startRoute() {
  		if (stationId) {
	  		if (!window.cabiApp.stations) {
	  			window.cabiApp.settings.activeSystemId = systemId;
		  		window.cabiApp.stations = new window.cabiApp.StationCollection;
				window.cabiApp.stations.fetch( { cache: false, success: completeRoute } );
	  		}
	  		else {
			  	completeRoute();
	  		}
		}
		else {
			stationList();
		}
  	}

  	if (window.cabiApp.settings.activeSystemId !== systemId && window.cabiApp.stations) {
  		window.cabiApp.settings.activeSystemId = systemId;
  		window.cabiApp.stations.fetch( { cache: false, success: startRoute, reset: true } );
  	}
  	else {
  		startRoute();
  	}

  	
  }

});