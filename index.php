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
<link rel="stylesheet" type="text/css" href="modal.css"><script src="modal.js" type="text/javascript"></script>

</head>

<body style="background-color: #4B8241;">
<header>
<div class="container">
	<div id="TOPHEADER">
	<h2 id="h2tag">Borman Pickem Challenge</h2>
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
  					<input type="email" placeholder="email" name="email">  
  					<input type="text" placeholder="Pin" maxlength="4" name="password">
  					<input id="loginbtn" class="btn-success" type="submit">
  				</form>
			</div>
			
			<?php } 
			
			?></span>	
					
			<div class="links">
					<a href="#">Leaderboard</a>
					<a href="#" data-toggle="modal" data-target="#lab-slide-bottom-popup">New User</a>
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
	
	<div class="col-md-5  text-center" style="position: sticky; top: 230px;"><!--FORM AREA-->
		
			<div  id="Weekly_highscores">
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

<!-- MODAL CONTENT SAMPLE STARTS HERE -->
<div class="modal fade" id="lab-slide-bottom-popup" data-keyboard="false" data-backdrop="false">
  <div class="lab-modal-body"> 
  
  		<h1>Create User</h1>
  		<div class="well">
		<div class="row">
  			<div class="col-sm-6"><b>First Name: </b><input type="text" class="form-control" id="firstName"></div>
  			<div class="col-sm-6"><b>Last Name: </b><input type="text"  class="form-control" id="lastName"></div>
  		
		</div>
		<div class="row">
  			<div class="col-sm-5"><b>Email: </b><input type="email" class="form-control" id="newEmail"></div>
  			<div class="col-sm-2"><b>Pin #: </b><input type="password" maxlength="4" class="form-control" id="newpin"></div>
  			<div class="col-sm-5"><b>Password Hint:</b> <input type="text" class="form-control" id="hint"></div>
		</div>
		<br>
		<div class="row">
  			<div class="col-sm-3"><button id="submitNewUser" type="submit" >Create</button></div>
  			<div class="col-sm-3"><button id="clearmodel" type="button" data-dismiss="modal">Close</button></div>		
		</div>
  	</div>
<br><br> 
<div class="panel-group"> <h1>Helpful Hints</h1>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title">
          <a data-toggle="collapse" href="#collapse1"><span class="glyphicon glyphicon-asterisk"></span>  How to play</a>
        </h2>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
 <div class="panel-body"><p><b>Welcome to Pick the Upset Challenge 2018.</b> This Challenge will be active throughout the 2018-2019 NFL Season and each week, the user with the highest score will receive a price along with the grand champion after week 17. Each correctly picked game will result in a point. However, if the game qualifies as an upset, 3 points will be awarded if the lessor picked team won. A team qualifies if more less than 33.4% of users have picked them to win; nothing to do with point spread or forecast. Simple enough right? The only rule, picks must be made before kickoff on sunday for the week.</p></div>
      </div>
    </div>
    
 <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title">
          <a data-toggle="collapse" href="#collapse2"><span class="glyphicon glyphicon-asterisk"></span>  Picking</a>
        </h2>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
 <div class="panel-body"><p>Whichever logo is twice as big as the corresponding partner is the team you have picked for the current matchup. If the two appear to be equal in size, you have not made a pick for this game.</p></div>
      </div>
 </div>
 <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title">
          <a data-toggle="collapse" href="#collapse3"><span class="glyphicon glyphicon-floppy-saved"></span> Saving Picks</a>
        </h2>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
 <div class="panel-body"><p>If you are a returning user from last year, saving has been revamped majorly! Simply touching the team you want to pick is all that is required. From there a call to the database is made with all the info. The data is returned back and the percentages are up to date just like that.</p></div>
      </div>
 </div>
 <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title">
          <a data-toggle="collapse" href="#collapse4"><span class="glyphicon glyphicon-user"></span> Log In</a>
        </h2>
      </div>
      <div id="collapse4" class="panel-collapse collapse">
 <div class="panel-body"><p>Another huge upgrade this year, the ability to stay logged in week to week! Just make sure cookies are enabled. If you can't remember you login, you may hit the password reminder at the bottom of the page. I do not have a well thoughtout process for user helping. Please remember the 4 didget pin. Make it all 0's if you have to. Emails will only be used if you win and I send the giftcard info via the info provided</p></div>
      </div>
 </div>
</div>
	
	
  </div>
  <!-- /.modal-body -->
</div>
<!-- /.modal -->
<!-- END MODAL CONTENT SAMPLE -->


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

$(window).scroll(function (event) {
    if($(window).scrollTop() > 250) {
    	$("#h2tag").slideUp(700)
    	$(".dropdown").slideUp(700)
    }
    if($(window).scrollTop() == 0) {
    	$("#h2tag").slideDown(700)
    	$(".dropdown").slideDown(700)
    }		
    	
});
</script>



</body>
</html>
