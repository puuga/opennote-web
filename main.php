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
    #btnBufferUI, #btnTempUI {
      background-color: #fff;
      border: 2px solid #fff;
      border-radius: 3px;
      box-shadow: 0 2px 6px rgba(0,0,0,.3);
      cursor: pointer;
      float: left;
      margin: 8px;
      text-align: center;
      width: 100px;
    }
    #btnBufferText, #btnTempText {
      color: rgb(25,25,25);
      font-family: Roboto,Arial,sans-serif;
      font-size: 15px;
      line-height: 25px;
      padding-left: 5px;
      padding-right: 5px;
    }
    #setCenterUI {
      margin-left: 12px;
    }
  </style>

</head>
<body>
  <?php include_once("include/analyticstracking.php") ?>
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

    function CenterControl(controlDiv, map) {
      var control = this;

      controlDiv.style.clear = 'both';

      var btnBufferUI = document.createElement('div');
      btnBufferUI.id = 'btnBufferUI';
      btnBufferUI.title = 'Active/Deactivate Temperature';
      controlDiv.appendChild(btnBufferUI);

      var btnBufferText = document.createElement('div');
      btnBufferText.id = 'btnBufferText';
      btnBufferText.innerHTML = 'Buffer';
      btnBufferUI.appendChild(btnBufferText);

      var btnTempUI = document.createElement('div');
      btnTempUI.id = 'btnTempUI';
      btnTempUI.title = 'Active/Deactivate Heat Map';
      controlDiv.appendChild(btnTempUI);

      var btnTempText = document.createElement('div');
      btnTempText.id = 'btnTempText';
      btnTempText.innerHTML = 'Heat Map';
      btnTempUI.appendChild(btnTempText);

      console.log(btnTempText);

      btnBufferUI.addEventListener('click', function() {
        clearMap();
        getCurrentLocation();

        map.addListener('click', function(e) {
          newOrigin(e.latLng);
        });

      });

      btnTempUI.addEventListener('click', function() {
        clearMap();
      });
    }

    function clearMap(){
      clearBufferMap();
      clearHeatMap();
      google.maps.event.clearInstanceListeners(map);
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
      drawControl();
    }

    function drawControl(){

      var centerControlDiv = document.createElement('div');
      var centerControl = new CenterControl(centerControlDiv, map);

      centerControlDiv.index = 1;
      centerControlDiv.style['padding-top'] = '20px';
      map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
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

      clearBufferMap();

      var pos = {
        lat: origin.lat(),
        lng: origin.lng()
      };

      drawBuffer(50000, pos);
      loadMessages(pos.lat, pos.lng);
    }

    function clearBufferMap() {
      if (typeof(buffer)==="undefined") {
        return;
      }
      buffer.setMap(null);

      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
      }
    }
    function clearHeatMap() {

    }

  </script>
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVsqkcMi6fsDdKO7_7MSXYZra09vK3qrM&callback=initMap">
  </script>

  <!--  nev bar -->
  <?php include "nev_bar.php" ?>
</body>
</html>
