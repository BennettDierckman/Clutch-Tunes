<?php
//Establishes connection with database
    $connect = mysqli_connect('localhost', 'weg4vcdb_ben', 'skater94', 'weg4vcdb_ClutchTunes')or die('Could not connect: ' . mysql_error());
    
    date_default_timezone_set('EST');
//pulls ALREADY VALIDATED data from Android Studios, Sanatizes it, and assignes it to various $variables
    $username = mysqli_real_escape_string($connect, $_POST["username"]);
    $videoTitle = mysqli_real_escape_string($connect, $_POST["videoTitle"]);

    // $partyTitle = "hehs";
    // $videoTitle = "A\$AP Rocky LVL";

    $response = array();
    $response["success"] = false;

    $stmt = "DELETE FROM " . $username . " WHERE link = '" . $videoTitle . "'"; 
    //$statement = mysqli_prepare($connect, "SELECT link FROM likew WHERE title = ?");
    $statement = mysqli_prepare($connect, $stmt);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    $count = mysqli_affected_rows($connect);
    mysqli_stmt_close($statement); 
    if ( $count >= 1){ 
        $response["success"] = true;
    }


    echo json_encode($response);

?>