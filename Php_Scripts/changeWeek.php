<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	
		
	$newWeek = $_POST['week_Selector'];
					
	if (!mysqli_query($conn, "UPDATE `football_picks`.`Game_Settings` SET  Game_Current_Week = $newWeek  WHERE `Game_Settings`.`Game_Id` = '1'"))
  		 echo("Error description: " . mysqli_error($conn));
  	
  	header('Location: http://pickemupsets.com/admin/index.php?allowed=truee');
	exit();

?>