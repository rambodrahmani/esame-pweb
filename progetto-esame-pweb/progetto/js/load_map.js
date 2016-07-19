/* Carica la mappa, inserisce il marker per la posizione dell'utente e chiama la radar search */

var map;
var pos;
var infowindow;

function initialize() {
	var mapOptions = {
		zoom: 16
	};
	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

	// Try HTML5 geolocation
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			
			map.setCenter(pos);
			
			infowindow = new google.maps.InfoWindow();
			
			var user_infowindow = new google.maps.InfoWindow({
				map: map,
				position: pos,
				content: 'La tua posizione.'
			});

			var marker = new google.maps.Marker({
				position: pos,
				map: map,
				title: 'La tua posizione.'
			});
			
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.setContent('La tua posizione.');
				infowindow.open(map, this);
			});

			var user_location = pos['k'] + "," + pos['D'];
			radar_search(user_location);
			
		}, function() {
			handleNoGeolocation(true);
		});
	} else {
		handleNoGeolocation(false);
	}
}

function handleNoGeolocation(errorFlag) {
	if (errorFlag) {
		var content = 'Geolocalizzazione fallita.';
	} else {
		var content = 'Geolocalizzazione non supportata.';
	}

	var options = {
		map: map,
		position: new google.maps.LatLng(60, 105),
		content: content
	};

	var infowindow = new google.maps.InfoWindow(options);
	map.setCenter(options.position);
	
	alert("Non è stato possibile geaolocalizzarti sulla mappa. Assicurati che la geolocalizzazione sia abilitata e funzionante per poter procedere.");
}

google.maps.event.addDomListener(window, 'load', initialize);
