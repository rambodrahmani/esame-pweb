<?php
	/*
		Legge gli eventi creati dall'utente e li restiuisce in ordine di data-inizio-evento decrescente. Il database sul quale vengono eseguite le operazioni è definitivo nel file config.php.
	*/

	require_once("config.php");
	
	$user_id = null;
	$user_id = $conn->real_escape_string($_POST['user_id']);
	
	$sql = "SELECT		*
			FROM		events
			WHERE		event_author_id = '$user_id'
			ORDER BY	event_start_date DESC;";
			
	$rs = $conn->query($sql);
	
	$results = array();
	
	if ($rs->num_rows > 0) {
		while($row = $rs->fetch_assoc()) {
			array_push($results, $row);
		}
		echo json_encode($results, 68);
	} else {
		echo "NO_EVENTS_AVAILABLE";
	}
	
	$conn->close();
?>
