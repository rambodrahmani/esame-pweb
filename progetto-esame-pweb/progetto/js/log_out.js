/* Funzione usata per il logout. Cancella tutti i parametri della sessione php. */

function logOut() {
    $.post('php/set_session_variable.php', { 'variable' : 'set_user',
											 'user_id': 0,
											 'user_chat_id': "",
											 'user_email': "",
											 'user_name': "",
											 'user_surname': "",
											 'user_profile_pic': "",
											 'user_profile_url': "",
											 'user_bio': "",
											 'user_birthday': "",
											 'user_gender': "" });
	setTimeout(
		function() {
			window.location.href = "index.php";
		}
	, 500);
}