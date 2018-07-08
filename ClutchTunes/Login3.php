<?php
//Require password.php enables the function password_verify() to be called
    require("password.php");
//Establishes connection with database
    $connect = mysqli_connect('localhost', 'weg4vcdb_ben', 'skater94', 'weg4vcdb_ClutchTunes')or die('Could not connect: ' . mysql_error());
    //
  
//pulls ALREADY VALIDATED data from Android Studios, Sanatizes it, and assignes it to various $variables 
    $username = mysqli_real_escape_string($connect, $_POST["username"]);
    $password = mysqli_real_escape_string($connect, $_POST["password"]);
//Test data for running file in burrow to recieve echos     
   // $username = "skates";
   // $password = "skate";    
//Statement prepared 
    $statement = mysqli_prepare($connect, "SELECT * FROM Users WHERE username = ?");
    mysqli_stmt_bind_param($statement, "s", $username);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $colUserID, $colUsername, $colPassword, $colFN, $colEmail, $colHash, $colActive, $colDOB, $colBiography);
 
//Set response as false unless proper credentials provided
    $response = array();
    $response["success"] = false;
    $response["unVerified"] = true;  
    //echo $password;
    
    while(mysqli_stmt_fetch($statement)){
	//echo $colPassword;
        if (password_verify($password, $colPassword)) {
            if($colActive=='1'){
	    	$response["success"] = true;
     		$response["unVerified"] = false;
            	$response["name"] = $colFN;
		    }
	        else{
		    $response["unVerified"] = true;
            $response["success"] = true;
		    }
        }
        else{
            $success = false; 
        } 
    }   
    print(json_encode($response));
?>