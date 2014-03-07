// Station List View
window.cabiApp.StationListView = Backbone.View.extend({

	id: 'station-list',

	events: {
		"click #collection-reset": "refreshCollection",
		"click .reload-trigger": "reloadPage"
	},

	initialize: function() {
		this.template = _.template( $('#stations-list-template').html() );
	    // in the view, listen for events on the model / collection
	    this.collection.bind("reset", this.render, this);

	},

	render: function() {
	    $(this.el).html(this.template({ stations: this.collection.sort() }));
	    $('#stations-list-container').html(this.el);
	    jQuery(".timeago").timeago();
		return this;
	},

	refreshCollection: function(e) {
		e.preventDefault();
	},

	reloadPage: function(e) {
		$(this.el).hide();
		location.reload();
	}

});


// Station Counter View
window.cabiApp.StationCounterView = Backbone.View.extend({

	id: 'station-counter-container',

	events: {
		"click #station-list-trigger": "toggleStationList",
		"click .reload-trigger": "reloadPage"
	},

	initialize: function() {
		this.template = _.template( $('#station-counter-template').html() );
	    // in the view, listen for events on the model / collection
	    this.model.bind("reset", this.render, this);

	},

	render: function() {
	    $(this.el).html(this.template({station:this.model.toJSON()}));
	    $('#content').append(this.el);
	    $('#loading').hide();
	    $('body').scrollTop(0);
	    jQuery(".timeago").timeago();
	    $(window).resize();
	    // if (window.navigator.standalone) {
		//     setTimeout(
		//     	function(){
		//     		if (Backbone.history.fragment.indexOf("stations") >= 0) {
		// 	    		location.reload();
		// 	    	}
		//     	},
		//     	30000
		//     );
		// }
		return this;
	},

	toggleStationList: function(e) {
		e.preventDefault();
		window.cabiApp.cabiRouter.navigate("", {trigger: true});
	},

	reloadPage: function(e) {
		$('#content').hide();
		location.reload();
	}
});