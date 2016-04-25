/*
	Carica il form degli eventi: crea due elementi jqxDateTimeInput, imposta l'evento onSubmit del form. Cotniene le funzioni utilizzare per gestire la preview dell'immagine selezionata.
*/

$(document).ready(function (e)
{
	$('#loading').hide();
	
	$("#jqxDateTimeInput1").jqxDateTimeInput({ width: '100%', height: '30px', formatString: 'yyyy-MM-dd HH:mm:ss'});
	$('#jqxDateTimeInput1').val(new Date());
	var getDate = $('#jqxDateTimeInput1').jqxDateTimeInput('getText');
	document.forms["event_form"]["event_start_date"].value = getDate;
			
	$("#jqxDateTimeInput2").jqxDateTimeInput({ width: '100%', height: '30px', formatString: 'yyyy-MM-dd HH:mm:ss'});
	$('#jqxDateTimeInput2').val(new Date());
	var getDate = $('#jqxDateTimeInput2').jqxDateTimeInput('getText');
	document.forms["event_form"]["event_end_date"].value = getDate;
	
	$('#jqxDateTimeInput1').on('valueChanged', function (event) 
	{  
		var getDate = $('#jqxDateTimeInput1').jqxDateTimeInput('getText');
		document.forms["event_form"]["event_start_date"].value = getDate;
	});
	
	$('#jqxDateTimeInput2').on('valueChanged', function (event) 
	{  
		var getDate = $('#jqxDateTimeInput2').jqxDateTimeInput('getText');
		document.forms["event_form"]["event_end_date"].value = getDate;
	});
	
	$("#event_form").on('submit',(function(e) {
		e.preventDefault();
		if (validateNewEventForm())
		{
			$("#message").empty();
			$('#loading').show();
			$.ajax({
				url: "php/post_event.php",
				type: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
			}).done(function(data) {
				var s = String(data);
				if (s.indexOf("Error. ") > -1)
				{
					alert("Si è verificato un errore durante la creazione dell'evento.");
				}
				else {
					if ( (document.getElementById("delete_event_submitted").value == "YES") 
						|| (document.getElementById("delete_event_submitted").value == "ABORT") 
						|| (document.getElementById("edit_event_submitted").value == "YES") )
					{
						if (document.getElementById("delete_event_submitted").value == "YES") 
						{
							window.location.href = "events.php";
						}
						document.getElementById("delete_event_submitted").value = "";
						document.getElementById("edit_event_submitted").value = "";
					}
					else {
						document.forms["event_form"]["fileToUpload"].value = "";
						document.forms["event_form"]["event_name"].value = "";
						document.forms["event_form"]["event_description"].value = "";
						
						$('#jqxDateTimeInput1').val(new Date());
						var getDate = $('#jqxDateTimeInput1').jqxDateTimeInput('getText');
						document.forms["event_form"]["event_start_date"].value = getDate;
						
						$('#jqxDateTimeInput2').val(new Date());
						var getDate = $('#jqxDateTimeInput2').jqxDateTimeInput('getText');
						document.forms["event_form"]["event_end_date"].value = getDate;
						
						document.forms["event_form"]["place_google_id"].value = "";
						document.forms["event_form"]["event_place_name"].value = "";
						
						$('#image_preview').hide();
					}
				}
				$('#loading').hide();
				$("#message").html(data);
			}).fail(function(error) {
				console.log("Si è verificato un errore: " + error);
			});
		}
	}));
});

$(function()
{
	$("#fileToUpload").change(function() {
		$("#message").empty();
		
		var file = this.files[0];
		var imagefile = file.type;
		var match = ["image/jpeg","image/png","image/jpg"];
		
		if( !( (imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) ) )
		{
			$('#previewing').attr('src','noimage.png');
			$('#image_preview').css("display", "none");
			$('#image_preview').css("visibility", "hidden");
			
			alert("Seleziona un file valido. Sono ammessi solamente immagini di tipo jpeg, jpg and png.");
			
			return false;
		}
		else
		{
			var reader = new FileReader();
			reader.onload = imageIsLoaded;
			reader.readAsDataURL(this.files[0]);
		}
	});
});

function imageIsLoaded(e)
{
	document.forms["event_form"]["file_to_upload"].value = "NEW";
	$("#fileToUpload").css("color","green");
	$('#image_preview').css("display", "block");
	$('#image_preview').css("visibility", "visible");
	$('#previewing').attr('src', e.target.result);
	$('#previewing').attr('width', '200px');
	$('#previewing').attr('height', '200px');
};
