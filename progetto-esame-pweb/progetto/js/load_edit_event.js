/*
	Carica le informaizoni necessarie alla pagina "edit_event.php". Sono presenti anche le funzioni che controllano se l'utente vuole modificare l'evento oppure eliminarlo.
*/

$(document).ready(function () {
	$.ajax(
		{
			url: "php/get_session_credentials.php",
			cache: false
		})
		.done(function(result)
		{
			var session_credentials = $.parseJSON(result);
			var selected_event_id = session_credentials['selected_event_id'];
			var user_id = session_credentials['user_id'];
			
			$.ajax({
				url: 'php/read_event_info.php',
				type: 'POST',
				data: {	event_id: selected_event_id,
						user_id: user_id}
			}).done(function(ajax_response) {
				if (ajax_response == "NO_EVENTS_AVAILABLE")
				{
					console.log("Informazioni realtive all'evento non disponibili.");
				}
				else {
					var json_parsed = JSON.parse(ajax_response);
					var oFormObject = document.forms['event_form'];
					oFormObject.elements["event_id"].value = json_parsed[0]['event_id'];
					oFormObject.elements["event_name"].value = json_parsed[0]['event_name'];
					oFormObject.elements["event_description"].value = json_parsed[0]['event_description'];
					
					var event_start_date = json_parsed[0]['event_start_date'];
					var parts = event_start_date.split(" ");
					var date_parts = parts[0].split("-");
					var hour_parts = parts[1].split(":");
					oFormObject.elements["event_start_date"].value = json_parsed[0]['event_start_date'];
					$('#jqxDateTimeInput1').jqxDateTimeInput('setDate', new Date(date_parts[0], (date_parts[1] - 1), date_parts[2], hour_parts[0], hour_parts[1], hour_parts[2]));
					
					var event_end_date = json_parsed[0]['event_end_date'];
					var parts = event_end_date.split(" ");
					var date_parts = parts[0].split("-");
					var hour_parts = parts[1].split(":");
					oFormObject.elements["event_end_date"].value = json_parsed[0]['event_end_date'];
					$('#jqxDateTimeInput2').jqxDateTimeInput('setDate', new Date(date_parts[0], (date_parts[1] - 1), date_parts[2], hour_parts[0], hour_parts[1], hour_parts[2]));
					
					oFormObject.elements["event_place_name"].value = json_parsed[0]['place_name'];
					oFormObject.elements["place_google_id"].value = json_parsed[0]['place_google_id'];
					
					oFormObject.elements["event_picture_url"].value = json_parsed[0]['event_picture_url'];
					oFormObject.elements["file_to_upload"].value = "ORIGINAL";
					
					document.getElementById("previewing").src = json_parsed[0]['event_picture_url'];
					document.getElementById("previewing").style.display = "block";
					document.getElementById("previewing").style.visibility = "visibile";
					document.getElementById("image_preview").style.display = "block";
					document.getElementById("image_preview").style.visibility = "visibile";
				}
			}).fail(function(error) {
				console.log("Si è verificato un errore: " + error);
			});
		}
	);
});

/* Imposta quale delle azioni debba essere eseguita dal file post_event.php */

function setEditEvent() {
	document.getElementById("edit_event_submitted").value = "YES";
}

/* Imposta quale delle azioni debba essere eseguita dal file post_event.php */

function setDeleteEvent() {
	if (confirm("Sei sicuro di voler eliminare l'evento selezionato?")) {
		document.getElementById("delete_event_submitted").value = "YES";
	} else {
		document.getElementById("delete_event_submitted").value = "ABORT";
	}
}
