<?php

//Establishes connection with database
    $connect = mysqli_connect('localhost', 'weg4vcdb_ben', 'skater94', 'weg4vcdb_ClutchTunes')or die('Could not connect: ' . mysql_error());
    
    
    
//pulls ALREADY VALIDATED data from Android Studios, Sanatizes it, and assignes it to various $variables
    $latitude = mysqli_real_escape_string($connect, $_POST["latitude"]);
    echo $latitude;
    $longitude = mysqli_real_escape_string($connect, $_POST["longitude"]);
    echo $longitude;
   


//Registers User in the locationTest table, called for latitude and longitude
    function captureLocation() {
        global $connect, $latitude, $longitude;
        $statement = mysqli_prepare($connect, "INSERT INTO locationTest (lat, lng) VALUES (?, ?)");
        mysqli_stmt_bind_param($statement, "ss", $latitude, $longitude);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);     
    }

captureLocation();
  
//Create an array of responses to send back to android via 'echo json_encode()', //nitially false
    $response = array();
    $response["latitude"] = $latitude;
    $response["longitude"] = $longitude;
    $response["success"] = true;
	echo $latitude;
	echo $longitude;
	echo $response["latitude"];
	echo $response["longitude"];
	

//Echos response
   echo json_encode($response);
   ?>
   