<?php include "include/db_connect_oo.php" ?>
<?php include "include.php" ?>
<!DOCTYPE html>
<html lang="th">
<head>
  <?php include "include_head.php" ?>
  <title>Map View</title>

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
    #btnBufferUI, #btnHeatUI, #btnAllMessagesUI {
      background-color: #fff;
      border: 2px solid #fff;
      border-radius: 3px;
      box-shadow: 0 2px 6px rgba(0,0,0,.3);
      cursor: pointer;
      /*float: left;*/
      margin: 8px;
      text-align: center;
      width: 120px;
    }
    #btnBufferText, #btnHeatText, #btnAllMessagesText {
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

    var options = {};
    options.buffer = "buffer";
    options.heatMap = "heatMap";
    options.allMessages = "allMessages";

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
      btnBufferUI.title = 'Active/Deactivate Buffer';
      controlDiv.appendChild(btnBufferUI);

      var btnBufferText = document.createElement('div');
      btnBufferText.id = 'btnBufferText';
      btnBufferText.innerHTML = 'Buffer';
      btnBufferUI.appendChild(btnBufferText);

      var btnHeatUI = document.createElement('div');
      btnHeatUI.id = 'btnHeatUI';
      btnHeatUI.title = 'Active/Deactivate Heat Map';
      controlDiv.appendChild(btnHeatUI);

      var btnHeatText = document.createElement('div');
      btnHeatText.id = 'btnHeatText';
      btnHeatText.innerHTML = 'Heat Map';
      btnHeatUI.appendChild(btnHeatText);

      var btnAllMessagesUI = document.createElement('div');
      btnAllMessagesUI.id = 'btnAllMessagesUI';
      btnAllMessagesUI.title = 'Active/Deactivate All Messages';
      controlDiv.appendChild(btnAllMessagesUI);

      var btnAllMessagesText = document.createElement('div');
      btnAllMessagesText.id = 'btnAllMessagesText';
      btnAllMessagesText.innerHTML = 'All Messages';
      btnAllMessagesUI.appendChild(btnAllMessagesText);

      btnBufferUI.addEventListener('click', function() {
        // clearMap();
        getCurrentLocation();

        map.addListener('click', function(e) {
          newOrigin(e.latLng);
        });

      });

      btnHeatUI.addEventListener('click', function() {
        // clearMap();
        getAllMessages(options.heatMap);
      });

      btnAllMessagesUI.addEventListener('click', function() {
        // clearMap();
        getAllMessages(options.allMessages);
      });
    }

    function clearMap(){
      clearBufferMap();
      clearHeatMap();
      clearMarker();
      google.maps.event.clearInstanceListeners(map);
    }

    function makeMarker(data) {
      for (x in data) {
        var infowindow = new google.maps.InfoWindow({
          content: contentString,
          maxWidth: 200
        });
        var myLatLng = {lat: Number(data[x].lat), lng: Number(data[x].lng)}
        var ic_note = 'images/icon40.png';
        var marker = new google.maps.Marker({
          position : myLatLng,
          map: map,
          title: data[x].message,
          icon: ic_note,
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
        '<h3 id="firstHeading" class="firstHeading">'+ data.user.name +'</h3>'+
        '<div id="bodyContent">'+
        '<p><strong>'+ data.message +'</strong></p>'+
        '<p>'+ data.created_at +'</p>'
        '</div>'+
        '</div>';
    }

    var map;
    var heatMap;
    var buffer;
    var origin;

    function initMap() {
      drawMap();
      drawControl();
    }

    function drawControl() {
      var centerControlDiv = document.createElement('div');
      var centerControl = new CenterControl(centerControlDiv, map);

      centerControlDiv.index = 1;
      centerControlDiv.style['padding-top'] = '5px';
      map.controls[google.maps.ControlPosition.TOP_RIGHT].push(centerControlDiv);
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

          clearMap();
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
      clearMarker();
    }

    function clearMarker() {
      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
      }
    }

    function clearHeatMap() {
      if (typeof(heatmap)==="undefined") {
        return;
      }

      heatmap.setMap(null);
    }

    function drawHeatMap(messages) {
      var points = [];
      for (var i in messages) {
        points.push(new google.maps.LatLng(messages[i].lat, messages[i].lng));
      }

      heatmap = new google.maps.visualization.HeatmapLayer({
        data: points,
        map: map
      });
    }

    function getAllMessages(option) {
      $.support.cors = true;
      $.ajax({
        url: "http://128.199.208.34/open.note/messages.php",
        dataType: "json"
      })
      .done(function(data) {
        console.log( "success" );
        console.log(data);
        clearMap();
        if (option === options.heatMap) {
          drawHeatMap(data);
        } else if (option === options.allMessages) {
          makeMarker(data);
        }
      })
      .fail(function(data) {
        console.log( "error" );
        console.log(data);
      });
    }



  </script>
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVsqkcMi6fsDdKO7_7MSXYZra09vK3qrM&libraries=visualization&callback=initMap">
  </script>

  <!--  nev bar -->
  <?php include "nev_bar.php" ?>
</body>
</html>
