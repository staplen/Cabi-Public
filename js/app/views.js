// Station List View
window.cabiApp.StationListView = Backbone.View.extend({

	id: 'station-list',

	initialize: function() {
		this.template = _.template( $('#stations-list-template').html() );
	    this.collection.bind("distancesUpdated", this.render, this);
	},

	render: function() {
		console.log('StationListView render');
	    $(this.el).html(this.template({ stations: this.collection.sort() }));
	    $('#stations-list-container').html(this.el);
	    jQuery(".timeago").timeago();
	    this.delegateEvents();
	    window.cabiApp.settings.reloadTriggerEl.children('i').removeClass('fa-spin');
		return this;
	}

});


// Station Counter View
window.cabiApp.StationCounterView = Backbone.View.extend({

	id: 'station-counter-container',

	events: {
		"click #station-list-trigger": "toggleStationList"
	},

	initialize: function() {
		this.template = _.template( $('#station-counter-template').html() );
	    this.model.bind("distanceUpdated", this.render, this);
	},

	render: function() {
	    $(this.el).html(this.template({station:this.model.toJSON()}));
	    $('#content').append(this.el);
	    $('#loading').hide();
	    $('body').scrollTop(0);
	    jQuery(".timeago").timeago();
	    $(window).resize();
	    window.cabiApp.settings.reloadTriggerEl.children('i').removeClass('fa-spin');
		return this;
	},

	toggleStationList: function(e) {
		e.preventDefault();
		window.cabiApp.cabiRouter.navigate("", {trigger: true});
	}});