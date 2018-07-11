<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$confrimDelete = false;
	
	if( isset($_COOKIE["username"]))
		$Username = $_COOKIE["username"];
	$sqlUser = "SELECT * FROM `User` WHERE Username = '$Username'";	
	$User = $conn->query($sqlUser);	
	while ($row = mysqli_fetch_array($User))
			$USERID = $row['User_ID'];
	
	
	$Picked = array();
	

	$sql = "SELECT * FROM `Pick_History` WHERE User_ID = '$USERID'";	
	$User = $conn->query($sql);
		
	while ($row = mysqli_fetch_array($User))
	{
			
				
			 array_push($Picked, $row["Picked"]);

			
	}
	
	
$count_values = array();
foreach ($Picked as $a) {

     @$count_values[$a]++;

}
arsort($count_values);
	foreach($count_values as $x => $x_value) {
   	 echo $x . " " . $x_value;
    	echo "<br>";
}
	
?>












<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Edit Account</title>
      <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
      <!-- Ref section -->
      <link rel="shortcut icon" href="../images/football.png" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Anton" />
   </head>
  <body style="background-color: #4B8241;">
  


	



</body>
</html>