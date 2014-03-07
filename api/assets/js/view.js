/**
 *  View
 *  
 *  @author Mighty <team@getmighty.com>
 *  
 */
   
(function() {
  
  var $ = jQuery; 
  
  App.view = Backbone.View.extend({

    el: '#wrapper',
    
    events : {
      'click #search-submit'            : 'startSearch'
    },
    
    
    /**
     * Set up initial view
     */
    initialize : function() {
      this.app = this.options.app;

      
    },


    

  });
})();