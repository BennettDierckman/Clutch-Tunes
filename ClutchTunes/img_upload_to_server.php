<?php
// Create connection
//Establishes connection with database
    $connect = mysqli_connect('localhost', 'weg4vcdb_ben', 'skater94', 'weg4vcdb_ClutchTunes')or die('Could not connect: ' . mysql_error());
    

 if($_SERVER['REQUEST_METHOD'] == 'POST')
 {
	 $DefaultId = 0;
	 
	 $ImageData = $_POST['image_path'];
	 
	 $ImageName = $_POST['image_name'];

	 $GetOldIdSQL ="SELECT image_name FROM UploadImageToServer ORDER BY id ASC";
	 
	 $Query = mysqli_query($connect,$GetOldIdSQL);
	 
	 while($row = mysqli_fetch_array($Query)){
	 
	 	$DefaultId = $row['image_name'];
	 }
	 
	 $ImagePath = "images/$DefaultId.png";
	 
	 $ServerURL = "http://mjyintl.com/ClutchTunes/$ImagePath";
	 
	 $InsertSQL = "insert into UploadImageToServer (image_path,image_name) values ('$ServerURL','$ImageName')";
	 
	 if(mysqli_query($connect, $InsertSQL)){

	 file_put_contents($ImagePath,base64_decode($ImageData));

	 echo "Your Image Has Been Uploaded.";
	 }
	 
	 mysqli_close($connect);
 }
 else{
 echo "Not Uploaded";
 }

?>