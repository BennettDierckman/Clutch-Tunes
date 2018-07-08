<?php
//Require password.php enables the function password_verify() to be called
    require("password.php");
//Establishes connection with database
    $connect = mysqli_connect('localhost', 'weg4vcdb_ben', 'skater94', 'weg4vcdb_ClutchTunes')or die('Could not connect: ' . mysql_error());
    
  
//pulls ALREADY VALIDATED data from Android Studios, Sanatizes it, and assignes it to various $variables 
    $partyTitle = mysqli_real_escape_string($connect, $_POST["partyTitle"]);
    //$title = "hhhh";
    $password = "";
    //$password = "password";
    //$title = "bennettsCurrentParty";
 
    function checkPasswords(){
        global $connect, $partyTitle, $password;
        $statement = mysqli_prepare($connect, "SELECT password FROM Parties WHERE title = ?");
        mysqli_stmt_bind_param($statement, "s", $partyTitle);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result( $statement, $colPassword);

        while(mysqli_stmt_fetch($statement)){
    	//echo $colPassword;
            if (password_verify($password, $colPassword)) {
    	    	return true; 
            }else{
                return false;
            } 
        }
    } 

    function addOneToAttending(){
        global $connect, $partyTitle;
        $statement = mysqli_prepare($connect, "UPDATE Parties SET attending = attending+1 WHERE title='$partyTitle' AND active='1'");
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_affected_rows($connect);
        mysqli_stmt_close($statement); 
        if ($count == 1){
            return true;
        }else{
            return false;
        }
    }

    $response = array();
    $response["partyIsPublic"] = false;

    if (checkPasswords()){
        if(addOneToAttending()){
            $response["partyIsPublic"] = true;
        }
    }
    echo json_encode($response);
?>