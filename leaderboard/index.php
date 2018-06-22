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
			
	
    		$z = $conn->query("SELECT * FROM `User`");	
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
	#leaders {
		font-size: 1.6em;
		width: 85%;
		margin: auto;
		padding: 30px;
		background-image:url('w3css.gif');
    		background-repeat:no-repeat;
    		background-size:cover;
    		font-weight: bold;
    		
	}
	
	
	.entry {
		padding-top: 10px;
		margin-bottom: 10px;
	}
	
	
	.entry h2 {
		margin-top: 0px;
		font-size: 1.6em;
		font-weight: bold;
	}
	
	
	.links {
		font-size: 1.7em;
		float: right;
		position: -webkit-sticky;
 		position: sticky;
  		top: 0;
	
	}
	

	@media only screen and (max-width: 600px) {
	
		.entry {
			margin-bottom: 30px;
		}
		
		#leaders {
			width: 97%;			
		}
		
			
	.entry h2 {
		margin-top: 0px;
		font-size: 1.2em;
		font-weight: bold;
	}
	
	}
	
</style>
  <title>Pickem Upsets Leaders</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body style="background-color: #4B8241;">
  
  <div class="jumbotron" style="border-bottom: 5px solid black;">
	<div class="container">

    <h1>Leaderboard</h1>    
<p>Through week <?php echo $Currentweek; ?></p>  
<div class="links">
<a href="http://gokusama.com/picks18/">Home</a>
 </div>
</div> 
 </div> 
 <div class="container">
 	<div id="leaders">
 		<?php 
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
 	

 	</div>
</div>

</body>
</html>
