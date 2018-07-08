<?php 
/* PARTY TERMINATED, set Parties active column equal to the string "0" 
*/
//Establishes connection with database
    $connect = mysqli_connect('localhost', 'weg4vcdb_ben', 'skater94', 'weg4vcdb_ClutchTunes')or die('Could not connect: ' . mysql_error());
    

    $title = mysqli_real_escape_string($connect, $_POST["title"]);
	//$title = "lo";
	
    // Select party with matching title  with active column = "1"
	$statement = mysqli_prepare($connect, "UPDATE Parties SET active='0', attending=0 WHERE title='$title' AND active='1'");
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
	$count = mysqli_affected_rows($connect);
    mysqli_stmt_close($statement); 
	echo "   This is the count: ".$count;


    $stmt = "DROP TABLE " . $title . ";"; 
    $statement = mysqli_prepare($connect, $stmt);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    $count2 = mysqli_affected_rows($connect);
    mysqli_stmt_close($statement); 
    echo "   This is the count: ".$count;


    $response = array();
    $response["success"]  = false;

    if ( $count == 1){
        if ( $count2 == 1){
            $response["success"] = true;
        } 
    }

    echo json_encode($response["success"]);
    //echo $response["success"];
?>
