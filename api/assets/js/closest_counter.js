function displayError(error) {
  var errors = { 
    1: 'Permission denied',
    2: 'Position unavailable',
    3: 'Request timeout'
  };
  console.log("Error: " + errors[error.code]);
  $('#loading').hide();
  $('#geolocation-error').show();
}

function displayPosition(position) {
  $.ajax({
    url: "/api/closestcounter?lat="+position.coords.latitude+"&lon="+position.coords.longitude
  }).done(function( data ) {
    data = jQuery.parseJSON(data);
    document.title = data[2];
    $('#content').html(data[0]);
    $('#wrapper').append(data[1]);
    $('#loading').hide();
    $('#content').show();
    $(window).resize();
  });
}

if (navigator.geolocation) {
  var timeoutVal = 10 * 1000 * 1000;
  navigator.geolocation.getCurrentPosition(
    displayPosition, 
    displayError,
    { enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0 }
  );
}
else {
  $('#loading').hide();
  $('#content').show();
}