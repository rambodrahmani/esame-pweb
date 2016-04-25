/* Esegue la radar_search e ne mostra i contenuti nella listbox (dopo averla definita) che si trova sotto la mappa. */

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

var infowindow;
var savedPlaces = [];

function radar_search(location) {
	$.ajax({
		url: 'php/radar_search.php',
		type: 'POST',
		data: { location: location,
				place_types: ''}
	}).done(function(ajax_response) {
		if (ajax_response == "NO_PLACES_AVAILABLE")
		{
			//alert("La radar search non ha prodotto risultati.");
		}
		else
		{
			var json_parsed = JSON.parse(ajax_response);
			
			var source = [];

			for (i = 0; i < json_parsed.length; i++) {
				infowindow = new google.maps.InfoWindow();
				
				var customLocation = {
					lat: json_parsed[i]['place_lat'],
					lon: json_parsed[i]['place_lon'],
					name: json_parsed[i]['place_name']
				};
				
				createMarker_RS(customLocation);
				
				var imgurl = json_parsed[i]['place_icon_url'];
				var img = '<img height="48" width="48" src="' + imgurl + '"/>';
				var html = '<div style="display: block; width: 100%;"><div style="width: 50px; display: inline-block; float:left; padding-right: 10px;">' + img + '</div><div style="display: inline-block; float:left;"><div style="padding-bottom: 8px;">' + reduce_text(json_parsed[i]['place_name']) + '</div><div>' + reduce_text(json_parsed[i]['place_string']) + '</div></div></div>';
				
				source.push({label: json_parsed[i]['place_name'], value: json_parsed[i]['place_google_id'], html: html});
				
				var newCustomPlace = {place_name: json_parsed[i]['place_name'], localization: customLocation};
				savedPlaces.push(newCustomPlace);
			}
						
			$("#listbox").jqxListBox({ selectedIndex: 0, theme: 'fresh', source: source, width: "100%", height: 400 });
			
			
			$('#listbox').on('select', function (event) {
				var args = event.args;
				if (args) {
					var index = args.index;
					var item = args.item;
					var label = item.label;
					var value = item.value;
					
					oFormObject = document.forms['event_form'];
					oFormObject.elements["event_place_name"].value = label;
					oFormObject.elements["place_google_id"].value = value;

					var pos = new google.maps.LatLng(savedPlaces[index].localization.lat, savedPlaces[index].localization.lon);
					var marker = new google.maps.Marker({
						position: pos,
						map: map,
						title: savedPlaces[index].place_name
					});
					infowindow.setContent(savedPlaces[index].place_name);
					infowindow.open(map, marker);
				}
			});
			
			document.getElementById("loading_label").style.display = 'none';
		}
	}).fail(function(error) {
		console.log("Si è verificato un errore: " + error);
	});
}

function createMarker_RS(place)
{
	var pos = new google.maps.LatLng(place.lat, place.lon);
	var marker = new google.maps.Marker({
		position: pos,
		map: map,
		title: place.name
	});
	
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.setContent(place.name);
		infowindow.open(map, this);
	});
}
