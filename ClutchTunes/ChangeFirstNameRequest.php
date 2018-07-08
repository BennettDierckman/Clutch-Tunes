<?php 
//Establishes connection with database
    $connect = mysqli_connect('localhost', 'weg4vcdb_ben', 'skater94', 'weg4vcdb_ClutchTunes')or die('Could not connect: ' . mysql_error());
    

    $username = mysqli_real_escape_string($connect, $_POST["username"]);
    $newFirstName = mysqli_real_escape_string($connect, $_POST["newFirstName"]);

    //$username = "bennett";
    //$newFirstName = "asdfasfasd";
  

        // Select party with matching title  with active column = "1"
        $statement = mysqli_prepare($connect, "UPDATE Users SET firstName='$newFirstName' WHERE username='$username'");
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_affected_rows($connect);
        mysqli_stmt_close($statement); 
        $response = array();
        $response["success"]  = false;

        if ( $count == 1){ 
            $response["success"] = true;
        }
        else{
            $response["success"] = false;
        }


    echo json_encode($response);
    //echo $response["success"];
?>