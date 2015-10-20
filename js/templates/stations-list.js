<!-- <li><a href="#" id="collection-reset">refresh</a></li> -->
<a href="#" class="reload-trigger overlay-btn"><i class="fa fa-refresh"></i></a>
<%
  stations.each(function(station) {
    var bikeClass = 'progress-bar-success';
    var dockClass = 'progress-bar-success';
    var updateTime = station.get('lastCommWithServer') ? new Date(parseInt(station.get('lastCommWithServer'))) : false;

    var bikePlural = parseInt(station.get('nbBikes')) === 1 ? '' : 's';
    var dockPlural = parseInt(station.get('nbEmptyDocks')) === 1 ? '' : 's';

    var intBikes = parseInt(station.get('nbBikes'));
    var intDocks = parseInt(station.get('nbEmptyDocks'));
    var totalDocks = intBikes + intDocks;

    var bikePercent = intBikes / totalDocks;
    bikePercent = Math.round(bikePercent * 100);
    var dockPercent = intDocks / totalDocks;
    dockPercent = Math.round(dockPercent * 100);
    
    // Set percentage min and max for bar chart display and classes for progress bars
    if (station.get('nbBikes') <= 3) {
      bikeClass = 'progress-bar-warning';
      bikePercent = 25;
      dockPercent = 75;
      if (station.get('nbBikes') == 0) {
        bikeClass = 'progress-bar-danger';
        bikePercent = 15;
        dockPercent = 85;
      }
    }
    if (station.get('nbEmptyDocks') <= 3) {
      dockClass = 'progress-bar-warning';
      bikePercent = 75;
      dockPercent = 25;
      if (station.get('nbEmptyDocks') == 0) {
        dockClass = 'progress-bar-danger';
        bikePercent = 85;
        dockPercent = 15;
      }
    }

    var progressClass = (intBikes > 0 && intDocks > 0) ? '' : ' singular';

    %>
    <div class="row station-item" id="station-<%= station.get('id') %>">
      <a href="#stations/<%= station.get('id') %>" data-id="<%= station.get('id') %>">
        <div class="col-md-12">
          <%= station.get('name') %>
          <div class="progress<%= progressClass %>">
            <div class="progress-bar <%= bikeClass %>" style="width: <%= bikePercent %>%"><img src="/img/bike.svg" alt="" /></div>
            <div class="progress-bar <%= dockClass %>" style="width: <%= dockPercent %>%"><i class="fa fa-arrow-circle-o-down"></i></div>
          </div>
          <div class="text">
            <p><% if (updateTime) { %><span class="timeago" title="<%= updateTime.toISOString() %>"></span>: <% } %><strong><%= station.get('nbBikes') %> bike<%= bikePlural %></strong> and <strong><%= station.get('nbEmptyDocks') %> dock<%= dockPlural %></strong> <%= station.get('distance').toFixed(2) %> miles away</p>
          </div>
        </div><!-- END .col-md-12 -->
        <% if (station.get('locked') === 'true') { %>
          <div class="station-lock-overlay">
            <h1>Station Closed</h1>
          </div>
        <% } %>
      </a>
    </div>
<% }); %>