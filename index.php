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
      <title>Pick'em</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Ref section -->
      <link rel="stylesheet" type="text/css" href="style.css">
      <link rel="stylesheet" type="text/css" href="logo.css">
      <link rel="shortcut icon" href="images/football.png" />
      <link href='https://fonts.googleapis.com/css?family=Seymour One' rel='stylesheet'>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link href='https://fonts.googleapis.com/css?family=Numans' rel='stylesheet'>
      <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet'>
      <link href='https://fonts.googleapis.com/css?family=IBM Plex Serif' rel='stylesheet'>
      <link rel="stylesheet" type="text/css" href="modal.css">
      <script src="modal.js" type="text/javascript"></script>
   </head>
   <body style="background-color: #4B8241;">
      <header>
         <div class="container">
            <div id="TOPHEADER">
               <h2 id="h2tag">Borman Pickem Challenge</h2>
               <div class="dropdown" style="float:right;">
                  <button class="dropbtn"><span class="glyphicon glyphicon-menu-hamburger"></span></button>
                  <div class="dropdown-content">
                     <a href="leaderboard/">Leaderboard</a>
                     <?php if( !isset($_COOKIE["username"])) echo '<a href="#" data-toggle="modal" data-target="#lab-slide-bottom-popup">New User</a>';?>
                     <?php if( isset($_COOKIE["username"])) echo '<a href="Php_Scripts/logout.php">Log out</a>';  ?>
                  </div>
               </div>
            </div>
            <span style="float: left; margin-left: 5px;" id="username">
               <?php if( isset($_COOKIE["username"])) echo $_COOKIE["username"]; else { ?>
               <div class="row">
                  <form action="Php_Scripts/login.php" method="post">
                     <input type="email" placeholder="email" name="email">  
                     <input type="text" placeholder="Pin" maxlength="4" name="password">
                     <input id="loginbtn" class="btn-success" value="Login" type="submit">
                  </form>
               </div>
               <?php } 
                  ?>
            </span>
            <div class="links">
               <a href="leaderboard/">Leaderboard</a>
                <?php if( !isset($_COOKIE["username"])) echo '<a href="#" data-toggle="modal" data-target="#lab-slide-bottom-popup">New User</a>';?>
               <?php if( isset($_COOKIE["username"])) echo '<a href="Php_Scripts/logout.php">Log out</a>';  ?>
            </div>
         </div>
      </header>
      <div class="container">
         <div class="row">
            <div class="col-md-8">
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
               <div id="DisplayGamesArea"></div>
               <!-- End of Games Area -->
            </div>
            <!-- End of col-8 -->
            <div class="col-md-4  text-center" style="position: sticky; top: 230px;">
               <!--FORM AREA-->
               <div  id="Weekly_highscores">
                  <h2 style="text-align: center;">Weekly Winners</h2>
                  
                  <div id="weeklyLeaders">
                  <?php include 'Php_Scripts/weeklyhighscores.php';?>
                  </div>
                  
               </div>
               <br><Br>
               <div id="Picked"></div>
            </div>
         </div>
      </div>
      
      
          
      
      <!-- MODAL CONTENT STARTS HERE -->
      <div class="modal fade" id="lab-slide-bottom-popup" data-keyboard="false" data-backdrop="false">
         <div class="lab-modal-body">
            <h1>Create User</h1>
            <div class="row">
               <form action="Php_Scripts/createUser.php" method="post">
                  <div class="row">
                     <div class="col-sm-6"><b>First Name: </b><input type="text" required name="fname" class="form-control" id="firstName"></div>
                     <div class="col-sm-6"><b>Last Name: </b><input type="text"  required  name="lname" class="form-control" id="lastName"></div>
                  </div>
                  <div class="row">
                     <div class="col-sm-9"><b>Email: </b><input type="email" required name="email" class="form-control" id="newEmail"></div>
                     <div class="col-sm-3"><b>Pin #: </b><input type="password" required  name="pin" maxlength="4" class="form-control" id="newpin"></div>
                  </div>
                  <div class="row">                                      
                     <div class="col-sm-6"><b>Password Hint:</b> <input required  type="text" name="hint" class="form-control" id="hint"></div>
                     <div class="col-sm-6"><b>Group:</b> 
                     
                     
                     		<select class="form-control" id="group_Selector" name="group">
                     			 <?php 
      						$sql = $conn->query("SELECT * FROM `Groups`");	
						while ($row = mysqli_fetch_array($sql))
						{
							echo '<option value="'.$row['Group_ID'].'">'.$row['Group_Name'].'</option>';
							
						}	 ?>

                     		</select>
                     </div>
                  </div>
                  <br>
                  <div class="row">
                     <div class="col-sm-3"><button id="submitNewUser" type="submit" >Create</button></div>
                     <div class="col-sm-3"><button id="clearmodel"  type="button" data-dismiss="modal">Close</button></div>
                  </div>
               </form>
            </div>
         </div>
         <!-- ROW -->
         <!-- /.modal-body -->
      </div>
      <!-- /.modal -->
      <!-- END MODAL CONTENT -->
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
      
      <div id="snackbar"> <?php if(isset($_GET["loginmessage"])) echo $_GET["loginmessage"]; ?></div>
      
      <?php 
      		
      		if(isset($_GET["loginmessage"]))
      			echo '<script>
    					var x = document.getElementById("snackbar");
    					x.className = "show";
    					setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);				
				
				</script>';      	
      ?>
      
      	
      
   </body>
</html>
