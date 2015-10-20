<a id="station-list-trigger" class="overlay-btn" href="#">&larr; Station List</a>
<a href="#" class="reload-trigger overlay-btn"><i class="fa fa-refresh"></i></a>
<% 
  var bikeClass = '';
  var dockClass = '';
  var updateTime = station.lastCommWithServer ? new Date(parseInt(station.lastCommWithServer)) : false;

  if (station.nbBikes <= 3) {
    bikeClass = ' low';
      if (station.nbBikes == 0) {
        bikeClass = ' empty';
      }
  }
  if (station.nbEmptyDocks <= 3) {
    dockClass = ' low';
      if (station.nbEmptyDocks == 0) {
        dockClass = ' empty';
      }
  }
%>
<div class="row-fluid num-container<%= bikeClass %>" id="num-bikes">
  <div class="span12">
    <p><%= station.nbBikes %> <img src="/img/bike.svg" alt="" /></p>
  </div>
</div>
<div class="row-fluid num-container<%= dockClass %>" id="num-docks">
  <div class="span12">
    <p><%= station.nbEmptyDocks %> <i class="fa fa-arrow-circle-o-down"></i></p>
  </div>
</div>
<div class="station-banner">
  <p><%= station.name %><br/><% if (updateTime) { %><em><span class="timeago" title="<%= updateTime.toISOString() %>"></span></em><% } %></p>
</div>
<% if (station.locked === 'true') { %>
  <div class="station-lock-overlay">
    <h1>Station Closed</h1>
  </div>
<% } %>