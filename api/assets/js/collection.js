/**
 *  Collection
 *  
 *  @author Mighty <team@getmighty.com>
 *  
 */
   
(function() {
  var $ = jQuery;  // Handle namespaced jQuery
  App.collection = Backbone.Collection.extend({
    model: App.model
  });
})();