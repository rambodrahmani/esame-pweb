/* Controlla che tutti i campi richiesti per creare un nuovo evento siano stati inseriti correttamente. */

function validateNewEventForm()
{
	if (document.getElementById("delete_event_submitted").value == "YES")
	{
		return true;
	}
	
	var file_to_upload = document.forms["event_form"]["file_to_upload"].value;
	if (file_to_upload = "ORIGINAL")
	{
	}
	else {
		var fileToUpload = document.forms["event_form"]["fileToUpload"].value;
		if (fileToUpload == null || fileToUpload == "") {
			alert("Seleziona un'immagine per l'evento.");
			return false;
		}
	}
	
	var event_name = document.forms["event_form"]["event_name"].value;
	if (event_name == null || event_name == "") {
		alert("Inserisci un nome per l'evento.");
		return false;
	}
	
	var event_description = document.forms["event_form"]["event_description"].value;
	if (event_description == null || event_description == "") {
		alert("Inserisci una descrizione per l'evento.");
		return false;
	}
	
	var event_start_date = document.forms["event_form"]["event_start_date"].value;
	if (event_start_date == null || event_start_date == "") {
		alert("Inserisci una data di inizio per l'evento.");
		return false;
	}
	
	var event_end_date = document.forms["event_form"]["event_end_date"].value;
	if (event_end_date == null || event_end_date == "") {
		alert("Inserisci una data di fine per l'evento.");
		return false;
	}
	
	var event_place_name = document.forms["event_form"]["event_place_name"].value;
	if (event_place_name == null || event_place_name == "") {
		alert("Seleziona un luogo per l'evento.");
		return false;
	}
	
	var event_place_id = document.forms["event_form"]["place_google_id"].value;
	if (event_place_id == null || event_place_id == "") {
		alert("Seleziona un luogo per l'evento.");
		return false;
	}
	
	return true;
}

/* Controlla che tutti i campi richiesti per poter eseguire una ricerca testo. */

function validateSearchForm()
{
	var search_query_text = document.forms["event_form_search_bar"]["search_query_text"].value;
	if (search_query_text == null || search_query_text == "") {
		alert("Inserisci il nome del luogo da cercare.");
	}
	
	return false;
}

/* Handler per la pressione del tasto Enter nella textbox contenente il nome della località dell'evento nella pagina edit_event.php. */

function edit_event_form_SubmitOnEnter(e) {
	return locationKeyPressed();
}

/* Handler per la pressione del tasto Enter nella textbox contenente il nome della località dell'evento nella pagina new_event.php. */

function event_form_SubmitOnEnter(e) {
	var key;
	
	if (window.event)
		key = window.event.keyCode; //IE
	else
		key = e.which; //Firefox & others

	if(key == 13)
	{
		return true;
	}
	else
	{
		return locationKeyPressed();
	}
}

/* Impedisce l'inserimento manuale della località dell'evento. */

function locationKeyPressed()
{
	alert("Non puoi inserire la località manualmente. Selezionala utilizzando la mappa e la relativa funzionalità di ricerca.");
	
	return false;
}

/* Impedisce l'inserimento manuale della data dell'evento. */

function dateKeyPressed()
{
	alert("Non puoi inserire la data manualmente. Selezionala utilizzando il calendario presente.");
	
	return false;
}
