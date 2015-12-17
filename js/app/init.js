$(function() {

  window.cabiApp.settings = {

    appLoaded: false,

    reloadTriggerEl: $('.reload-trigger'),

    cookieFoundAlert: $('#cookie-found'),

    fullBaseUrl: "http://cabi.nicostaple.com",

    userLocationObj: null,

    userLocationString: "",

    activeSystemId: ""

  };



  window.cabiApp.systems = new window.cabiApp.SystemCollection;
  window.cabiApp.systemsView = new window.cabiApp.SystemCollectionView({ collection: window.cabiApp.systems });
  window.cabiApp.systems.reset(window.cabiApp.systemsData);

  window.cabiApp.cabiRouter = new window.cabiApp.CabiRouter();
  if (!window.cabiApp.settings.appLoaded) {
    Backbone.history.start({pushState: false});
    window.cabiApp.settings.appLoaded = true;
    if (Cookies.get('cabi_activeSystemId') && !Backbone.history.fragment) {
      window.cabiApp.cabiRouter.navigate(Cookies.get('cabi_activeSystemId'), {trigger: true});
      $('span',window.cabiApp.settings.cookieFoundAlert).text(Cookies.get('cabi_activeSystemName'));
      window.cabiApp.settings.cookieFoundAlert.slideDown();
    }
  }

});

$(window).load(function() {
  function setWrapperHeight() {
    var height = $(window).height();
    $('#content').height(height);
    $('#loading').css("padding-top", (height-96) / 2);
    if ($('#station-counter-container').length > 0) {
      var bikePadding = ($('#num-bikes').height() - $('#num-bikes p').height()) / 2;
      var dockPadding = ($('#num-docks').height() - $('#num-docks p').height()) / 2;
      $('#num-bikes p').css("padding-top", bikePadding);
      $('#num-docks p').css("padding-top", dockPadding);
    }
  }
  function setBannerWidth() {
    var width = $(window).width();
    $('.station-banner').width(width);
  }

  $('.hash-link').click(function(e) {
    e.preventDefault();
    window.cabiApp.utils.processHashLink(e);
  });

  $(window).resize(function() {
    setWrapperHeight();
    setBannerWidth()
  });

  setWrapperHeight();
  setBannerWidth();
});