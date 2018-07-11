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
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Pickem Upsets Leaders</title>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="style.css">
      <link rel="shortcut icon" href="../images/football.png" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet'>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
   </head>
   <body style="background-color: #4B8241;">
      <header>
         <div class="headerWrapper">
            <div class="container header">
               <div class="info">
                  <h1>Leaderboard</h1>
                  Through week <?php echo $Currentweek; ?>           
               </div>
               <div class="links">
                  <a href="https://pickemupsets.com/">Home</a>              
               </div>
            </div>
         </div>
      </header>
      <div class="container">
         <select id="group_Selector" class="form-control" onChange="displayLeaderboard()" name="group">
            <option value="0">All Playing</option>
            <?php 
               $sql = $conn->query("SELECT * FROM `Groups`");	
               while ($row = mysqli_fetch_array($sql))
               {
               echo '<option value="'.$row['Group_ID'].'">'.$row['Group_Name'].'</option>';
               
               }	 ?>
         </select>
         <div class="row">
            <div class="col-md-9">
               <div data-toggle="tooltip"  title="Scoll on me to see more scores!" id="leaders">
                 
                 
                  <div id="contentL">
                 
                 
                  <?php 
                     arsort($Scores);
                     $highestScore = 0;
                    
                     foreach($Scores as $x => $x_value) {
                     if($highestScore < $x_value) 
                      				$highestScore = $x_value; 
                      				//GET HIGH SCORE	
                     
                      			?>
                  <div class="row entry">
                     <div class="col-sm-6">
                        <h2>		
                          <?php echo  $x; ?>
                        </h2>
                        <span id="score"><?php echo  $x_value; ?></span> 
                     </div>
                     <div class="col-sm-6 hidden-xs">	
                        <progress style="width:100%; margin-top: 20px;" value="<?php echo $x_value; ?>" max="<?php echo $highestScore; ?>"></progress>
                     </div>
                  </div>
                  <?php  
  			   			
                     }			
                     ?>
                     
       
                     
                     
                   </div>    
                     
                     
                     
                     
                     
               </div>
            </div>
            <div class="col-md-3">
            	<div class="well">
			<center><h4><b>Additional Resources</b></h4><hr style="margin: 0px;">
				<div style="min-height: 80px;" id="lab_social_icon_footer">
					<a style="display: none;" class="linkk" href="https://www.facebook.com/bradenborman"><i id="social-fb" class="fa fa-facebook-square fa-3x social"></i></a>
					<a style="display: none;" class="linkk" href="https://twitter.com/middle_Borman?lang=en"><i id="social-tw" class="fa fa-twitter-square fa-3x social"></i></a>	            
					<a style="display: none;" class="linkk" href="https://www.linkedin.com/in/bradyborman/"><i id="social-lk" class="fa fa-linkedin-square fa-3x social"></i></a> 	                   
					<a style="display: none;" class="linkk" href="mailto:bradenborman00@gmail.com"><i id="social-em" class="fa fa-envelope-square fa-3x social"></i></a>
				</div>
		</div>
            
            </div>
            
            
         </div>
      </div>
      <script>
         function displayLeaderboard() {
            var group = document.getElementById("group_Selector").value;
         
            var xhttp;
           if (window.XMLHttpRequest) {
             xhttp = new XMLHttpRequest();
             } else {
             xhttp = new ActiveXObject("Microsoft.XMLHTTP");
           }
           xhttp.onreadystatechange = function() {
             if (this.readyState == 4 && this.status == 200) {
               document.getElementById("leaders").innerHTML = '<div id="contentL">' + this.responseText + '</div>';
             }
           };
           xhttp.open("POST", "../Php_Scripts/leaderboard.php?groupID=" + group, true);
           xhttp.send();
           
             
         }
         
         
         
         /* Storing highscores in two parral arrays. For paganation */
         
         var Names = []
         var Scores = []
         
         <?php
          foreach($Scores as $x => $x_value) {
        
         ?>
         
         	Names.push("<?php echo $x;  ?>") 
         	Scores.push("<?php echo $x_value;  ?>") 
         	
         <?php	
        	}
      	 ?>

         //alert(Names)
      //   alert(Scores)
         
         
         
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    //"HOVER ON CLIP BOARD => Scoll on me to see all the sco"
});
         
	
		 
         
         
         
         
      </script>
      
<script>
$(document).ready(function(){
			
        $(".linkk:nth-child(1)").delay(1200).fadeIn(1100);
		$(".linkk:nth-child(2)").delay(1200).fadeIn(2200);
		$(".linkk:nth-child(3)").delay(1200).fadeIn(3300);
		$(".linkk:nth-child(4)").delay(1200).fadeIn(4400);
});
</script>
      
   </body>
</html>