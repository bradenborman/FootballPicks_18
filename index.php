<?php 
$servername = "localhost";
$username = "bradenborman1";
$password = "BBorman";
$dbname = "football_picks";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

	$sql = "SELECT * FROM `Game_Settings`";		
	$Settings = $conn->query($sql);
		while ($row = mysqli_fetch_array($Settings))
		{		
			$CurrentWeek = $row['Game_Current_Week'];			
		}
	
			
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pick'em</title><meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Ref section --><link rel="stylesheet" type="text/css" href="style.css"><link rel="stylesheet" type="text/css" href="logo.css"><link rel="shortcut icon" href="images/football.png" /><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script><link href='https://fonts.googleapis.com/css?family=Numans' rel='stylesheet'><link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet'><link href='https://fonts.googleapis.com/css?family=IBM Plex Serif' rel='stylesheet'>
</head>

<body style="background-color: #4B8241;">
<header>
<div class="container">
	<div id="TOPHEADER">
	<h2>Borman Pickem Challenge</h2>
  <div class="dropdown" style="float:right;">
  <button class="dropbtn"><span class="glyphicon glyphicon-menu-hamburger"></span></button>
  <div class="dropdown-content">
    <a href="#">Leaderboard</a>
	<a href="#">Comments</a><hr>
	<?php if( isset($_COOKIE["username"])) echo '<a href="Php_Scripts/logout.php">Log out</a>';  ?>
  </div>
</div>
</div>
				
			<span style="float: left; margin-left: 5px;" id="username"><?php if( isset($_COOKIE["username"])) echo $_COOKIE["username"]; else { ?>
			
			<div class="row">
				<form action="Php_Scripts/login.php" method="post">
  					<div class="col-lg-5"><input type="text" placeholder="username" name="Username"></div>   <div class="col-lg-5"><input type="text" placeholder="Pin" name="password"></div>
  					<div class="col-lg-2 pull-right"><input class="btn-success" type="submit"></div> 
  				</form>
			</div>
			
			<?php } 
			
			?></span>	
					
			<div class="links">
					<a href="#">Leaderboard</a>
					<a href="#">Comments</a>
					<?php if( isset($_COOKIE["username"])) echo '<a href="Php_Scripts/logout.php">Log out</a>';  ?>
			</div>	
</div>
</header>
<div class="container">


<div class="row">
	<div class="col-md-7">
		<div id="PICKEMGAME_INFO">
			<div class="row">
				<select id="week_Selector" name="week_Selector" onchange="loadGames()">
						<option value="1" <?php if($CurrentWeek == 1) echo "Selected"; ?>>Week 1</option>
						<option value="2" <?php if($CurrentWeek == 2) echo "Selected"; ?>>Week 2</option>
						<option value="3" <?php if($CurrentWeek == 3) echo "Selected"; ?>>Week 3</option>
						<option value="4" <?php if($CurrentWeek == 4) echo "Selected"; ?>>Week 4</option>
						<option value="5" <?php if($CurrentWeek == 5) echo "Selected"; ?>>Week 5</option>
						<option value="6" <?php if($CurrentWeek == 6) echo "Selected"; ?>>Week 6</option>
						<option value="7" <?php if($CurrentWeek == 7) echo "Selected"; ?>>Week 7</option>
						<option value="8" <?php if($CurrentWeek == 8) echo "Selected"; ?>>Week 8</option>
						<option value="9" <?php if($CurrentWeek == 9) echo "Selected"; ?>>Week 9</option>
						<option value="10" <?php if($CurrentWeek == 10) echo "Selected"; ?>>Week 10</option>
						<option value="11" <?php if($CurrentWeek == 11) echo "Selected"; ?>>Week 11</option>
						<option value="12" <?php if($CurrentWeek == 12) echo "Selected"; ?>>Week 12</option>
						<option value="13" <?php if($CurrentWeek == 13) echo "Selected"; ?>>Week 13</option>
						<option value="14" <?php if($CurrentWeek == 14) echo "Selected"; ?>>Week 14</option>
						<option value="15" <?php if($CurrentWeek == 15) echo "Selected"; ?>>Week 15</option>
						<option value="16" <?php if($CurrentWeek == 16) echo "Selected"; ?>>Week 16</option>
						<option value="17" <?php if($CurrentWeek == 17) echo "Selected"; ?>>Week 17</option>								
				</select>
			</div>
		</div>

		<div id="DisplayGamesArea"></div><!-- End of Games Area -->
	</div> 
	
	
	<!-- End of col-7 -->
	
	<div class="col-md-5  text-center"><!--FORM AREA-->
		
			<div id="Weekly_highscores">
				<h2 style="text-align: center;">Weekly Winners</h2>
					<div class="row">
						<div class="col-xs-12"> 
							1) Placeholder name <span style="float: right;">14points</span>
						</div>				
					</div>	
					<div class="row">
						<div class="col-xs-12"> 
							2) Placeholder name <span style="float: right;">16points</span>
						</div>				
					</div>	
					<div class="row">
						<div class="col-xs-12"> 
							3) Placeholder name <span style="float: right;">11points</span>
						</div>				
					</div>	
					<div class="row">
						<div class="col-xs-12"> 
							4) Placeholder name <span style="float: right;">10points</span>
						</div>				
					</div>	
			</div>
			<br><Br>
			<div id="Picked"></div>
	</div>
		
	</div>
</div>


<footer></footer>
<?php if( isset($_COOKIE["username"])) echo '<script src="script.js" type="text/javascript"></script>';  ?>



<script>
loadGames()
function loadGames() {
   var weekSelected = document.getElementById("week_Selector").value;

   var xhttp;
  if (window.XMLHttpRequest) {
    xhttp = new XMLHttpRequest();
    } else {
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("DisplayGamesArea").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "Php_Scripts/displayGames.php?week=" + weekSelected, true);
  xhttp.send();
  
    
}

setInterval(function(){ loadGames() }, 7000);
</script>



</body>
</html>
