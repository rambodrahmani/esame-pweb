<?php
	/*
		Legge gli utenti registrati sul servizio per verificare se l'utente può avvedere o meno al pannello Web. Il database sul quale vengono eseguite le operazioni è definitivo nel file config.php.
	*/
	
	require_once("config.php");
	
	$user_email = null;
	$user_email = $conn->real_escape_string($_POST['user_email']);
	
	$sql = "SELECT	*
			FROM	users
			WHERE	user_email = '$user_email';";
			
	$rs = $conn->query($sql);
	
	$user_id = 0;
	
	if ($rs->num_rows > 0) {
		$row = $rs->fetch_assoc();
		echo json_encode($row, 64);
	} else {
		echo "NOT_REGISTERED";
	}
	
	$conn->close();
?>
