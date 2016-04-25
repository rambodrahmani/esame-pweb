<?php
	/*
		Legge le informazioni relative all'evento selezionato. Il database sul quale vengono eseguite le operazioni è definitivo nel file config.php.
	*/

	require_once("config.php");
	
	$user_id = null;
	$event_id = null;
	
	$user_id = $conn->real_escape_string($_POST['user_id']);
	$event_id = $conn->real_escape_string($_POST['event_id']);
	
	$sql = "SELECT	*
			FROM	events e INNER JOIN places p
					ON e.event_place_id = p.place_id
			WHERE	e.event_author_id = '$user_id'
					AND e.event_id = '$event_id';";
			
	$rs = $conn->query($sql);
	
	$results = array();
	
	if ($rs->num_rows > 0) {
		while($row = $rs->fetch_assoc()) {
			array_push($results, $row);
		}
		echo json_encode($results, 68);
	} else {
		echo "NO_EVENT_AVAILABLE";
	}
	
	$conn->close();
?>
