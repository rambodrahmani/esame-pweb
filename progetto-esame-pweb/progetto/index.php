<?php
	session_start();
	
	$_SESSION['open_twitter_popup_view'] = "FALSE";
	
	$user_id = null;
	$user_id = $_SESSION['user_id'];
	
	if ($user_id > 0) {
		header('Location: ' . 'profile.php');
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
	<head>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" type="text/css" href="css/style-index.css">
		<meta charset="UTF-8">
		<meta name="author" content="Rambod Rahmani">
		<meta name="description" content="Ubi Web Portal Login">
		<meta name="generator" content="TextMate">
		<title>Ubi - Accedi</title>

		<!-- Carico jQuery -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        
		<script type="text/javascript">
			$(window).load(function() {
				$(".cover").fadeOut(2000);
			})	
		</script>
        
		<!-- PACE: An automatic web page progress bar. -->
		<!--
        	I processi che riguardano il login con i tre social network  possono essere lunghi, quindi ho implementato questa progress bar utilizzando questa libreria JavaScript e CSS esterna in maniera che l'utente non si ritrovi con una pagina bianca che carica.
        	La libreria esterna richiede ovviamente il file .js per la progress bar e un file .css contenente uno degli stili disponibili.
		-->
		<!-- Per maggiori informazioni: http://github.hubspot.com/pace/ -->
		<script type="text/javascript" src="js/pace.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style-pace.css" />

		<!-- FACEBOOK JAVASCRIPT SDK-->
		<!-- Per maggiori informazioni: https://developers.facebook.com/docs/facebook-login/login-flow-for-web/v2.2 -->
		<script type="text/javascript" src="js/facebook_login.js"></script>

        <!-- TWITTER JAVASCRIPT SDK-->
		<!-- Per maggiori informazioni: https://oauth.io -->
        <!--
        	Twitter non ha una una SDK ufficiale (da poco è uscito fabric che però è principalmente pensato per le piattaforme mobile). Ho usato una delle librerie che conoscevo io dato che quelle che consigliavano loro sul loro sito web developers (https://dev.twitter.com/overview/api/twitter-libraries) non sono implementabili con un semplice Javascript client-side e richiedono l'isntallazione di componenti aggiuntivi (quali ad esempio browserify) sul server.
		-->
        <script type="text/javascript" src="oauthjs/dist/oauth.js"></script>
		<script type="text/javascript" src="js/twitter_login.js"></script>
        
		<!-- GOOGLE PLUS JAVASCRIPT SDK-->
		<!-- Per maggiori informazioni: https://developers.google.com/+/web/signin/javascript-flow -->
		<meta name="google-signin-clientid" content="586980769222-drg928p1e8cqk974o63ug5cfcv317jd1.apps.googleusercontent.com" />
		<meta name="google-signin-scope" content="https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email" />
		<meta name="google-signin-requestvisibleactions" content="http://schema.org/AddAction" />
		<meta name="google-signin-cookiepolicy" content="single_host_origin" />
		<script type="text/javascript" src="js/gp_login.js"></script>
		<script type="text/javascript" src="https://apis.google.com/js/client:platform.js" async defer></script>

        <!--
        	VALIDATOR: Il validator restituisce come risultato "4 Errors, 1 warning(s)".
			Per quanto riguarda i quattro errori che vengono segnalati, la questione non è colpa del codice sorgente che ho scritto ma colpa o di Google oppure del Validator che non è aggiornato: sono relativi ai valori dati all'atributo "name" dei tag "meta" utilizzati per impostare i parametri necessari per configurare il login con Google+. Infatti, dato che ho utilizzato il tipo di documenti HTML5, tutti i valori che vengono specificati per l'attributo "name" del tag "meta" devono essere registrati presso un ente determinato: o Google non ha registrato i propri valori, oppure il validator non è stato aggiornato per quei nuovi valori registrati da Google. Per quanto riguarda il 1 warning(s) generato: è dovuto al fatto che il validator usa funzionalità BETA per testare i documenti di tipo HTML5 (e lo segnala ogni volta come warning anche se il risultato della verifica è passed)
		-->
	</head>
	
	<body>
		<div class="cover">
		</div>

		<header>
			<img class="logo" src="img/ubi_logo.png" alt="">
		</header>
		
		<nav></nav>
		
        <!--
        	Non ho utilizzato il tag section anche se dovrebbe essere utilizzato dal punto di vista del concetto "tematico" introdotto in HTML5 per evitare un warning del validator che obbliga tutte le section html5 ad avere un elemento h2-h6 che ne chiarisca il contenuto.
        -->
		<div id="content" class="body">
			<!--
            	Ho ricreato il pulsante di Login per il Facebook SDK utilizzando gli elementi div e span in modo da ottenere una portabilità maggiore rispetto all'utilizzo di una immagine statica.
			-->
            <div id="fb-root">
			</div>
			<div id="fb_signin_wrapper">
				<div id="custom_fb_btn" class="custom_fb_signin" onClick="FBLogin();">
					<span class="icon"></span>
					<span class="buttonText">Login con Facebook</span>
				</div>
			</div>
			
            <!--
            	Ho ricreato il pulsante di Login per il Twitter SDK utilizzando gli elementi div e span in modo da ottenere una portabilità maggiore rispetto all'utilizzo di una immagine statica.
			-->
			<div id="tw_signin_wrapper">
				<div id="custom_tw_btn" class="custom_tw_signin" onClick="TWLogin();">
					<span class="icon"></span>
					<span class="buttonText">Login con Twitter</span>
				</div>
			</div>
            
            <!--
            	Ho ricreato il pulsante di Login per il Google+ SDK utilizzando gli elementi div e span in modo da ottenere una portabilità maggiore rispetto all'utilizzo di una immagine statica.
			-->
			<div id="gp_signin_wrapper">
				<div id="custom_gp_btn" class="custom_gp_signin" onClick="GPLogin();">
					<span class="icon"></span>
					<span class="buttonText">Login con Google+</span>
				</div>
			</div>
		</div>
        
		<footer>
        </footer>
	</body>
</html>
