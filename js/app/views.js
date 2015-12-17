// Station List View
window.cabiApp.StationListView = Backbone.View.extend({

	id: function() {
		return 'station-' + this.model.get('id');
	},

	className: 'row station-item',

	initialize: function() {
		var templateId = this.model.get('type') === 'subway' ? '#subway-station-list-template' : '#station-list-template';
		this.template = _.template( $(templateId).html() );
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
		this.render();
	}

});


// Station Counter View
window.cabiApp.StationSingleView = Backbone.View.extend({

	id: 'station-single-container',

	events: {
		"click #station-list-trigger": "toggleStationList"
	},

	initialize: function() {
		var templateId = this.model.get('type') === 'subway' ? '#subway-station-single-template' : '#station-single-template';
		this.template = _.template( $(templateId).html() );
	    this.listenTo(this.model, "change:viewVariables change:locked change:name change:trains", this.render);
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
		window.cabiApp.cabiRouter.navigate(window.cabiApp.settings.activeSystemId, {trigger: true});
	}
});




// System views
window.cabiApp.SystemListView = Backbone.View.extend({

	tagName: 'li',

	initialize: function() {
		this.template = _.template( $('#system-list-template').html() );
	    this.listenTo(this.model, "change", this.render);
	},

	render: function() {
	    $(this.el).html(this.template(this.model.toJSON()));
		return this;
	}

});

window.cabiApp.SystemCollectionView = Backbone.View.extend({

	id: 'system-list',

	tagName: 'ul',

	render: function() {
		var self = this;
		this.$el.empty();

		var completeRender = _.after(this.collection.length, function() {
			$('#systems-list-container').html(self.$el);
			$('#loading').hide();
		});
		this.collection.each( function(system) {
			var systemListView = new window.cabiApp.SystemListView ({ model: system });
			self.$el.append(systemListView.render().el);
			completeRender();
		});

		return this;
	},

	initialize: function() {
		this.listenTo(this.collection, "reset", this.render);
	}

});