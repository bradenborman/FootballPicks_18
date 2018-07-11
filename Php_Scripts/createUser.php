<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	
		
	$isThere = false;	
	if (isset($_POST['fname']))
		$fname = mysql_escape_string($_POST['fname']);
		
	if (isset($_POST['lname']))
		$lname = mysql_escape_string($_POST['lname']);
		
	if (isset($_POST['email']))
		$email = mysql_escape_string($_POST['email']);
		
	if (isset($_POST['pin']))
		$pin = mysql_escape_string($_POST['pin']);
		
	if (isset($_POST['hint']))
		$hint = mysql_escape_string($_POST['hint']);
	
	if (isset($_POST['group']))
		$group = mysql_escape_string($_POST['group']);
		
		
	/*CHECK TO SEE IF ALREADY IN THE DATABASE  */
	
	$GetUsers = "SELECT * FROM `User`";	
	$USERSSQL = $conn->query($GetUsers);
	while ($row = mysqli_fetch_array($USERSSQL))
		if($row['Username'] == $email)
				$isThere = True;
	
	/*END ******/
	
	
	
	if($isThere) { 
	header('Location: https://pickemupsets.com/');
	}else
	{
		/***CHECK FOR ALL FEILDS POPULATED ***/
	
		if (isset($fname) && isset($lname) && isset($email) && isset($pin) && isset($hint))
		{
		
			//**** GOOD TO ADD TO DATABASE ***///
		
		
			$secret = password_hash($pin, PASSWORD_BCRYPT);
			
			$sql = "INSERT INTO `football_picks`.`User` (`User_ID`, `Username`, `password`, `password_hint`, `First_Name`, `Last_Name`, `Group_ID`) VALUES (NULL, '$email', '$secret', '$hint', '$fname', '$lname', '$group')";
			if (!mysqli_query($conn, $sql))
  			{
  				echo("Error description: " . mysqli_error($conn));
  			}else
  			{
  				setcookie(username, $email, time() + (365 * 24 * 60 * 60), "/");
				header('Location: https://pickemupsets.com/');
				exit();
  			}

		}	
		else {
			header('Location: https://pickemupsets.com/');
		}
	
	
	}	
	
	
	
	
	
	
	/*
	
	$stored_secret = password_hash($password, PASSWORD_BCRYPT);
	echo "<br><br>";
	echo password_verify($password, $stored_secret);




	echo $fname;
	echo $lname;
	echo $password;
	echo $pin;
	echo $hint;

*/
?>

