<?php 
/* PARTY TERMINATED, set Parties active column equal to the string "0" 
*/
//Establishes connection with database
    $con = mysqli_connect('localhost', 'weg4vcdb_ben', 'skater94', 'weg4vcdb_ClutchTunes')or die('Could not connect: ' . mysql_error());
    

    if(mysqli_connect_error($con))
    {
        echo "failed to connect";
    }

    $username = mysqli_real_escape_string($con, $_POST["username"]);
    //$username = "bedierck";
    //Statement prepared 
    $statement = mysqli_prepare($con, "SELECT * FROM Users WHERE username = ?");
    mysqli_stmt_bind_param($statement, "s", $username);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $colUserID, $colUsername, $colPassword, $colFN, $colEmail, $colHash, $colActive, $colDOB, $colBiography);
 
//Set response as false unless proper credentials provided
    $response = array();
    $response["firstName"] = "";
    $response["email"] = "";  
    
    while(mysqli_stmt_fetch($statement)){
        $response["firstName"] = $colFN;
        $response["email"] = $colEmail;
    }   
    echo json_encode($response);
?>