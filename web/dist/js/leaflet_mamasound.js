function InitialiserCarte() {
    var mymap = L.map('mapid').setView([ 43.609, 3.874], 15 );

    // create the tile layer with correct attribution
    var tileUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';

    var attrib='&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';

    // L.TileLayer(tileUrl, {minZoom: 8, maxZoom: 18, attribution: attrib}).addTo(map);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    //L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v9/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoieW9tYXQiLCJhIjoiY2lybzJwZjg5MDA3Mmhua3dvdmZqZDB1NiJ9.c-b1yAb0XxbFAT9rvgeZHw', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18,
        id: 'yomat.1330ef5f',
        accessToken: 'pk.eyJ1IjoieW9tYXQiLCJhIjoiY2lybzJwZjg5MDA3Mmhua3dvdmZqZDB1NiJ9.c-b1yAb0XxbFAT9rvgeZHw'
    }).addTo(mymap);

}

$(document).ready(function(){
    InitialiserCarte();
});

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