<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$confrimDelete = false;
	
	if( isset($_COOKIE["username"]))
		$Username = $_COOKIE["username"];
	
	if( isset($_GET["delete"]))
		$confrimDelete = true;
	
	

	$sqlUser = "SELECT * FROM `User` WHERE Username = '$Username'";	
	$User = $conn->query($sqlUser);	
	while ($row = mysqli_fetch_array($User))
	{
			
			$Username = $row['Username'];
			$password = $row['password'];
			$password_hint = $row['password_hint'];
			$First_Name = $row['First_Name'];
			$Last_Name = $row['Last_Name'];		
			$facebook_link = $row['facebook_link'];
			$phone = $row['phone'];
	}
?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Edit Account</title>
      <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
      <!-- Ref section -->
      <link rel="stylesheet" type="text/css" href="style.css">
      <link rel="stylesheet" type="text/css" href="particle.css">
      <link rel="shortcut icon" href="../images/football.png" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Anton" />
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-102102344-2"></script>
      <script>
         window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
         gtag('js', new Date());
         
         gtag('config', 'UA-102102344-2');
      </script> 
      <style>
         .entry {
         margin-top: 10px;
         }
      </style>
   </head>
  <body style="background-color: #4B8241;">
  
<div id="app">
<header>  
     <div class="container">  
    <h1>Edit my Information</h1>   
      </div>
</header>   
 

    <div id="particle-container" class="visible-lg visible-md"></div>



      <div class="container area">     
      <div class="row">
         <div class="col-md-8 col-lg-7">

           <form action="../Php_Scripts/updateUser.php" method="post">
               <div class="row">
                  <div class="col-sm-8 entry">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input id="email" type="email" class="form-control" required   name="email" value="<?php if( isset($Username)) echo $Username; ?>" placeholder="Email">    
                     </div>
                  </div>
                  <div class="col-sm-4 entry">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="pin" type="password" required maxlength="4"  class="form-control" name="pin" placeholder="New Pin #">
                     </div>
                  </div>
               </div>
               <!-- ROW -->
               <div class="row">
                  <div class="col-sm-4 entry">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="fname" type="text" class="form-control" name="fname" value="<?php if( isset($First_Name)) echo $First_Name; ?>" placeholder="First Name">
                     </div>
                  </div>
                  <div class="col-sm-4 entry">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="lname" type="text" class="form-control" name="lname" value="<?php if( isset($Last_Name)) echo $Last_Name; ?>" placeholder="Last Name">
                     </div>
                  </div>
                  <div class="col-sm-4 entry">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-exclamation-sign"></i></span>
                        <input id="hint" type="text" class="form-control" name="hint" placeholder="Hint">
                     </div>
                  </div>
               </div>
               <!-- ROW -->
               <div class="row">
                  <div class="col-sm-7 entry">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>
                        <input id="facebook" type="text" class="form-control" name="facebook" value="<?php if( isset($facebook_link)) echo $facebook_link; ?>" placeholder="Link to Facebook Profile">
                     </div>
                  </div>
                  <div class="col-sm-5 entry">
                     <div class="input-group">
                       <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                        <input id="phone" type="phone" class="form-control" name="phone" value="<?php if( isset($phone)) echo $phone; ?>" placeholder="Phone #">
                     </div>
                  </div>
               </div> <!-- ROW -->
               
              	 <div class="row">
              	 
              	 
                 	 <div class="col-md-4 entry text-right pull-right">
               			 <button type="submit" id="submitNewUser" class="btn btn-primary">Update User</button>
                	
                  	</div>
               	</div> <!-- ROW -->
            </form>
            
             </div>
            <div class="col-md-4 col-lg-5 text-center Options">
             
             <div class="row">
              		<ul class="nav nav-pills nav-stacked">
  				<li><a href="https://pickemupsets.com/">Return to Home</a></li>
  				<?php 
  				if(!$confrimDelete) 
  					echo '<li><a href="https://pickemupsets.com/user/?delete=true">Delete Account</a></li>'; 
  				else
  					echo '<li><a href="http://pickemupsets.com/Php_Scripts/deleteuser.php"><b>Confirm Delete</b></a></li>'; 
  				
  				?>
            		</ul>
            </div>

            </div><!-- end of right-->

            </div> 
         </div>
      </div>

      
       <script src="particle.js" type="text/javascript"></script>
      
   </body>
</html>