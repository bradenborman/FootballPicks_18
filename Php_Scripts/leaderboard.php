<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$Scores = array();
	
	 $groupID = 0;
	if (isset($_GET['groupID']))
		 $groupID = $_GET['groupID'];
	
	
	if($groupID == 0)
		$GroupSQL = "SELECT * FROM `User`";
	else 
		$GroupSQL = "SELECT * FROM `User` Where Group_ID = '".$groupID."'";
	
		
					
	$w = $conn->query("SELECT Game_Current_Week FROM `Game_Settings`");	
	while ($row = mysqli_fetch_array($w))
		$Currentweek = $row['Game_Current_Week'];
	

	
	/***** Here is where you edit the group ID ******/
	
    		$z = $conn->query($GroupSQL);	
		while ($row = mysqli_fetch_array($z))
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
    			?>
    				
    			<div class="row entry">
    				<div class="col-sm-6 text-center"><h2 style="display: inline-block;">		
	    				<?php echo  $x; ?></h2><span style="float:right;"><?php echo  $x_value; ?></span>
	    			</div>
				<div class="col-sm-6">	
					<progress style="width:100%;" value="<?php echo $x_value; ?>" max="<?php echo $highestScore; ?>"></progress>
				</div>	

			</div>
		
		<?php    			   			
		}


		
?>