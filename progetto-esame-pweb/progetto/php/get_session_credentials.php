<?php
	/*
		Utilizzato dai file JavaScript per ottenere le informazioni conservate nelle variabili di sessione PHP.
	*/

	session_start();
	echo json_encode($_SESSION);
?>
