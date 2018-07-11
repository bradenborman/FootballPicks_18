<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	


	if (isset($_POST['restart']))
		$restart = ($_POST['restart']);

	if($restart)
		
	{
		$sql = "UPDATE `Games` SET `Game_Winner`= null,`Game_Team1_PickedCount`= 0,`Game_Team2_PickedCount`= 0 WHERE Game_ID > 0";	
		$Game = $conn->query($sql);
	
		$sql2 = "DELETE FROM `Pick_History` WHERE Game_ID > 0";	
		$Game = $conn->query($sql2);
	}	
		header('Location: https://pickemupsets.com/admin/index.php?allowed=truee');
?>


