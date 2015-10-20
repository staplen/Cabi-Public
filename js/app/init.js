$(function() {
  window.cabiApp.stations = new window.cabiApp.StationCollection;
  window.cabiApp.stations.reset(window.cabiApp.latestData);
  window.cabiApp.utils.renderInitialPage();       
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

  $(window).resize(function() {
    setWrapperHeight();
    setBannerWidth()
  });

  setWrapperHeight();
  setBannerWidth();
});