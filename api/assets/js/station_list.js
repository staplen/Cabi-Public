function displayError(error) {
  var errors = { 
    1: 'Permission denied',
    2: 'Position unavailable',
    3: 'Request timeout'
  };
  console.log("Error: " + errors[error.code]);
  $.ajax({
    url: "/api/stationDistance?lat=null&lon=null"
  }).done(function( data ) {
    $('#content').html(data);
    $('#loading').hide();
    $('#content').show();
  });
}

function displayPosition(position) {
  $.ajax({
    url: "/api/stationDistance?lat="+position.coords.latitude+"&lon="+position.coords.longitude
  }).done(function( data ) {
    $('#content').html(data);
    $('#loading').hide();
    $('#content').show();
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