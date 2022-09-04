<?php include 'insertdatamap.php' ?>
<!DOCTYPE html>
<html>
  <head>
    <meta
      name="viewport"
      content="initial-scale=1,maximum-scale=1,user-scalable=no"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <style>
      #map {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
      }
    </style>
  </head>
  <body>
  <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <div id="map">
      <a
        href="https://www.maptiler.com"
        style="position: absolute; left: 10px; bottom: 10px; z-index: 999"
        ><img
          src="https://api.maptiler.com/resources/logo.svg"
          alt="MapTiler logo"
      /></a>
    </div>
    <p>
      <a href="https://www.maptiler.com/copyright/" target="_blank"
        >&copy; MapTiler</a
      >
      <a href="https://www.openstreetmap.org/copyright" target="_blank"
        >&copy; OpenStreetMap contributors</a
      >
    </p>
    <script>
      var map = L.map("map").setView([0, 0], 1);
      L.tileLayer(
        "https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=m4UDU1L0NSzWbDH7I0Ir",
        {
          tileSize: 512,
          zoomOffset: -1,
          minZoom: 15,
          attribution:
            '\u003ca href="https://www.maptiler.com/copyright/" target="_blank"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href="https://www.openstreetmap.org/copyright" target="_blank"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e',
          crossOrigin: true,
        }
      ).addTo(map);

      map.locate({ setView: true, maxZoom: 16 });
      function onLocationFound(e) {
        var radius = e.accuracy;

        L.marker(e.latlng)
          .addTo(map)
          .bindPopup("You are within 20 meters from this point")
          .openPopup();

        L.circle(e.latlng, 10, { color: "red" }).addTo(map);
      }

      map.on("locationfound", onLocationFound);
      
    let activities =[[38.2377, 21.7259],[38.2499, 21.7391],[38.2368, 21.7259],[38.2506, 21.7399],[38.2506, 21.7373],[38.2497, 21.7391],[38.2501, 21.7379],[38.25, 21.738],[38.2377, 21.7259],[38.2504, 21.7385],[38.2496, 21.7399],[38.2502, 21.7398],[38.2501, 21.7395],[38.2505, 21.7373],[38.2497, 21.7374],[38.2498, 21.7389],[38.2497, 21.7391]]; 

console.table(activities);

    $.ajax(
    'insertdatamap.php',
    {
      success: function(data) {
        alert('AJAX call was successful!');
        alert('Data from the server' + data);
        var latlong = <?= echo json_encode($data); ?>;
        latlong = Object.values(latlong);
        console.table(latlong);
        for ( var i = 0; i < latlong.length; i ++) { 
        marker = new L.marker([latlong[i][1],latlong[i][2]])
      .addTo(map);
      }
      },
      error: function() {
        alert('There was some error performing the AJAX call!');
      }
   }
      );



/*
      $.ajax({
            url: "insertdatamap.php",
            dataType: "text",
            type: "GET",
            data: { data: data },
            success: function (response) {
              // window.location = "../index.php"
              console.log(response);
            },
            error: function (error) {
              console.log(error);
            },
          });
        
*/







    </script>
  </body>
</html>
