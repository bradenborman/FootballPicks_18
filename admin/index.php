<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	
		
	  if(!isset($_GET["allowed"]))
	  { 
	 
	  ?>
	  					<script>
    								var PasswordEntered = prompt("Admin Password: ", "PASSWORD");
    								
 									
 			   										
						</script>
	 <?php 
	 } else{
	 
	 	if($_GET["allowed"] != truee)
	 		header('Location: https://pickemupsets.com/');
	 }
	  
		
			
		
			
	$w = $conn->query("SELECT Game_Current_Week FROM `Game_Settings`");	
	while ($row = mysqli_fetch_array($w))
		$week = $row['Game_Current_Week'];
		
		
	$lockedWeeks = array();
	$w = $conn->query("SELECT * FROM `Game_Settings`");	
	while ($row = mysqli_fetch_array($w))	
		{ array_push($lockedWeeks, $row['locked_week1']);array_push($lockedWeeks, $row['locked_week2']);array_push($lockedWeeks, $row['locked_week3']);array_push($lockedWeeks, $row['locked_week4']);array_push($lockedWeeks, $row['locked_week5']);array_push($lockedWeeks, $row['locked_week6']);array_push($lockedWeeks, $row['locked_week7']);array_push($lockedWeeks, $row['locked_week8']);array_push($lockedWeeks, $row['locked_week9']);array_push($lockedWeeks, $row['locked_week10']);array_push($lockedWeeks, $row['locked_week11']);array_push($lockedWeeks, $row['locked_week12']);array_push($lockedWeeks, $row['locked_week13']);array_push($lockedWeeks, $row['locked_week14']);array_push($lockedWeeks, $row['locked_week15']);array_push($lockedWeeks, $row['locked_week16']);array_push($lockedWeeks, $row['locked_week17']);	
	      	}
	       		
	echo '<div class="jumbotron"><div class="container"><h1>Admin</h1><h2>Current Week: '.$week.'</h2></div></div>';
	
	?>
	<div class="container">
		
	<div class="row">
		<div class="col-md-4">
		
			<h2>Enter Winners</h2><hr>
			<div style="margin-bottom: 20px;" class="row">
			<form action="index.php" method="post">
			<div class="col-md-12">Winner: <input readonly class="form-control" type="text" name="winner" id="winnerTxt"></div>
			<div class="col-md-6">Game Id: <input readonly required class="form-control" type="text" name="gameID" id="gameTxt"></div>
			<div class="col-md-6"><br><input class="btn btn-primary btn-block" type="submit"></div>
			</form>
			</div>	
			
			
			

	
	
	
	<?php
	
	$games = $conn->query("SELECT * FROM `Games` WHERE Week_ID = '$week'");	
	while ($row = mysqli_fetch_array($games))	
		if($row['Game_Winner'] == null)
			echo '<div style="text-align: center;" class="row"><div class="match"><div class="gameID">' .$row['Game_ID']. '</div> <div class="team">' . $row['Game_Team1']. '</div> <div class="team">' . $row['Game_Team2']. '</div></div></div>';
	

	$winner = $_POST['winner'];
	$game = $_POST['gameID'];
	
   	if(isset($_POST["gameID"]) && isset($_POST["winner"]))
	{	
		$sql = "UPDATE `football_picks`.`Games` SET  `Game_Winner` = '$winner'  WHERE `Games`.`Game_ID` = $game";
		if (!mysqli_query($conn, $sql))
  		 echo("Error description: " . mysqli_error($conn));
  		 else {		
  			header('Location: https://pickemupsets.com/admin/index.php?allowed=truee');
			exit();
		}
	}	
	
	

?>	




	</div>
		<div class="col-md-4 text-center">
		
		<h2>Change week</h2>
			<form action="../Php_Scripts/changeWeek.php" method="Post">
  			<select id="week_Selector" name="week_Selector">
                        <option value="1" <?php if($week == 1) echo "Selected"; ?>>Week 1</option>
                        <option value="2" <?php if($week == 2) echo "Selected"; ?>>Week 2</option>
                        <option value="3" <?php if($week == 3) echo "Selected"; ?>>Week 3</option>
                        <option value="4" <?php if($week == 4) echo "Selected"; ?>>Week 4</option>
                        <option value="5" <?php if($week == 5) echo "Selected"; ?>>Week 5</option>
                        <option value="6" <?php if($week == 6) echo "Selected"; ?>>Week 6</option>
                        <option value="7" <?php if($week == 7) echo "Selected"; ?>>Week 7</option>
                        <option value="8" <?php if($week == 8) echo "Selected"; ?>>Week 8</option>
                        <option value="9" <?php if($week == 9) echo "Selected"; ?>>Week 9</option>
                        <option value="10" <?php if($week == 10) echo "Selected"; ?>>Week 10</option>
                        <option value="11" <?php if($week == 11) echo "Selected"; ?>>Week 11</option>
                        <option value="12" <?php if($week == 12) echo "Selected"; ?>>Week 12</option>
                        <option value="13" <?php if($week == 13) echo "Selected"; ?>>Week 13</option>
                        <option value="14" <?php if($week == 14) echo "Selected"; ?>>Week 14</option>
                        <option value="15" <?php if($week == 15) echo "Selected"; ?>>Week 15</option>
                        <option value="16" <?php if($week == 16) echo "Selected"; ?>>Week 16</option>
                        <option value="17" <?php if($week  == 17) echo "Selected"; ?>>Week 17</option>
                     </select>
  				<br><br>
  			<input type="submit">
			</form>
			
			
			<br>
			
			<h2>RESET GAME</h2><form action="../Php_Scripts/StartNewGame.php" method="Post">
			 <input type="checkbox" name="restart" value="true">Reset:
			 <input type="submit">
			 </form>
			
			
			
		</div>
		
		
		<div class="col-md-4 text-left">
		
		
			<form action="../Php_Scripts/lockPicks.php" method="Post">
				Week 1<label class="switch"><input type="checkbox" <?php if($lockedWeeks[0] == 1) echo "checked";   ?> name="week1"><span class="slider round"></span></label>
				Week 2<label class="switch"><input type="checkbox" <?php if($lockedWeeks[1] == 1) echo "checked";   ?> name="week2"><span class="slider round"></span></label>
				Week 3<label class="switch"><input type="checkbox" <?php if($lockedWeeks[2] == 1) echo "checked";   ?> name="week3"><span class="slider round"></span></label>
				Week 4<label class="switch"><input type="checkbox" <?php if($lockedWeeks[3] == 1) echo "checked";   ?> name="week4"><span class="slider round"></span></label>
				Week 5<label class="switch"><input type="checkbox" <?php if($lockedWeeks[4] == 1) echo "checked";   ?> name="week5"><span class="slider round"></span></label>
				Week 6<label class="switch"><input type="checkbox" <?php if($lockedWeeks[5] == 1) echo "checked";   ?> name="week6"><span class="slider round"></span></label>
				Week 7<label class="switch"><input type="checkbox" <?php if($lockedWeeks[6] == 1) echo "checked";   ?> name="week7"><span class="slider round"></span></label>
				Week 8<label class="switch"><input type="checkbox" <?php if($lockedWeeks[7] == 1) echo "checked";   ?> name="week8"><span class="slider round"></span></label>
				Week 9<label class="switch"><input type="checkbox" <?php if($lockedWeeks[8] == 1) echo "checked";   ?> name="week9"><span class="slider round"></span></label>
				Week 10<label class="switch"><input type="checkbox" <?php if($lockedWeeks[9] == 1) echo "checked";   ?> name="week10"><span class="slider round"></span></label>
				Week 11<label class="switch"><input type="checkbox" <?php if($lockedWeeks[11] == 1) echo "checked";   ?> name="week11"><span class="slider round"></span></label>
				Week 12<label class="switch"><input type="checkbox" <?php if($lockedWeeks[11] == 1) echo "checked";   ?> name="week12"><span class="slider round"></span></label>
				Week 13<label class="switch"><input type="checkbox" <?php if($lockedWeeks[12] == 1) echo "checked";   ?> name="week13"><span class="slider round"></span></label>
				Week 14<label class="switch"><input type="checkbox" <?php if($lockedWeeks[13] == 1) echo "checked";   ?> name="week14"><span class="slider round"></span></label>
				Week 15<label class="switch"><input type="checkbox" <?php if($lockedWeeks[14] == 1) echo "checked";   ?> name="week15"><span class="slider round"></span></label>
				Week 16<label class="switch"><input type="checkbox" <?php if($lockedWeeks[15] == 1) echo "checked";   ?> name="week16"><span class="slider round"></span></label>
				Week 17<label class="switch"><input type="checkbox" <?php if($lockedWeeks[16] == 1) echo "checked";   ?>name="week17"><span class="slider round"></span></label>
				
			<br><br>
  			<input type="submit">
			</form>
		
		</div>


	</div>
		
</div>


<html>
<head><title>Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>	
	body {
		font-size: 2em;
	}
	
	.gameID {
		color: red;
		display: inline-block;
		max-width: 1px;
		 visibility: hidden;
	}
	.team {
		margin-right: 20px;
		display: inline-block;
		padding: 5px;
	}
	
.switch {
  position: relative;
  display: block;
  width: 60px;
  height: 34px;
  margin-bottom: 20px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
</head>
<body onLoad="Load()">
<script>
$(".gameID").click(function(){
   $("#gameTxt").val($(this).text());
});
$(".team").click(function(){

	var Match = $(this).parents(".match"); 
	var id = Match.find(".gameID").text()
	
   $("#gameTxt").val(id);
   $("#winnerTxt").val($(this).text());
});

function Load() {
	if(PasswordEntered == "borm00")
		window.location.assign("https://pickemupsets.com/admin/index.php?allowed=truee")
	else
		window.location.assign("https://pickemupsets.com/")
}

</script>




</body>
</html>