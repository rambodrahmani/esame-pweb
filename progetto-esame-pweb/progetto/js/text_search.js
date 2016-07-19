/* Funzioni utilizzate per eseguire una ricerca testo sulla mappa. */

/*
	Nel caso in cui il testo passato come argomento "string" sia più del valore specificato in "length" allora la funzione lo accorcia a un numro di caratteri non superiore a "length", senza tagliare le parole e inserendo i tre puntini alla fine.
*/

function reduce_text(string) {
	if (!string) { return string; }
	
	append = "&hellip;";
	length = 40;
	
	if (string.length > length) {
		var regex = '.{1,' + length + '}(\\s|$)' + '|\\S+?(\\s|$)';
		string = string.match( RegExp(regex, 'g') ).join('\n'); 
		string = string.split("\n", 2);
		string = string[0] + append;
	}
	
	return string;
}

function search_form_submitOnEnter(e) {
	var key;
	
	if (window.event)
		key = window.event.keyCode; //IE
	else
		key = e.which; //Firefox & others
	
	if(key == 13)
	{
		TextSearch();
		return false;
	}
}

function TextSearch() {
	var query_text = document.getElementById('search_query_text').value;

	var request = {
		query: query_text,
		location: pos,
		radius: 500
	};
	
	var service = new google.maps.places.PlacesService(map);
	service.textSearch(request, callback);
}

function callback(results, status) {
	if (status == google.maps.places.PlacesServiceStatus.OK) {
		for (var i = 0; i < results.length; i++) {
			var place = results[i];
			createMarker(place);
			
			var imgurl = place.icon;
			var img = '<img height="48" width="48" src="' + imgurl + '"/>';
			var html = '<div style="display: block; width: 100%;"><div style="width: 50px; display: inline-block; float:left; padding-right: 10px;">' + img + '</div><div style="display: inline-block; float:left;"><div style="padding-bottom: 8px;">' + reduce_text(place.name) + '</div><div>' + reduce_text(place.formatted_address) + '</div></div></div>';
						
			$("#listbox").jqxListBox('insertAt', {label: place.name, value: place.place_id, html: html}, 0);
			
			var customLocation = {
				lat: place.geometry.location.k,
				lon: place.geometry.location.D,
			};
			var newCustomPlace = {place_name: place.name, localization: customLocation};
			savedPlaces.unshift(newCustomPlace);
		}
	}
	else
	{
		alert("Si è verificato un errore durante l'esecuzione della ricerca: " + status);
	}
}

function createMarker(place) {
	var placeLoc = place.geometry.location;
	var marker = new google.maps.Marker({
		map: map,
		position: place.geometry.location
	});
	
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.setContent(place.name);
		infowindow.open(map, this);
	});
}
