<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$Scores = array();
	

	if( isset($_COOKIE["username"]))
	$Username = $_COOKIE["username"];
	

	$sqlUser = "SELECT * FROM `User` WHERE Username = '$Username'";	
	$User = $conn->query($sqlUser);	
	while ($row = mysqli_fetch_array($User))
			$USERID = $row['User_ID'];

	
	$w = $conn->query("SELECT Game_Current_Week FROM `Game_Settings`");	
	while ($row = mysqli_fetch_array($w))
		$Currentweek = $row['Game_Current_Week'];
	
	$SQL = "SELECT * FROM `User` WHERE User_ID = $USERID";
	
	
	
    		$x = $conn->query($SQL);	
		while ($row = mysqli_fetch_array($x))
		{
			$total = 0;
			for ($week = 1; $week <= $Currentweek; $week++) {
				$total += getTotalCorrect($row['User_ID'], $week, $conn, $row['First_Name'], $row['Last_Name']);
			}

			$name = $row['First_Name']. " " .$row['Last_Name'];			
			$Scores += array($name => $total);							
		}		
	
		
	
function getTotalCorrect($Id, $week, $connection, $fname, $lname) {
    
    $correctRight = 0;
	
	$sql = "SELECT * FROM `Games` LEFT JOIN Pick_History  ON Pick_History.Game_ID = Games.Game_ID AND Pick_History.User_ID = '$Id' WHERE Week_ID = '$week'";	
	$AllGames = $connection->query($sql);
	while ($row = mysqli_fetch_array($AllGames))
	{		
		
		$isUpset = isUpsetandPicked($row['Game_Team1_PickedCount'], $row['Game_Team2_PickedCount'], $row['Game_Winner'], $row['Picked'], $row['Game_Team1'], $row['Game_Team2']);					
		if($isUpset)
			$correctRight = $correctRight + 3;
		else
		{
			if($row['Game_Winner'] == $row['Picked'] && $row['Game_Winner'] != null) 		
				$correctRight++;
		}
			
	}
	
		
	return $correctRight;
}
		
	
function isUpsetandPicked($PC1, $PC2, $winner, $picked, $teamOne, $teamTwo) {

	$upsetEligible = 25;
	$totalPicked = $PC1 + $PC2;
	$Team1_Picked_Percent = round(($PC1 / $totalPicked) * 100, 0);
	$Team2_Picked_Percent = 100  - $Team1_Picked_Percent;
	
	
	
	if($Team1_Picked_Percent <= $upsetEligible) 
	{
		
	 
		if($winner == $picked && $winner != null && $teamOne == $picked)
		  {
		   	return true; 
		  }
	}
	
	if($Team2_Picked_Percent <= $upsetEligible)	
 	{	  
		 
		if($winner == $picked && $winner != null && $teamTwo == $picked)
		  { 
		  	 return true;
		  }   
	}
	
return false; 		
}	




 		arsort($Scores);
 		$highestScore = 0;
		foreach($Scores as $x => $x_value) {
			if($highestScore < $x_value) 
    				$highestScore = $x_value;   //GET HIGH SCORE	
			
    				
    				echo 'My Score: ' .$x_value;
    				echo '<br><a href="https://pickemupsets.com/user/">User Information</a>';
   				   			
		}
		
		if( !isset($_COOKIE["username"]))
		{
			?> 
				<span style="cursor: pointer;" class="moveCoursorToLogin">Please Log in</span>
			<?php
		}
		
		
				
?>