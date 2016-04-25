/*
	Il codice sogente che gestisce il login con il social è ovviamente quello predefinito del SDK. Ho modificato la parte in cui vengono ricevute le informazioni dal social per prendere e usare le informazioni relative all'utente di cui avevo bisogno.
*/

function signinCallback(authResult) {
	if (authResult['status']['signed_in']) {
		// Update the app to reflect a signed in user
		// Hide the sign-in button now that the user is authorized, for example:
		// document.getElementById('gp_signinButton').setAttribute('style', 'display: none');
		
		/*
			La funzione signinCallback viene chiamata ogni volta che lo stato
			del login dell'utente varia.
			Per evitare che l'alert venga inviato due volte controllo che
			il metodo con cui è stato ottenuto lo status dell'utente sia
			tramite PROMPT e non AUTO
		*/
		if (authResult['status']['method'] == 'PROMPT') {
			gapi.client.load('plus','v1', function(){
				var request = gapi.client.plus.people.get({
					'userId': 'me'
				});
				request.execute(function(resp) {
					//console.log('Retrieved profile for:' + resp.emails[0].value);
					if(resp.emails[0].value.length > 0)
					{
						$.ajax({
							url: 'php/login.php',
							type: 'POST',
							data: {user_email: resp.emails[0].value}
						}).done(function(ajax_response) {
							if (ajax_response == "NOT_REGISTERED")
							{
								alert("Google Plus Login - Nessun utente registrato per l'indirizzo email: " + resp.emails[0].value + ".");
							}
							else {
								var json_parsed = JSON.parse(ajax_response);
								$.post('php/set_session_variable.php', { 'variable' : 'set_user',
																		 'user_id': parseInt(json_parsed['user_id']),
																		 'user_chat_id': json_parsed['user_chat_id'],
																		 'user_email': json_parsed['user_email'],
																		 'user_name': json_parsed['user_name'],
																		 'user_surname': json_parsed['user_surname'],
																	 	 'user_profile_pic': json_parsed['user_profile_pic'],
																	 	 'user_profile_url': json_parsed['user_profile_url'],
																		 'user_bio': json_parsed['user_bio'],
																		 'user_birthday': json_parsed['user_birthday'],
																		 'user_gender': json_parsed['user_gender'] });
								setTimeout(
									function() {
										window.location.href = "profile.php";
									}
								, 500);
							}
						}).fail(function(error) {
							alert("Si è verificato un errore: " + error);
						});
					}
				});
			});
		}
	} else {
		// Update the app to reflect a signed out user
		// Possible error values:
		//   "user_signed_out" - User is signed-out
		//   "access_denied" - User denied access to your app
		//   "immediate_failed" - Could not automatically log in the user
		console.log('Sign-in state: ' + authResult['error']);
	}
}

function GPLogin() {
	var additionalParams = {
		'callback': signinCallback
	};
	
	gapi.auth.signIn(additionalParams); // Will use page level configuration
}
