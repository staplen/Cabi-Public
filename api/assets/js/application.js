/**
 *  Application Initialization
 *  
 *  @author Mighty <team@getmighty.com>
 *  
 */

(function() {
  
  var $ = jQuery;  // Handle namespaced jQuery
  
  // Set up application globals
  if (!window.App)      window.App      = {};
  if (!App.view)        App.view        = {};
  if (!App.model)       App.model       = {};
  if (!App.collection)  App.collection  = {};
    
  App.init = function(options) {
    var defaults = {
    };
    App.options           = _.extend({}, defaults, options);
    App.collection        = new App.collection(app_data);
    App.view              = new App.view({ app : this });  
    return this;
  };
})();