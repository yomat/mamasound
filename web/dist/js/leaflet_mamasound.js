var mymap;
var markers = new Array;

function InitialiserCarte() {
    mymap = L.map('mapid');

    mymap.on("load", function(){showMarkers()});

    //mymap.setView([ 43.6207009, 3.9033527000000277], 15 );// Montpellier
    mymap.setView([ 47.218371, -1.553621000000021], 15 );// Nantes


    // create the tile layer with correct attribution
    var tileUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';

    var attrib='&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';

    // on paramètre le serveur de tuile
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    // L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v9/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoieW9tYXQiLCJhIjoiY2lybzJwZjg5MDA3Mmhua3dvdmZqZDB1NiJ9.c-b1yAb0XxbFAT9rvgeZHw', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18,
        id: 'yomat.1330ef5f',
        accessToken: 'pk.eyJ1IjoieW9tYXQiLCJhIjoiY2lybzJwZjg5MDA3Mmhua3dvdmZqZDB1NiJ9.c-b1yAb0XxbFAT9rvgeZHw'
    }).addTo(mymap);
}

$(document).ready(function(){
    // 1.1 générer les marqueurs
    initMarkers();

    // 1.2 générer la carte
    InitialiserCarte();
});

function initMarkers() {
    var eventElements = document.getElementsByClassName('event');
    var i;
    for (i = 0; i < eventElements.length; i++) {
        el = eventElements[i]
        var marker =  L.marker([el.getAttribute('data-latitude'), el.getAttribute('data-longitude')]);
        marker.bindPopup(el.getAttribute('data-place-name'));
        markers.push(marker);
    }
}

// 1.3 affiche les marqueurs (cf mymap.on("load"...))
function showMarkers(){
    //alert("3/3: map has loaded! then show markers()")
    var i;
    for(i = 0 ; i < markers.length; i++)
    {
        markers[i].addTo(mymap)
            //.bindPopup('tutu')
            .openPopup();
        //marker = L.marker(markersLatLon[i]).addTo(mymap);
        //     .bindPopup('( ( ( d- -b ) ) )<br>home')
        //     .openPopup();
    }
}

// ajoute un marqueur de position sur la carte
function moveToPlace(latitude, longitude){
    mymap.panTo([latitude, longitude]);
}


//------ AUDIO
// variable to store HTML5 audio element
var music = document.getElementById('music');

function playAudio() {
    if (music.paused) {
        music.play();
        playRadioButton.className = "";
        playRadioButton.className = "pause";
    } else {
        music.pause();
        playRadioButton.className = "";
        playRadioButton.className = "play";
    }
}

