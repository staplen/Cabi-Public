<?php 
define('SYSROOT',dirname(__FILE__));
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Cabi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="shortcut icon" href="img/favicon.ico" />
    <link rel="apple-touch-icon" href="img/ios/icon.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="img/ios/icon-72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="img/ios/icon@2x.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="img/ios/icon-72@2x.png" />
    
    <!-- Stylesheets -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/lib/html5shiv.js"></script>
      <script src="js/lib/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="//use.typekit.net/xto8xnn.js"></script>
    <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-28679304-1']);
      _gaq.push(['_setDomainName', 'nicostaple.com']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
  </head>
  <body>

    <div id="content">
      <div id="loading">
        <img src="/img/spinner_96.gif" alt="Loading..." height="48" width="48" />
      </div>
      <div id="geolocation-error">
        <h1>There was an error determining your location. Please make sure location services are enabled and you've allowed Cabi to use your location information.</h1>
      </div>
      <div id="stations-list-container"></div>
    </div>

    <!-- JS libraries -->
    <script src="js/lib/jquery-2.0.3.min.js"></script>
    <script src="js/lib/underscore-1.5.2.min.js"></script>
    <script src="js/lib/backbone-1.1.0.min.js"></script>
    <script src="js/lib/jquery.scrollTo-1.4.6.min.js"></script>
    <script src="js/lib/bootstrap.min.js"></script>
    <script src="js/lib/jquery.timeago.js"></script>

    <!-- Backbone app -->
    <script>window.cabiApp = {};</script>
    <script src="js/app/utils.js"></script>
    <script src="js/app/models.js"></script>
    <script src="js/app/views.js"></script>
    <script src="js/app/collections.js"></script>
    <script src="js/app/routers.js"></script>
    
    <!-- Backbone templates -->
    <script id="stations-list-template" type="text/template">
      <?php require_once(SYSROOT."/js/templates/stations-list.js"); ?>;
    </script>
    <script id="station-counter-template" type="text/template">
      <?php require_once(SYSROOT."/js/templates/station-counter.js"); ?>;
    </script>

    <script>
      $(function() {
        var latestData = <?php require_once(SYSROOT."/api/json/latest-station-data.json"); ?>;
        window.cabiApp.stations = new window.cabiApp.StationCollection;
        window.cabiApp.stations.reset(latestData);
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
    </script>

  </body>
</html>