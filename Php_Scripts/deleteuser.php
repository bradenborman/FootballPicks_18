<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	
	if( isset($_COOKIE["username"]))
		$Username = $_COOKIE["username"];
	$sqlUser = "SELECT * FROM `User` WHERE Username = '$Username'";	
	$User = $conn->query($sqlUser);	
	while ($row = mysqli_fetch_array($User))
			$USERID = $row['User_ID'];
	


	$deleteGamesUserPicked = "DELETE FROM `Pick_History` WHERE User_ID = '$USERID'";	
	$deleteUser = "DELETE FROM `User` WHERE User_ID = '$USERID'";	
	
	
	if (!mysqli_query($conn, $deleteGamesUserPicked))
	{	
		echo("Error description: " . mysqli_error($conn));
	}	
				
	if (!mysqli_query($conn, $deleteUser))
	{	
		echo("Error description: " . mysqli_error($conn));
	}
	  
  	setcookie("username", "",  time()-3600, "/");
  	header('Location: https://pickemupsets.com/');
  
?>
