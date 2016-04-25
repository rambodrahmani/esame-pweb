/* Carica gli eventi creati dall'utente che si trovano nel Database principale di Ubi */

var selected_event_id;

function mobileEdit()
{
	window.location.href = "edit_event.php?selected_event=" + selected_event_id;
}

/*
	Nel caso in cui il testo contenuto nel campo "event_name" o "event_description" di un evento sia troppo lungo viene accorciato
	e vengono inseriti i tre puntini alla fine.
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

$(document).ready(function () {
	$.ajax(
		{
			url: "php/get_session_credentials.php",
			cache: false
		})
		.done(function(result)
		{
			var session_credentials = $.parseJSON(result);
			var user_id = session_credentials['user_id'];
			
			$.ajax({
				url: 'php/read_user_events.php',
				type: 'POST',
				data: {user_id: user_id}
			}).done(function(ajax_response) {
				if (ajax_response == "NO_EVENTS_AVAILABLE")
				{
					//alert("L'utente non ha ancora inserito nemmeno un evento.");
				}
				else {						
					var json_parsed = JSON.parse(ajax_response);
					selected_event_id = json_parsed[0]['event_id'];
					
					var source = [];
					
					for (i = 0; i < json_parsed.length; i++) {
						var imgurl = json_parsed[i]['event_picture_url'];
						var img = '<img class="listbox" src="' + imgurl + '"/>';
						var html = '<table class="listbox"><tr><td class="listbox_pic" rowspan="3">' + img + '</td><td><p class="listbox">' + reduce_text(json_parsed[i]['event_name']) + '</p><a class="listbox" href="edit_event.php?selected_event=' + json_parsed[i]['event_id'] + '">Modifica</a></td></tr><tr><td><p class="listbox">' + reduce_text(json_parsed[i]['event_description']) + '</p></td></tr><tr><td><p class="listbox">Dal ' + json_parsed[i]['event_start_date'] + ' al ' + json_parsed[i]['event_end_date'] + '</p></td></tr></table>';
						
						source.push({label: json_parsed[i]['event_name'], value: json_parsed[i]['event_id'], html: html});
					}
								
					$("#listbox").jqxListBox({ selectedIndex: 0, theme: 'fresh', source: source, width: "100%", height: 400 });
					
					$('#listbox').on('select', function (event) {
						var args = event.args;
						if (args) {
							var index = args.index;
							var item = args.item;
							var originalEvent = args.originalEvent;
							var label = item.label;
							var value = item.value;
							
							selected_event_id = value;
						}
					});
				}
			}).fail(function(error) {
				console.log("Si è verificato un errore: " + error);
			});
		}
	);
});
