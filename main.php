<?php include "include/db_connect_oo.php" ?>
<?php include "include.php" ?>
<!DOCTYPE html>
<html lang="th">
<head>
  <?php include "include_head.php" ?>
  <title>Home</title>

  <script>
    $(document).ready(function() {
      // This command is used to initialize some elements and make them work properly
      $.material.init();

    });
  </script>

  <style type="text/css">
    html { height: 100%; margin: 0; padding: 0; }
    body { height: 100%; margin: 0; }
    #map { height: 100%; }
  </style>

</head>
<body>
  <div id="map"></div>

  <script type="text/javascript">

    var map;
    function initMap() {
      map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 8
      });

      // Try HTML5 geolocation.
      $.snackbar({content: "wait for GPS signal..."});
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {

          var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };

          $.snackbar({content: "Location found."});
          map.setCenter(pos);
        }, function() {
          alert('Error: The Geolocation service failed.');
        });
      } else {
        // Browser doesn't support Geolocation
        alert('Error: Your browser doesn\'t support geolocation.');
      }
    }

  </script>
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVsqkcMi6fsDdKO7_7MSXYZra09vK3qrM&callback=initMap">
  </script>

  <!--  nev bar -->
  <?php include "nev_bar.php" ?>
</body>
</html>
