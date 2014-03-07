$(function() {

	function parseData(station,stationId) {
		var stationName = $('name',station).text();
		var numBikes = $('nbBikes',station).text();
		var numDocks = $('nbEmptyDocks',station).text();
		var d = new Date();

		var dataTable = $('#data-container table tbody');
		var rowClass = '';

		if (numBikes > 3 && numDocks > 3) {
			rowClass = 'success';
		}
		if (numBikes <= 3 || numDocks <= 3) {
			rowClass = 'warning';
		}
		if (numBikes == 0 || numDocks == 0) {
			rowClass = 'danger';
		}
		if (window.numBikes != numBikes || window.numDocks != numDocks) {
			rowClass += ' active';
		}

		var rowHTML = 
			'<tr class="'+rowClass+'">'+
              '<td>'+d+'</td>'+
              '<td>'+numDocks+'</td>'+
              '<td>'+numBikes+'</td>'+
            '</tr>';

        $('#data-container > h1').text(stationName);
        $(dataTable).append(rowHTML);
        window.stationName = stationName;
        window.numBikes = numBikes;
        window.numDocks = numDocks;
        setTimeout(function(){getData(stationId)},30000);
	}

	function getData(stationId) {
		var stationXML = '';
		$.get( "/latestxml", function( data ) {
			stationXML = data;
			var stations = $('station',stationXML);
			var station = '';
			for (i=0; i<stations.length; i++) {
				var tempStationId = $('id',stations[i]).text();
				if (tempStationId == stationId) {
					station = stations[i];
					parseData(station,stationId);
					break;
				}
			}
		});
	}

	function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	var stationId = getParameterByName('station');
	getData(stationId);


});