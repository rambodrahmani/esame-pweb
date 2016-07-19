<?php
	session_start();
	
	$open_twitter_popup_view = null;
	$open_twitter_popup_view = $_SESSION['open_twitter_popup_view'];
	
	if ($open_twitter_popup_view != "TRUE") {
		header('Location: ' . 'profile.php');
	}
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
	<head>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" type="text/css" href="css/style-popupview.css">
		<meta charset="UTF-8">
		<meta name="author" content="Rambod Rahmani">
		<meta name="description" content="Ubi Web Portal Login">
		<meta name="generator" content="TextMate">
		<title>Ubi - Accedi</title>
        
        <!-- Carico jQuery -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		
        <!-- Funzioni JavaScript utilizzate per terminare il login con Twitter -->
        <script type="text/javascript" src="js/twitter_login.js"></script>
        
        <!-- VALIDATOR: Il validator restituisce come risultato "Passed". -->
	</head>
	
	<body>
    
		<header>
		</header>
		
        <nav>
        </nav>
		
        <section id="content" class="body">
        	<h3>Inserisci il tuo indirizzo email per procedere:</h3>
            <form id="user_email_form" class="user_email_form" onsubmit="return false">
                <input class="text_user_email_form" type="text" id="user_email" onkeyup="return submitOnEnter(event)" ><br>
            </form> 
            
            <div id="tw_signin_wrapper">
				<div id="custom_tw_btn" class="custom_tw_signin" onClick="Accedi();">
					<span class="icon"></span>
					<span class="buttonText">Continua con Twitter</span>
				</div>
			</div>
		</section>
        
		<footer>
		</footer>
        
	</body>
</html>
