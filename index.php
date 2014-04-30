<!DOCTYPE html>
<html>
    <head>
        <title>Poll Day Monitoring - Paschim Medinipur</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <style>
            html, body, #map-canvas {
                height: 100%;
                margin: 0px;
                padding: 0px
            }
            #panel {
                position: absolute;
                top: 5px;
                left: 50%;
                margin-left: -180px;
                z-index: 5;
                background-color: #fff;
                padding: 5px;
                border: 1px solid #999;
            }

        </style>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
        <script>
            var map;
            var gMarkerIcon = {
                path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
                fillColor: '#ffff00',
                fillOpacity: 0.5,
                scale: 1.5,
                strokeColor: '#000000',
                strokeOpacity: 1,
                strokeWeight: 1
            };
            var gMarkerHome = {
                path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
                fillColor: '#ffffff',
                fillOpacity: 0.5,
                scale: 1.5,
                strokeColor: '#000000',
                strokeOpacity: 1,
                strokeWeight: 1
            };
            var markers = [];
            var iterator = 0;
            var marker;

            var PaschimMedinipur = new google.maps.LatLng(22.424, 87.319);
            var Home = new google.maps.LatLng(22.441505, 87.317073);

            var neighborhoods = [
                new google.maps.LatLng(21.989620, 87.346670),
                new google.maps.LatLng(21.957120, 87.384800),
                new google.maps.LatLng(21.960720, 87.411420),
                new google.maps.LatLng(21.980820, 87.399950),
                PaschimMedinipur
            ];

            function initialize() {
                var mapOptions = {
                    zoom: 10,
                    center: PaschimMedinipur
                };

                map = new google.maps.Map(document.getElementById('map-canvas'),
                        mapOptions);
                marker = new google.maps.Marker({
                    position: Home,
                    map: map,
                    draggable: false,
                    animation: google.maps.Animation.DROP,
                    icon: gMarkerHome
                });
                google.maps.event.addListener(marker, 'click', toggleBounce);
            }

            function drop() {
                for (var i = 0; i < neighborhoods.length; i++) {
                    setTimeout(function() {
                        addMarker();
                    }, i * 200);
                }
            }

            function addMarker() {
                marker = new google.maps.Marker({
                    position: neighborhoods[iterator],
                    map: map,
                    draggable: false,
                    animation: google.maps.Animation.DROP,
                    icon: gMarkerIcon
                });
                //markers.push(marker);

                iterator++;
            }

            function toggleBounce() {
                if (marker.getAnimation() !== null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            }

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </head>
    <body>
        <div id="panel" style="margin-left: -52px">
            <button id="drop" onclick="drop()">Drop Markers</button>
        </div>
        <div id="map-canvas"></div>
    </body>
</html>