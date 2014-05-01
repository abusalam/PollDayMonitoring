var map;

var Colors = [
    ['9400D3', 'FFFFFF'], ['FF7F00', '000000'],
    ['00FF00', '000000'], ['FF7F00', '000000'],
    ['FFFF00', '000000'], ['4B0082', 'FFFFFF'],
    ['00FF00', '000000'], ['0000FF', 'FFFFFF'],
    ['FFFF00', '000000'], ['FF0000', 'FFFFFF']];

var gMarkerIcon = {
    path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
    fillColor: '#ffff00',
    fillOpacity: 0.5,
    scale: 1.5,
    strokeColor: '#000000',
    strokeOpacity: 1,
    strokeWeight: 1
};
var markers = [];
var iterator = 0;
var markerCluster;
var PaschimMedinipur = new google.maps.LatLng(22.424, 87.319);
var Home = new google.maps.LatLng(22.441505, 87.317073);
var DataPS = [];
var neighborhoods = [];

function initialize() {
    var mapOptions = {
        zoom: 10,
        center: PaschimMedinipur
    };

    map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);
    markerCluster = new MarkerClusterer(map);
    markerCluster.setMaxZoom(12);
}

function drop() {
    for (var i = 0; i < neighborhoods.length; i++) {
        setTimeout(function() {
            addMarker();
        }, i * 10);
    }
}

function addMarker() {
    var marker = new google.maps.Marker({
        position: neighborhoods[iterator],
        map: map,
        draggable: false,
        title: '[AC:' + DataPS[iterator].ACNo + '-PS:' + DataPS[iterator].PSNo + ']-'
                + DataPS[iterator].PSName,
        //animation: google.maps.Animation.DROP,
        icon: 'Marker.php?PSNo=' + DataPS[iterator].PSNo
                + '&ColorAC=' + Colors[((DataPS[iterator].ACNo - 219) % 9)][0]
                + '&ColorPS=' + Colors[((DataPS[iterator].ACNo - 219) % 9)][1]
    });

    google.maps.event.addListener(marker, 'click', function() {
        toggleBounce(marker);
    });

    markers.push(marker);
    markerCluster.addMarker(marker);
    iterator++;
}

function toggleBounce(marker) {
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