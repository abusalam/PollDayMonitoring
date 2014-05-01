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
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
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
                marker = new google.maps.Marker({
                    position: Home,
                    map: map,
                    draggable: false,
                    animation: google.maps.Animation.DROP
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
                    icon: 'http://10.173.168.128/PollDayMonitoring/Marker.php?PSNo=300&Color=FF0000'
                });
                markers.push(marker);

                iterator++;
            }

            function toggleBounce() {
                if (marker.getAnimation() !== null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            }

            function RemoveMarkers() {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </head>
    <body>
        <div id="panel">
            <div style="float:left;">
                <label for="pc">
                    <span>PC:</span>
                    <select name="pc" id="pc" style="width:150px">
                        <option value="%" selected>--Please select--</option>
                        <option value="33" >33-Jhargram</option>
                        <option value="34" >34-Medinipur</option>
                        <option value="32" >32-Ghatal</option>
                    </select>
                </label>
            </div>
            <div style="float:left;">
                <label for="ac">
                    <span>AC:</span>
                    <select name="ac" id="ac" style="width:150px">
                        <option value="%" selected>-- Please Select --</option>
                    </select>
                </label>
            </div>
            <button id="drop" onclick="drop()">Show</button>
            <button id="hide" onclick="RemoveMarkers()">Remove</button>
            <hr style="clear: both;"/>
            <div id="filters">
                <input type="checkbox" id="Critical">
                <label for="Critical">Critical</label>
                <input type="checkbox" id="MSZ">
                <label for="MSZ">Mobile Shadow Zone</label>
                <input type="checkbox" id="Vulnerable">
                <label for="Vulnerable">Vulnerable</label>
            </div>
        </div>
        <div id="map-canvas"></div>
        <script>
            $("#filters").buttonset();
        </script>
    </body>
</html>