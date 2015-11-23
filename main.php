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
    var markers = [];

    function loadMessages(lat,lng){
      $.support.cors = true;
      $.ajax({
        url: "http://128.199.208.34/open.note/messages.php?lat="+lat+"&lng="+lng,
        dataType: "json"
      })
      .done(function(data) {
        console.log( "success" );
        console.log(data);
        makeMarker(data);
      })
      .fail(function(data) {
        console.log( "error" );
        console.log(data);
      });
    }

    function makeMarker(data) {
      for (x in data) {
        var infowindow = new google.maps.InfoWindow({
          content: contentString,
          maxWidth: 200
        });
        var myLatLng = {lat: Number(data[x].lat), lng: Number(data[x].lng)}
        var marker = new google.maps.Marker({
          position : myLatLng,
          map: map,
          title: data[x].message,
          zIndex: Number(data[x].distance_from_my_location)
        });

        markers.push(marker);

        var contentString = makeContentString(data[x]);

        google.maps.event.addListener(marker,'click', (function(marker,contentString,infowindow) {
          return function() {
            infowindow.setContent(contentString);
            infowindow.open(map,marker);
          };
        })(marker,contentString,infowindow));
      }
    };

    function makeContentString(data) {
      return '<div id="content">'+
        '<div id="siteNotice">'+
        '</div>'+
        '<h1 id="firstHeading" class="firstHeading">'+ data.user.name +'</h1>'+
        '<div id="bodyContent">'+
        '<p><b>'+ data.message +'</b> ' +
        '</p>'+
        '<p>'+ data.created_at +'</p>'
        '</div>'+
        '</div>';
    }

    var map;
    var buffer;
    var origin;
    function initMap() {
      drawMap();
      getCurrentLocation();

      map.addListener('click', function(e) {
        newOrigin(e.latLng);
      });
    }

    function drawMap() {
      var myLatLng = {lat: 16.5808124, lng: 100.1480623}
      map = new google.maps.Map(document.getElementById('map'), {
        center: myLatLng,
        zoom: 10
      });
    }

    function getCurrentLocation() {
      // Try HTML5 geolocation.
      $.snackbar({content: "wait for GPS signal..."});
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {

          var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };

          drawBuffer(50000, pos);

          $.snackbar({content: "Location found."});
          map.setCenter(pos);
          loadMessages(pos.lat, pos.lng);
        }, function() {
          alert('Error: The Geolocation service failed.');
        });
      } else {
        // Browser doesn't support Geolocation
        alert('Error: Your browser doesn\'t support geolocation.');
      }
    }

    function drawBuffer(radius, position) {
      buffer = new google.maps.Circle({
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        map: map,
        center: position,
        radius: radius
      });

      buffer.addListener('click', function(e) {
        newOrigin(e.latLng);
      });
    }

    function newOrigin(latLng) {
      origin = latLng;
      console.log(origin.lat());
      console.log(origin.lng());
      map.panTo(origin);

      clearMap();

      var pos = {
        lat: origin.lat(),
        lng: origin.lng()
      };

      drawBuffer(50000, pos);
      loadMessages(pos.lat, pos.lng);
    }

    function clearMap() {
      buffer.setMap(null);

      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
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
