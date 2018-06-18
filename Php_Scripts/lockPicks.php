<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
		
		
		if ($_POST['week1'] != null)
			update(1, "locked_week1", $conn);			
		else 
			update(0, "locked_week1", $conn);
			
			
		if ($_POST['week2'] != null)
			update(1, "locked_week2", $conn);			
		else 
			update(0, "locked_week2", $conn);
			
			
		if ($_POST['week3'] != null)
			update(1, "locked_week3", $conn);			
		else 
			update(0, "locked_week3", $conn);
			
			
		if ($_POST['week4'] != null)
			update(1, "locked_week4", $conn);			
		else 
			update(0, "locked_week4", $conn);
			
			
		if ($_POST['week5'] != null)
			update(1, "locked_week5", $conn);			
		else 
			update(0, "locked_week5", $conn);
			
			
		if ($_POST['week6'] != null)
			update(1, "locked_week6", $conn);			
		else 
			update(0, "locked_week6", $conn);
			
			
		if ($_POST['week7'] != null)
			update(1, "locked_week7", $conn);			
		else 
			update(0, "locked_week7", $conn);
			
			
		if ($_POST['week8'] != null)
			update(1, "locked_week8", $conn);			
		else 
			update(0, "locked_week8", $conn);
			
			
		if ($_POST['week9'] != null)
			update(1, "locked_week9", $conn);			
		else 
			update(0, "locked_week9", $conn);
			
			
		if ($_POST['week10'] != null)
			update(1, "locked_week10", $conn);			
		else 
			update(0, "locked_week10", $conn);
			
			
		if ($_POST['week11'] != null)
			update(1, "locked_week11", $conn);			
		else 
			update(0, "locked_week11", $conn);
			
			
		if ($_POST['week12'] != null)
			update(1, "locked_week12", $conn);			
		else 
			update(0, "locked_week12", $conn);
			
			
		if ($_POST['week13'] != null)
			update(1, "locked_week13", $conn);			
		else 
			update(0, "locked_week13", $conn);
			
			
		if ($_POST['week14'] != null)
			update(1, "locked_week14", $conn);			
		else 
			update(0, "locked_week14", $conn);
			
			
		if ($_POST['week15'] != null)
			update(1, "locked_week15", $conn);			
		else 
			update(0, "locked_week15", $conn);
			
			
		if ($_POST['week16'] != null)
			update(1, "locked_week16", $conn);			
		else 
			update(0, "locked_week16", $conn);
			
			
		if ($_POST['week17'] != null)
			update(1, "locked_week17", $conn);			
		else 
			update(0, "locked_week17", $conn);
			
			
		
		
		header('Location: http://gokusama.com/picks18/Php_Scripts/Admin.php');
		exit();
		
		
			
					

function update($x, $y, $conn) {
  	 $sql = "UPDATE `football_picks`.`Game_Settings` SET $y = $x WHERE `Game_Settings`.`Game_Id` = 1;";
  		if (!mysqli_query($conn, $sql))
  		 echo("Error description: " . mysqli_error($conn));		
}



?>