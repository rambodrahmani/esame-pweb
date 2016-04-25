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
		<link rel="stylesheet" type="text/css" href="css/style-new-event.css">
		<meta charset="UTF-8">
		<meta name="author" content="Rambod Rahmani">
		<meta name="description" content="Ubi Web Portal Login">
		<meta name="generator" content="TextMate">
		<title>Ubi - Nuovo Evento</title>

		<!-- Carico jQuery -->
		<script  type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

		<!-- PACE: An automatic web page progress bar. -->
		<!-- Per maggiori informazioni: http://github.hubspot.com/pace/ -->
		<script type="text/javascript" src="js/pace.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style-pace-2.css" />

		<!-- Log out script -->
        <script  type="text/javascript" src="js/log_out.js"></script>
        
        <!-- Google Maps JavaScript API v3 -->
        <!-- Google Maps JavaScript API v3 - Places Library -->
        <!-- Per maggiori informazioni consultare: https://developers.google.com/maps/documentation/javascript/examples/map-geolocation -->
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;libraries=places&amp;signed_in=true"></script>
        <!-- Carica la mappa, inserisce il marker per la posizione dell'utente e chiama la radar search. -->
        <script type="text/javascript" src="js/load_map.js"></script>
        <!-- Esegue la radar_search e ne mostra i contenuti nella listbox che si trova sotto la mappa. -->
        <script type="text/javascript" src="js/radar_search.js"></script>
        <!-- Funzioni utilizzate per eseguire una ricerca testo sulla mappa. -->
        <script type="text/javascript" src="js/text_search.js"></script>
        
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
        <script type="text/javascript" src="jqwidgets-ver3/jqwidgets/jqxpanel.js"></script>
		<script type="text/javascript" src="jqwidgets-ver3/jqwidgets/jqxdatetimeinput.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3/jqwidgets/jqxcalendar.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3/jqwidgets/jqxtooltip.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3/jqwidgets/jqxtooltip.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3/jqwidgets/jqxdropdownlist.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3/jqwidgets/globalization/globalize.js"></script>
        
        <!-- Controlla che tutti i campi richiesti per creare un nuovo evento siano stati inseriti correttamente. -->
        <!-- Controlla che tutti i campi richiesti per poter eseguire una ricerca testo. -->
        <script type="text/javascript" src="js/event_validators.js"></script>
        
        <!-- Carica il form degli eventi: crea due elementi jqxDateTimeInput, imposta l'evento onSubmit del form. Cotniene le funzioni utilizzare per gestire la preview dell'immagine selezionata. -->
        <script type="text/javascript" src="js/load_event_form.js"></script>
        
        <!-- VALIDATOR: Il validator restituisce come risultato "Passed". -->
	</head>
	
	<body>
		<header>
		</header>
		
        <nav role="navigation">
            <p>Ubi</p>
            <p><a class="" href="profile.php">Account</a></p>
            <p><a class="" href="events.php">Eventi</a></p>
            <p><a class="logout" href="#" onClick="logOut();">Logout</a></p>
            <p class="welcome" style="float:right;">
				Ciao <?php echo $_SESSION['user_name']; ?>!
			</p>
        </nav>
		
		<section id="content" class="body">
        	<div id="new_event">
				<h2>Nuovo Evento</h2>
                
                <form id="event_form" class="event_form" method="post" enctype="multipart/form-data">
	                <p class="event_form">Immagine Evento</p>
                    <div id="image_preview"><img class="previewing" alt="" id="previewing" src="noimage.png" /></div>
					<p class="event_form">Seleziona un'immagine da caricare:</p>
                    <input type="file" name="fileToUpload" id="fileToUpload" required />
                    <p class="event_form">Nome Evento:</p>
                    <input class="event_form" type="text" name="event_name" id="event_name"><br>
                    <p class="event_form">Descrizione Evento:</p>
                    <textarea class="event_form" name="event_description" id="event_description"></textarea>
                    <p class="event_form">Data Inizio Evento:</p>
                    <input type="hidden" name="event_start_date" id="event_start_date" value=""> 
                    <div id="jqxDateTimeInput1">
					</div>
                    <p class="event_form">Data Fine Evento:</p>
					<input type="hidden" name="event_end_date" id="event_end_date" value=""> 
                    <div id="jqxDateTimeInput2">
					</div>
                    <p class="event_form">Località Evento:</p>
                    <input type="hidden" name="place_google_id" id="place_google_id" value=""> 
                    <input class="event_form" type="text" name="event_place_name" id="event_place_name" onKeyPress="return event_form_SubmitOnEnter(event)"><br>
                    <input class="btn_event_form" name="submit" type="submit" value="Crea Evento">
                    
                    <input type="hidden" name="edit_event_submitted" id="edit_event_submitted" value="">
                    <input type="hidden" name="delete_event_submitted" id="delete_event_submitted" value="">
                    <input type="hidden" name="file_to_upload" id="file_to_upload" value="">
                </form>
                
                <h4 id='loading' >Caricamento...</h4>
				<div id="message"></div>
            </div>
            
            <div id="google_map">
				<h2>Località Evento</h2>
                
                <div id="map-canvas">
                </div>
                
                <div id="search_bar">
                	<div id="search_bar_top">
	                    <h4>Vicino a Te</h4>
                    </div>
                    
                    <div id="search_bar_bottom">
                        <form id="event_form_search_bar" class="event_form_search_bar" method="post" enctype="multipart/form-data" onsubmit="return validateSearchForm()">
                            <p class="event_form_search_bar">Cerca:</p>
                            <input class="event_form_search_bar" type="text" onKeyUp="return search_form_submitOnEnter(event)" name="search_query_text" id="search_query_text"><br>
                        </form>
                        
                        <div id="btn_search_wrapper">
                        	<div id="custom_btn_search" class="custom_btn_search" onClick="TextSearch();">
                        		<span class="buttonText">Cerca Luogo</span>
                        	</div>
                        </div>
                    </div>
				</div>
                
                <div id="loading_label">   
					<p>Caricamento in corso...</p>
				</div>
                
                <div id="listbox">
				</div>
            </div>
		</section>
		
		<footer>
        </footer>
	</body>
</html>
