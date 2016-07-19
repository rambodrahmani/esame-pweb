/* TWITTER JAVASCRIPT SDK */
/* Per maggiori informazioni: https://oauth.io */
/*
	Twitter non ha una una SDK ufficiale (da poco è uscito fabric che però è principalmente pensato per le piattaforme mobile. Ho usato una delle librerie che conoscevo io dato che quelle che consigliavano loro sul loro sito web developers (https://dev.twitter.com/overview/api/twitter-libraries) non sono implementabili con un semplice Javascript client-side e richiedono l'isntallazione di componenti aggiuntivi (quali ad esempio browserify) sul server.
*/
		
function TWLogin() {
	OAuth.initialize('29zBunYflxdmPV5q6iI_uUQlLS8')
	OAuth.popup('twitter')
		.done(function(twitter) {
			// Retrieve your user info
			twitter.me().done(function(me) {
				if (me.id.length > 0)
				{
					var stile = "top=10, left=10, width=550, height=200, status=no, menubar=no, toolbar=no scrollbars=no";							
					
					$.post('php/set_session_variable.php', { 'variable' : 'set_open_twitter_popup_view' });
					
					var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
					
					setTimeout(
						function() {
							if (isSafari)
							{
								alert("Twitter Login - Stai utilizzando Safari per visualizzare il nostro sito: abilita le finestre popup andando su \"Safari -> Preferenze -> Sicurezza\" per poter procedere con il Login Twitter.");
							}
							
							window.open("popup_view.php", "", stile);
						}
					, 500);
				}
			})
	});
}

function submitOnEnter(e) {
	var key;
	
	if (window.event)
		key = window.event.keyCode; //IE
	else
		key = e.which; //Firefox & others

	if(key == 13)
	{
		Accedi();
		return false;
	}
}

/* Pattern Regexp utilizzato: http://www.regular-expressions.info/email.html */

function Accedi() {
	user_email = document.getElementById('user_email').value;
	
    var re = /^(([a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)\b))$/gmi;
	if ( re.test(user_email) )
	{	
		if(user_email.length > 0)
		{
			$.ajax({
				url: 'php/login.php',
				type: 'POST',
				data: {user_email: user_email}
			}).done(function(ajax_response) {
				if (ajax_response == "NOT_REGISTERED")
				{
					alert("Twitter Login - Nessun utente registrato per l'indirizzo email: " + user_email + ".");
					self.close();
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
							window.opener.location.href = "profile.php";
							self.close();
						}
					, 500);
				}
			}).fail(function(error) {
				console.log("Si è verificato un errore: " + error);
			});
		}
		else
		{
			alert("Inserisci un indirizzo email valido per poter continuare.");
		}
	}
	else {
		alert("Inserisci un indirizzo email valido per poter continuare.");
	}
}
