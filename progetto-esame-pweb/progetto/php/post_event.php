<?php
	/*
		File PHP utilizzato per creare, modificare o eliminare un evento. Si occupa di gestire la classificazione del luogo selezionato dall'utente per l'evento nel caso questo non sia già presente nel database. Il database sul quale vengono eseguite le operazioni è definitivo nel file config.php.
	*/

	session_start();
	
	$user_id = null;
	$user_id = $_SESSION['user_id'];
	
	if ( !($user_id > 0) ) {
		header('Location: ' . 'index.php');
	}
	
	require_once("config.php");
	
	$place_google_id = null;
	$event_author_id = null;
	$event_id = null;
	$event_name = null;
	$event_picture_url = null;
	$event_description = null;
	$event_start_date = null;
	$event_end_date = null;
	$event_date_utc_offset = null;
	$event_place_name = null;
	
	$place_google_id = $conn->real_escape_string($_POST['place_google_id']);
	
	$event_author_id = $user_id;
	$event_id = $conn->real_escape_string($_POST['event_id']);
	$event_name = $conn->real_escape_string($_POST['event_name']);
	
	$file_name = date('Y-m-d h:m:s');
	$file_name = str_replace("-", "", str_replace(":", "" ,str_replace(" ", "", $file_name)));
	$path = $_FILES['fileToUpload']['name'];
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	$event_picture_url = $conn->real_escape_string($_POST['event_picture_url']);
	
	$event_description = $conn->real_escape_string($_POST['event_description']);
	$event_start_date = $conn->real_escape_string($_POST['event_start_date']);
	$event_end_date = $conn->real_escape_string($_POST['event_end_date']);
	$event_date_utc_offset = 0;
	$event_place_name = $conn->real_escape_string($_POST['event_place_name']);
	
	if ($_POST['edit_event_submitted'] == 'YES')
	{
		$error = 0;
		
		if ($_POST['file_to_upload'] == "NEW")
		{
			if (isset($_FILES["fileToUpload"]["type"]))
			{
				$validextensions = array("jpeg", "jpg", "png");
				$temporary = explode(".", $_FILES["fileToUpload"]["name"]);
				$file_extension = end($temporary);
				
				if (
					(($_FILES["fileToUpload"]["type"] == "image/png") || ($_FILES["fileToUpload"]["type"] == "image/jpg") || ($_FILES["fileToUpload"]["type"] == "image/jpeg")) 
					&& ($_FILES["fileToUpload"]["size"] < 1048576) //Approx. 1Mb
					&& in_array($file_extension, $validextensions)
					)
				{
					if ($_FILES["fileToUpload"]["error"] > 0)
					{
						$error = 1;
						echo "<br>Error. Codice Errore: " . $_FILES["fileToUpload"]["error"] . "<br>";
					}
					else
					{
						if ( ! (file_exists("../uploads")) )
						{
							mkdir("../uploads", 0777, true);
						}
						
						if ( ! (file_exists("../uploads/" . $user_id)) )
						{
							mkdir("../uploads/" . $user_id, 0777, true);
						}
						
						$sourcePath = $_FILES['fileToUpload']['tmp_name'];
						$targetPath = "../uploads/" . $user_id . "/" . $file_name . "." . $ext;
						if (file_exists($targetPath))
						{
							$error = 1;
							echo "<br>" . $file_name . "." . $ext . ", <span id='invalid'><b> Error. Un file con lo stesso nome esiste già.</b></span><br>";
						}
						else
						{
							if ( move_uploaded_file($sourcePath, $targetPath) )
							{
								$event_picture_url = BASE_URL . "uploads/" . $user_id . "/" . $file_name . "." . $ext;
							}
							else
							{
								$error = 1;
								echo "<br><span id='invalid'>Error. Si è verificato un errore durante il caricamente dell'immagine dell'evento.<span><br>";
							}
						}
					}
				}
				else
				{
					$error = 1;
					echo "<br><span id='invalid'>Error. Dimensione o tipo di file non valido.<span><br>";
				}
			}
		}
		
		if ($error == 0)
		{
			if ($place_google_id == "NO_LOC") {
				$event_place_id = 0;
			} else {
				$sql = "SELECT	*
						FROM	places
						WHERE	place_google_id = '$place_google_id';";
						
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$event_place_id = $row['place_id'];
				}
				else {
					$url = 'http://' . DB_SERVER . '/php/post_new_place.php';
					$data = array(	'places_google_id' => $place_google_id . ", ",
									'date_utc_offset' => $event_date_utc_offset);
					$options = array(
						'http' => array(
							'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
							'method'  => 'POST',
							'content' => http_build_query($data),
						),
					);
					$context = stream_context_create($options);
					$response = file_get_contents($url, false, $context);
					$json = json_decode($response, true);
					$event_place_id = $json[0]["place_id"];
				}
				
				$sql = "UPDATE	events
						SET		event_author_id = '$event_author_id',
								event_name = '$event_name',
								event_picture_url = '$event_picture_url',
								event_description = '$event_description',
								event_place_id = '$event_place_id',
								event_start_date = '$event_start_date',
								event_end_date = '$event_end_date'
						WHERE	event_id = '$event_id';";
						
				$rs = $conn->query($sql);
				
				if ($rs === TRUE) {			
					echo "<br><span id='success'><b>Evento modificato con successo.</b></span><br/><br/>";
				} else {
					echo "<br><span id='invalid'>Error. Non è stato possibile apportare le modifiche desiderate sull'evento selezionato nel database di Ubi: " . $conn->error . "<span><br>";
				}
			}
		}
	}
	else if ($_POST['delete_event_submitted'] == 'YES')
	{
		$sql = "DELETE FROM	events
				WHERE		event_id = '$event_id';";
									
		$rs = $conn->query($sql);
		
		if ($rs === TRUE) {			
			echo "<br><span id='success'><b>Evento eliminato con successo.</b></span><br/><br/>";
		} else {
			echo "<br><span id='invalid'>Error. Non è stato possibile eliminare l'evento dal database di Ubi: " . $conn->error . "<span><br>";
		}
	}
	else if ($_POST['delete_event_submitted'] == 'ABORT')
	{
		// abort
	}
	else {
		$event_picture_url = BASE_URL . "uploads/" . $user_id . "/" . $file_name . "." . $ext;
		
		if (isset($_FILES["fileToUpload"]["type"]))
		{
			$validextensions = array("jpeg", "jpg", "png");
			$temporary = explode(".", $_FILES["fileToUpload"]["name"]);
			$file_extension = end($temporary);
			
			if (
				(($_FILES["fileToUpload"]["type"] == "image/png") || ($_FILES["fileToUpload"]["type"] == "image/jpg") || ($_FILES["fileToUpload"]["type"] == "image/jpeg")) 
				&& ($_FILES["fileToUpload"]["size"] < 1048576) //Approx. 1Mb
				&& in_array($file_extension, $validextensions)
				)
			{
				if ($_FILES["fileToUpload"]["error"] > 0)
				{
					echo "<br>Error. Codice Errore: " . $_FILES["fileToUpload"]["error"] . "<br>";
				}
				else
				{
					if ( ! (file_exists("../uploads")) )
					{
						mkdir("../uploads", 0777, true);
					}
					
					if ( ! (file_exists("../uploads/" . $user_id)) )
					{
						mkdir("../uploads/" . $user_id, 0777, true);
					}
					
					$sourcePath = $_FILES['fileToUpload']['tmp_name'];
					$targetPath = "../uploads/" . $user_id . "/" . $file_name . "." . $ext;
					if (file_exists($targetPath))
					{
						echo "<br>" . $file_name . "." . $ext . ", <span id='invalid'><b> Error. Un file con lo stesso nome esiste già.</b></span><br>";
					}
					else
					{
						if ( move_uploaded_file($sourcePath, $targetPath) )
						{
							if ($place_google_id == "NO_LOC") {
								$event_place_id = 0;
							} else {
								$sql = "SELECT	*
										FROM	places
										WHERE	place_google_id = '$place_google_id';";
										
								$result = $conn->query($sql);
								
								if ($result->num_rows > 0) {
									$row = $result->fetch_assoc();
									$event_place_id = $row['place_id'];
								}
								else {
									$url = 'http://' . DB_SERVER . '/php/post_new_place.php';
									$data = array(	'places_google_id' => $place_google_id . ", ",
													'date_utc_offset' => $event_date_utc_offset);
									$options = array(
										'http' => array(
											'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
											'method'  => 'POST',
											'content' => http_build_query($data),
										),
									);
									$context = stream_context_create($options);
									$response = file_get_contents($url, false, $context);
									$json = json_decode($response, true);
									$event_place_id = $json[0]["place_id"];
								}
							}
							
							$sql = "INSERT INTO	events(event_author_id, event_name, event_picture_url, event_description, event_place_id, event_start_date, event_end_date)
									VALUES('$event_author_id', '$event_name', '$event_picture_url', '$event_description', '$event_place_id', '$event_start_date', '$event_end_date')";
									
							$rs = $conn->query($sql);
							
							if ($rs === TRUE) {
								$event_id = $conn->insert_id;
								
								echo "<br><span id='success'><b>Evento creato con successo.</b></span><br><br>";
								echo "<b>Nome Evento:</b> " . $event_name . "<br>";
								echo "<b>Descrizione Evento:</b> " . $event_description . "<br>";
								echo "<b>Data Inizio Evento:</b> " . $event_start_date . "<br>";
								echo "<b>Data Fine Evento:</b> " . $event_end_date . "<br>";
								echo "<b>Località Evento:</b> " . $event_place_name . "<br>";
							} else {
								echo "<br><span id='invalid'>Error. Non è stato possibile inserire l'evento nel database di Ubi: " . $conn->error . "<span><br>";
							}
						}
						else
						{
							echo "<br><span id='invalid'>Error. Si è verificato un errore durante il caricamente dell'immagine dell'evento.<span><br>";
						}
					}
				}
			}
			else
			{
				echo "<br><span id='invalid'>Error. Dimensione o tipo di file non valido.<span><br>";
			}
		}
	}
	
	$conn->close();
?>
