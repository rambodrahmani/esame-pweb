/*
	Il codice sogente che gestisce il login con il social è ovviamente quello predefinito del SDK. Ho modificato la parte in cui vengono ricevute le informazioni dal social per prendere e usare le informazioni relative all'utente di cui avevo bisogno.
*/

// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
	// console.log('statusChangeCallback');
	// console.log(response);
	// The response object is returned with a status field that lets the
	// app know the current login status of the person.
	// Full docs on the response object can be found in the documentation
	// for FB.getLoginStatus().
	if (response.status === 'connected') {
		// Logged into your app and Facebook.
		// FBLogin();
	} else if (response.status === 'not_authorized') {
		// The person is logged into Facebook, but not your app.
		// document.getElementById('status').innerHTML = 'Please log ' + 'into this app.';
	} else {
		// The person is not logged into Facebook, so we're not sure if
		// they are logged into this app or not.
		// document.getElementById('status').innerHTML = 'Please log ' + 'into Facebook.';
	}
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});
}

window.fbAsyncInit = function() {
	FB.init({
		appId      : '347630912072910',
		cookie     : true,  // enable cookies to allow the server to access 
		// the session
		xfbml      : true,  // parse social plugins on this page
		version    : 'v2.1' // use version 2.1
	});

	// Now that we've initialized the JavaScript SDK, we call 
	// FB.getLoginStatus().  This function gets the state of the
	// person visiting this page and can return one of three states to
	// the callback you provide.  They can be:
	//
	// 1. Logged into your app ('connected')
	// 2. Logged into Facebook, but not your app ('not_authorized')
	// 3. Not logged into Facebook and can't tell if they are logged into
	//    your app or not.
	//
	// These three cases are handled in the callback function.
	
	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});
	
};

// Load the SDK asynchronously
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Codice sorgente Facebook JavaScript SDK modificato da Rambod Rahmani:
/*	Ho modificato il codice sorgente di questa parte dell'SDK JavaScript di 
	Facebook perchè il codice sorgente originario permetterva di utilizzare 
	un button predefinito di Facebook Developers, mentre io avevo la 
	necessità di modificare l'aspetto del pulsante in modo da adattarlo al 
	resto della grafica dell'app.*/
function FBLogin() {
	FB.login(function(response) {
		if (response.authResponse) {
			FB.api('/me', function(response) {
				if(response.email.length > 0)
				{
					$.ajax({
						url: 'php/login.php',
						type: 'POST',
						data: {user_email: response.email}
					}).done(function(ajax_response) {
						if (ajax_response == "NOT_REGISTERED")
						{
							alert("Facebook Login - Nessun utente registrato per l'indirizzo email: " + response.email + ".");
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
		} else {
			// user hit cancel button
			// console.log('User cancelled login or did not fully authorize.');
		}
	}, {
		scope: 'publish_stream,email'
	});
}
