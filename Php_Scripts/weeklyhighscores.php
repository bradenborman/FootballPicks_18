<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$Scores = array();
	
				
	$w = $conn->query("SELECT Game_Current_Week FROM `Game_Settings`");	
	while ($row = mysqli_fetch_array($w))
		$Currentweek = $row['Game_Current_Week'];
			
	
			for ($week = 1; $week <= $Currentweek; $week++) {
				
				$total = 0;
				$hightotal = 0;
				
				$z = $conn->query("SELECT * FROM `User`");	
				while ($row = mysqli_fetch_array($z))
				{
					$total = userTotal($row['User_ID'], $week, $conn);				
					if($total >= $hightotal) 
					{
						$hightotal = $total;
											
					}
					//echo 'Highechore: ' .$hightotal. '<br>'; 
						
				}						
			getEveryoneWithScoreThatWeek($hightotal, $conn, $week);
		}		

	
	
	
	
	
	
function getEveryoneWithScoreThatWeek($highScore, $conn, $week) {	
	echo '<hr><b><h3>Week :'. $week . '</h3></b>';
	$z = $conn->query("SELECT * FROM `User`");	
	
	
	if($highScore > 0)
	{
		while ($row = mysqli_fetch_array($z))
		{
			$name = $row['First_Name']. " ".$row['Last_Name'];
			$total = userTotal($row['User_ID'], $week, $conn);
			if($total == $highScore) 
				echo $name. ": ". $highScore. "<br>";	
		}
	}
}
	
	
	
	
	
	
		

	
function userTotal($Id, $week, $connection) {
    
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
			
?>

