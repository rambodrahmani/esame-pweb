<?php
	session_start();
	
	$user_id = null;
	$user_id = $_SESSION['user_id'];
	
	if ( !($user_id > 0) ) {
		header('Location: ' . 'index.php');
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
	<head>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" type="text/css" href="css/style-profile.css">
		<meta charset="UTF-8">
		<meta name="author" content="Rambod Rahmani">
		<meta name="description" content="Ubi Web Portal Profilo">
		<meta name="generator" content="TextMate">
		<title>Ubi - Profilo</title>

		<!-- Carico jQuery -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        
		<!-- PACE: An automatic web page progress bar. -->
		<!-- Per maggiori informazioni: http://github.hubspot.com/pace/ -->
		<script type="text/javascript" src="js/pace.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style-pace-2.css" />

		<!-- Log out script -->
        <script type="text/javascript" src="js/log_out.js"></script>
        
        <script type="text/javascript">
			function openNewEvent() {
				window.opener.document.location.href = "new_event.php";
			}
		</script>
        
        <!--
        	VALIDATOR: Il validator restituisce come risultato "1 Error, 1 warning(s)". L'errore "Line 47, Column 48: Bad value for attribute src on element img: Must be non-empty." credo sia dovuto al fatto che il sito si basa su una sessione PHP che non è presente quando si esegue il test utilizzando il validator: il che fa risultare l'url dell'immagine profilo dell'utente uguale a null. Controllando dalla console l'elemento img ha sempre un URL valido quando la pagina viene caricata.
            Il Warning è il solito avvertimento di utilizzo di un validatore sperimentale dato che ho utilizzato HTML 5.
		-->
	</head>
	
	<body>
		<header>
		</header>
		
        <nav role="navigation">
            <p>Ubi</p>
            <p><a class="selected" href="#">Account</a></p>
			<p><a class="" href="events.php">Eventi</a></p>
            <p><a class="logout" href="#" onClick="logOut();">Logout</a></p>
            <p class="welcome" style="float:right;">
				Ciao <?php echo $_SESSION['user_name']; ?>!
			</p>
        </nav>
		
		<div id="content" class="body">
        	<div id="user_info">
				<?php
		            echo '<img class="user_profile_pic" alt="' . $_SESSION['user_name'] . '" src="' . $_SESSION['user_profile_pic'] . '">';
	            ?>
                
                <p class="user_full_name">
					<?php echo $_SESSION['user_name']; ?> <?php echo $_SESSION['user_name']; ?>
				</p>
				
				<div>
					<hr class="custom-style">
				</div>
				
                <p class="user_bio">
	                <!--
                    	Il parametro Bio del profilo degli utenti viene tagliato se troppo lungo in modo da preservare la grafica.
					-->
					<?php
						$append = "&hellip;";
						$length = 1000;
						$string = trim($_SESSION['user_bio']);
							
						if(strlen($string) > $length) {
							$string = wordwrap($string, $length);
							$string = explode("\n", $string, 2);
							$string = $string[0] . $append;
						}
						
						echo $string;
					?>
				</p>
				
				<div>
					<hr class="custom-style">
				</div>
                
                <div id="btn_add_event_wrapper">
	                <a href="new_event.php">
						<div id="custom_add_event_btn" class="custom_add_event_btn">
							<span class="buttonText">Nuovo Evento</span>
						</div>
					</a>
	            </div>
            </div>
		</div>
		
		<footer></footer>
	</body>
</html>
