<?php
//Require password.php enables the function password_verify() to be called
    require("password.php");
//Establishes connection with database
    $connect = mysqli_connect('localhost', 'weg4vcdb_ben', 'skater94', 'weg4vcdb_ClutchTunes')or die('Could not connect: ' . mysql_error());
    
  
//pulls ALREADY VALIDATED data from Android Studios, Sanatizes it, and assignes it to various $variables 
    $title = mysqli_real_escape_string($connect, $_POST["partyTitle"]);

    $response = array();
    $response["success"] = false;
 
        $statement = mysqli_prepare($connect, "UPDATE Parties SET attending = attending-1 WHERE title='$title' AND active='1'");
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_affected_rows($connect);
        mysqli_stmt_close($statement); 
        if ($count == 1){
            $response["success"] = true;
        }else{
            $response["success"] = false;
        }

    echo json_encode($response);
?>