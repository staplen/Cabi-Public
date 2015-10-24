// Station List View
window.cabiApp.StationListView = Backbone.View.extend({

	id: function() {
		return 'station-' + this.model.get('id');
	},

	className: 'row station-item',

	initialize: function() {
		this.template = _.template( $('#station-list-template').html() );
	    this.listenTo(this.model, "change", this.render);
	},

	render: function() {
	    $(this.el).html(this.template(this.model.toJSON()));
	    jQuery(".timeago",this.el).timeago();
		return this;
	}

});

window.cabiApp.StationCollectionView = Backbone.View.extend({

	id: 'station-list',

	render: function() {
		var self = this;
		this.$el.empty();

		var completeRender = _.after(this.collection.length, function() {
			$('#stations-list-container').html(self.$el);
		});
		this.collection.each( function(station) {
			var stationListView = new window.cabiApp.StationListView ({ model: station });
			self.$el.append(stationListView.render().el);
			completeRender();
		});

		return this;
	},

	initialize: function() {
		this.listenTo(this.collection, "reset", this.render);
	}

});


// Station Counter View
window.cabiApp.StationSingleView = Backbone.View.extend({

	id: 'station-single-container',

	events: {
		"click #station-list-trigger": "toggleStationList"
	},

	initialize: function() {
		this.template = _.template( $('#station-single-template').html() );
	    this.listenTo(this.model, "change:viewVariables change:locked change:name", this.render);
	    this.render();
	},

	render: function() {
	    $(this.el).html(this.template(this.model.toJSON()));
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
		this.remove();
		window.cabiApp.cabiRouter.navigate("", {trigger: true});
	}});