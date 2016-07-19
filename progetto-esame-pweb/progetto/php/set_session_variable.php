<?php
	/*
		Gestisce la sessione PHP dell'utente. Permette di identificare se un utente ha già eseguito il login e quindi può o meno accedere i contenuti di una determinata pagina.
	*/

	session_start();
	
	$variable = null;
	$variable = $_POST['variable'];
	
	if ($variable == 'set_user')
	{
		$_SESSION['user_id'] = $_POST['user_id'];
		$_SESSION['user_chat_id'] = $_POST['user_chat_id'];
		$_SESSION['user_email'] = $_POST['user_email'];
		$_SESSION['user_name'] = $_POST['user_name'];
		$_SESSION['user_surname'] = $_POST['user_surname'];
		$_SESSION['user_profile_pic'] = $_POST['user_profile_pic'];
		$_SESSION['user_profile_url'] = $_POST['user_profile_url'];
		$_SESSION['user_bio'] = $_POST['user_bio'];
		$_SESSION['user_birthday'] = $_POST['user_birthday'];
		$_SESSION['user_gender'] = $_POST['user_gender'];
	}
	else if ($variable == 'set_open_twitter_popup_view')
	{
		$_SESSION['open_twitter_popup_view'] = "TRUE";
	}
?>
