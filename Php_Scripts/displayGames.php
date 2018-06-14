<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$weekSelected = 1;
	if (isset($_GET['week']))
		$weekSelected = $_GET['week'];
	
	
	if( isset($_COOKIE["username"]))
	$Username = $_COOKIE["username"];
	

	
	$sqlUser = "SELECT * FROM `User` WHERE Username = '$Username'";	
	$User = $conn->query($sqlUser);	
	while ($row = mysqli_fetch_array($User))
			$USERID = $row['User_ID'];

	$sql = "SELECT * FROM `Games` LEFT JOIN Pick_History  ON Pick_History.Game_ID = Games.Game_ID AND Pick_History.User_ID = '$USERID' WHERE Week_ID = '$weekSelected'";	
	
	
	
	$AllGames = $conn->query($sql);
	$GameCounter = 1;
	
		while ($row = mysqli_fetch_array($AllGames))
		{
			
						
			
			$isUpset = false;
			$day = $row['Game_Day'];
			$upsetEligible = 25;
			$Team_1_Count = $row['Game_Team1_PickedCount'];
			$totalPicked = $Team_1_Count + $row['Game_Team2_PickedCount'];
			$Team1_Picked_Percent = round(($Team_1_Count / $totalPicked) * 100, 0);
			$Team2_Picked_Percent = 100  - $Team1_Picked_Percent;
			if($Team2_Picked_Percent <= $upsetEligible || $Team1_Picked_Percent <= $upsetEligible) 
			  	$isUpset = true;
							
			$Team1 = $row['Game_Team1'];
			$Team2 = $row['Game_Team2'];		
		
			$didPickedTeamOne = ($row['Picked'] == $Team1 && $row['User_ID'] == $USERID);
			$didPickedTeamTwo = ($row['Picked'] == $Team2 && $row['User_ID'] == $USERID);
			
				      
			echo '<div class="row GAME">';	
			echo '<div class="row GameINFO">';
			echo ''.$row['Game_Team1'].' vs '.$row['Game_Team2'].'';
			echo '</div>		';
			echo '<div class="row secondaryInfo">';
				echo '<div class="col-xs-5 text-left">';			
				echo ''.$day.'';
				echo '</div>';
				echo '<div class="col-xs-7 text-right pointdisplay">';
				if ($isUpset) echo '<span class="label label-success">Upset Eligible</span>'; 
				echo '</div>';
			echo '</div><hr class="divider">';
			echo '<div class="row teamRow">';
				echo '<div class="col-md-2 col-xs-3 teamcol text-right">';
				echo ''.$Team1_Picked_Percent.'%';														
				echo '</div>';
			if($didPickedTeamOne)
				echo '<div class="col-md-9 col-xs-8 team '.$Team1.' game'.$GameCounter.' picked">';
			else  	echo '<div class="col-md-9 col-xs-8 team '.$Team1.' game'.$GameCounter.' unpicked">';
				echo '<span class="hidden">'.$GameCounter.', '.$Team1.'</span>';
				echo '</div>';
			echo '</div>';
			echo '<div class="row teamRow">';
				echo '<div class="col-md-2 col-xs-3 teamcol text-right">'; 
				echo ''.$Team2_Picked_Percent.'%';
				echo '</div>';
			if($didPickedTeamTwo) {
					 echo '<div class="col-md-9 col-xs-8 team '.$Team2.' game'.$GameCounter.' picked">'; 				
			}
			else { 			
					 echo '<div class="col-md-9 col-xs-8 team '.$Team2.' game'.$GameCounter.' unpicked">'; 
			}	
					
				echo '<span class="hidden">'.$GameCounter.', '.$Team2.'</span>';
				echo '</div>';
			echo '</div>';	
			echo '</div>';
			
			$GameCounter = $GameCounter + 1;
	
								
		}
		
		
?>

