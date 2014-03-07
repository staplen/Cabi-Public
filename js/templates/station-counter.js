<a id="station-list-trigger" class="overlay-btn" href="#">&larr; Station List</a>
<a href="#" class="reload-trigger overlay-btn"><i class="icon-refresh"></i></a>
<% 
  var bikeClass = '';
  var dockClass = '';
  var updateTime = new Date(parseInt(station.lastCommWithServer));
  var bikeAvgPlural = parseInt(station.averages['avgBikes']) === 1 ? '' : 's';
  var dockAvgPlural = parseInt(station.averages['avgDocks']) === 1 ? '' : 's';

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
    <p><%= station.nbEmptyDocks %> <i class="icon-download"></i></p>
  </div>
</div>
<div class="station-banner">
  <p><%= station.name %><br/><em><span class="timeago" title="<%= updateTime.toISOString() %>"></span></em></p>
  <% if (station.averages) { %>
    <!-- <hr />
    <p class="averages">On <%= station.averages['weekday'] %>s around <%= station.averages['prettyTime'] %>, there are an average of <%= station.averages['avgBikes'] %> bike<%= bikeAvgPlural %> and <%= station.averages['avgDocks'] %> dock<%= dockAvgPlural %>.</p> -->
  <% } %>
</div>
<% if (station.locked === 'true') { %>
  <div class="station-lock-overlay">
    <h1>Station Closed</h1>
  </div>
<% } %>