<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$weekSelected = 1;
	if (isset($_GET['week']))
		$weekSelected = $_GET['week'];
		
	$TeamPicked = 'Bears';
	if (isset($_GET['team']))
		$TeamPicked = $_GET['team'];
		
	$Username = 'N/A';
	if (isset($_GET['user']))
		$Username = $_GET['user'];
	
	if( isset($_COOKIE["username"]))
		$Username = $_COOKIE["username"];
	
	
	$TeamPicked = trim($TeamPicked);	
	$USERID = trim($USERID);
	
	$sqlUser = "SELECT * FROM `User` WHERE Username = '$Username'";	
	$User = $conn->query($sqlUser);	
	while ($row = mysqli_fetch_array($User))
			$USERID = $row['User_ID'];

	
	

	$wasGameONEpicked = false;
	$VerifyAdd = true;

	// Query for all games where team is playing that week to get GAME_ID
	
	$sql = "SELECT * FROM `Games` WHERE Week_ID = $weekSelected";	
	$Game = $conn->query($sql);
	
	
	while ($row = mysqli_fetch_array($Game))
		{
			if($row['Game_Team1'] === $TeamPicked) 
			{
				$GAMEID = $row['Game_ID'];
				$wasGameONEpicked = true; 
			}
			elseif($row['Game_Team2'] === $TeamPicked)
			{
				$GAMEID = $row['Game_ID'];
			}

		}
																//WILL NEED TO ADD USER ID HERE TOO
	$result = "SELECT * FROM `Pick_History` WHERE Game_Id = $GAMEID and User_ID = $USERID";	
	$CheckSQL= $conn->query($result);

	while ($row = mysqli_fetch_array($CheckSQL))
		{
			if($row['Time_Picked'])
				$isThere = True;

			if($row['Picked'] == $TeamPicked)
				$VerifyAdd = false;
			

		} 
	


	if($isThere)
	{
		$sqlPick= "UPDATE `football_picks`.`Pick_History` SET Picked = '$TeamPicked' WHERE `Game_ID` = $GAMEID AND `User_ID` = $USERID";	
		if (!mysqli_query($conn, $sqlPick))
  			echo("Error description: " . mysqli_error($conn));
  			
  			
	}
	
	else {
		$sql = "INSERT INTO `football_picks`.`Pick_History` (`Pick_ID`, `Game_ID`, `Picked`, `Time_Picked`, `User_ID`) VALUES (NULL, '$GAMEID', '$TeamPicked', CURRENT_TIMESTAMP, '$USERID')";
		if (!mysqli_query($conn, $sql))
  			echo("Error description: " . mysqli_error($conn));
  			
  			
	}	



	if($VerifyAdd) // Same team touched. Dont mess with stats			if there already add and sub else just add
	{

		if($isThere) {
			if($wasGameONEpicked)
				$sqlstatment = " UPDATE `football_picks`.`Games` SET  `Game_Team1_PickedCount` = Game_Team1_PickedCount + '1', `Game_Team2_PickedCount` = Game_Team2_PickedCount + '-1'  WHERE `Games`.`Game_ID` = $GAMEID";
			else
				$sqlstatment = " UPDATE `football_picks`.`Games` SET  `Game_Team2_PickedCount` = Game_Team2_PickedCount + '1', `Game_Team1_PickedCount` = Game_Team1_PickedCount + '-1'  WHERE `Games`.`Game_ID` = $GAMEID";

						
		}
		else {
		
			if($wasGameONEpicked)
				$sqlstatment = " UPDATE `football_picks`.`Games` SET  `Game_Team1_PickedCount` = Game_Team1_PickedCount + '1'  WHERE `Games`.`Game_ID` = $GAMEID";
			else		
				$sqlstatment = " UPDATE `football_picks`.`Games` SET  `Game_Team2_PickedCount` = Game_Team2_PickedCount + '1' WHERE `Games`.`Game_ID` = $GAMEID";		
		}
		
		if (!mysqli_query($conn, $sqlstatment))
  		 echo("Error description: " . mysqli_error($conn));
 
	}

	



/*
echo "Was team one picked? : ";
echo $wasGameONEpicked;
*/

	
?>


