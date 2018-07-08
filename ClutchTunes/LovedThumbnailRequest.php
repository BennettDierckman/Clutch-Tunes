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
    $response["thumbnailURL"] = "";
    $response["videoLink"] = "";

    $stmt = "SELECT thumbnailURL FROM " .$username. " WHERE title = ?";
    //$statement = mysqli_prepare($connect, "SELECT link FROM likew WHERE title = ?");
    $statement = mysqli_prepare($connect, $stmt);
    mysqli_stmt_bind_param($statement, "s", $videoTitle);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $colThumbnailURL);
    while(mysqli_stmt_fetch($statement)){
        $response["thumbnailURL"] = $colThumbnailURL;
    }   

    $stmt = "SELECT link FROM " .$username. " WHERE title = ?";
    //$statement = mysqli_prepare($connect, "SELECT link FROM likew WHERE title = ?");
    $statement = mysqli_prepare($connect, $stmt);
    mysqli_stmt_bind_param($statement, "s", $videoTitle);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $colLink);
    while(mysqli_stmt_fetch($statement)){
        $response["videoLink"] = $colLink;
    }  

    echo json_encode($response);

?>