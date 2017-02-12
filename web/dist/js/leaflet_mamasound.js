var mymap;
var markers = [];

var selected_date; // TODO current
var selected_eventType = "all_events";

var events = [];

var center_div;
var place_div;
var event_div;

$(document).ready(function(){
    // I. charger les événements du jour
    center_div = $('#center');
    $.ajax({
        url: Routing.generate('events', {}),
        method: "POST"
    }).done(function(msg){
        center_div.html(msg);
        initMarkers();
        initialiserCarte();
    });
});

// II. MAP
// 1.1 générer les marqueurs
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

// 1.2 générer la carte
function initialiserCarte() {
    mymap = L.map('mapid');

    mymap.on("load", function(){showMarkers()});

    //mymap.setView([ 43.6207009, 3.9033527000000277], 15 );// Montpellier
    mymap.setView([ 47.218371, -1.553621000000021], 15 );// Nantes


    // create the tile layer with correct attribution
    var tileUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';

    //var attrib='&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';

    // on paramètre le serveur de tuile
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        // L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v9/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoieW9tYXQiLCJhIjoiY2lybzJwZjg5MDA3Mmhua3dvdmZqZDB1NiJ9.c-b1yAb0XxbFAT9rvgeZHw', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18,
        id: 'yomat.1330ef5f',
        accessToken: 'pk.eyJ1IjoieW9tYXQiLCJhIjoiY2lybzJwZjg5MDA3Mmhua3dvdmZqZDB1NiJ9.c-b1yAb0XxbFAT9rvgeZHw'
    }).addTo(mymap);
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
var music = document.getElementById('music'); // TODO : init when document ready

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

// --- AJAX : détail de l'événement

var event_id = 1;

// mettre à jour les données de la div center avec la vue
function setEventDetail_toCenterDiv(event_id){
    center_div = $('#center');
    $.ajax({
        url: Routing.generate('event_detail', { id: event_id }),
        method: "POST"
    }).done(function(msg){
        center_div.html(msg);
    });
}

// mettre à jour les données de la div place small
function setPlaceDetailSmall(place_id){
    place_div = $('#place-detail-small');
    $.ajax({
        url: Routing.generate('place_detail_small', { id: place_id }),
        method: "POST"
    }).done(function(msg){
        place_div.html(msg);
    });
}

// mettre à jour les données de la div place small
function setEventDetailSmall(event_id){
    event_div = $('#event_detail_small');
    $.ajax({
        url: Routing.generate('event_detail_small', { id: event_id }),
        method: "POST"
    }).done(function(msg){
        event_div.html(msg);
    });
}

// les évenements pour une date donnée
function getEventsAt(date){
    selected_date = date;
    center_div = $('#center');
    $.ajax({
        url: Routing.generate('events', { date: date }),
        method: "POST"
    }).done(function(msg){
        center_div.html(msg);
    });
}

// les évenements pour une date donnée
function getEventsOfType(eventType){
    selected_eventType = eventType;
    center_div = $('#center');
    $.ajax({
        url: Routing.generate('events', { eventType: eventType}),
        method: "POST"
    }).done(function(msg){
        center_div.html(msg);
        setPaddingTohideScrollbar()
    });
}

// ajouter un événement
function listEvents(){
    center_div = $('#center');
    $.ajax({
        url: Routing.generate('events', {}),
        method: "POST"
    }).done(function(msg){
        center_div.html(msg);
    });
}

// ajouter un événement
function newEvent(){
    center_div = $('#center');
    $.ajax({
        url: Routing.generate('new_event'),
        method: "GET"
    }).done(function(msg){
        center_div.html(msg);
    });
}

// UI behaviour

// trigger event after mouse overing an element during a certain period
function delayOver(elem, callback, delay) {
    var timeout = null;
    elem.onmouseover = function() {
        // Set timeout to be a timer which will invoke callback after 1s
        timeout = setTimeout(callback, delay);
    };

    elem.onmouseout = function() {
        // Clear any timers set to timeout
        clearTimeout(timeout);
    }
};


