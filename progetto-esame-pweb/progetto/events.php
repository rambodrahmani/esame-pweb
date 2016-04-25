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
		<link rel="stylesheet" type="text/css" href="css/style-events.css">
		<meta charset="UTF-8">
		<meta name="author" content="Rambod Rahmani">
		<meta name="description" content="Ubi Web Portal Eventi">
		<meta name="generator" content="TextMate">
		<title>Ubi - Eventi</title>

		<!-- Carico jQuery -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        
        <!-- jqwidgets-ver3.6.0 -->
        <!-- Carico gli elementi necessari per jqxListBox -->
        <!--
        	Per realizzare la listabox personalizzata ho utilizzato la libreria "jqwidgets-ver3”. Il pacchetto completo pesa circa 24MB, ma io ho selezionato solamente i file sorgenti di cui avevo bisogno per la listbox personalizzata. Non ho utilizzato nessuna delle loro immagini o demo. L’intero codice è differente da quello presente nella loro documentazione.
		-->
		<!-- Per maggiori informazioni: http://www.jqwidgets.com/ -->
        <link rel="stylesheet" href="jqwidgets-ver3/jqwidgets/styles/jqx.base.css" type="text/css" />
		<link rel="stylesheet" href="jqwidgets-ver3/jqwidgets/styles/jqx.fresh.css" type="text/css" />
		<script type="text/javascript" src="jqwidgets-ver3/jqwidgets/jqxcore.js"></script>
		<script type="text/javascript" src="jqwidgets-ver3/jqwidgets/jqxbuttons.js"></script>
		<script type="text/javascript" src="jqwidgets-ver3/jqwidgets/jqxscrollbar.js"></script>
		<script type="text/javascript" src="jqwidgets-ver3/jqwidgets/jqxlistbox.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3/jqwidgets/jqxdata.js"></script>
        
        <!-- Carica gli eventi creati dall'utente che si trovano nel Database principale di Ubi -->
        <script type="text/javascript" src="js/load_user_events.js"></script>
        
		<!-- PACE: An automatic web page progress bar. -->
		<!-- Per maggiori informazioni: http://github.hubspot.com/pace/ -->
		<script type="text/javascript" src="js/pace.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style-pace-2.css" />

		<!-- Log out script -->
        <script type="text/javascript" src="js/log_out.js"></script>
        
        <!-- VALIDATOR: Il validator restituisce come risultato "Passed". -->
	</head>
	
	<body>
		<header>
		</header>
		
        <nav role="navigation">
            <p>Ubi</p>
            <p><a class="" href="profile.php">Account</a></p>
            <p><a class="selected" href="events.php">Eventi</a></p>
            <p><a class="logout" href="#" onClick="logOut();">Logout</a></p>
            <p class="welcome" style="float:right;">
				Ciao <?php echo $_SESSION['user_name']; ?>!
			</p>
        </nav>
		
		<section id="content" class="body">
        	<div id="user_events">
				<h3>I Tuoi Eventi</h3><a class="mobile_edit" href="#" onClick="mobileEdit();">Modifica</a>
                <div id="listbox">
				</div>
                
                <div id="btn_add_event_wrapper">
	                <a href="new_event.php">
						<div id="custom_add_event_btn" class="custom_add_event_btn">
							<span class="buttonText">Nuovo Evento</span>
						</div>
					</a>
	            </div>
            </div>
		</section>
		
		<footer></footer>
	</body>
</html>
