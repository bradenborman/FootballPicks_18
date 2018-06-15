<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$isThere = false;	
	if (isset($_POST['fname']))
		$fname = $_POST['fname'];
		
	if (isset($_POST['lname']))
		$lname = $_POST['lname'];
		
	if (isset($_POST['email']))
		$email = $_POST['email'];
		
	if (isset($_POST['pin']))
		$pin = $_POST['pin'];
		
	if (isset($_POST['hint']))
		$hint = $_POST['hint'];

	/*CHECK TO SEE IF ALREADY IN THE DATABASE  */
	
	$GetUsers = "SELECT * FROM `User`";	
	$USERSSQL = $conn->query($GetUsers);
	while ($row = mysqli_fetch_array($USERSSQL))
		if($row['Username'] == $email)
				$isThere = True;   /*END ******/
	if($isThere) { 
	header('Location: http://gokusama.com/picks18/');
	}else
	{	/***CHECK FOR ALL FEILDS POPULATED ***/
		if (isset($fname) && isset($lname) && isset($email) && isset($pin) && isset($hint))
		{
			//**** GOOD TO ADD TO DATABASE ***///
			$secret = password_hash($pin, PASSWORD_BCRYPT);
			
			$sql = "INSERT INTO `football_picks`.`User` (`User_ID`, `Username`, `password`, `password_hint`, `First_Name`, `Last_Name`) VALUES (NULL, '$email', '$secret', '$hint', '$fname', '$lname')";
			if (!mysqli_query($conn, $sql))
  			{
  				echo("Error description: " . mysqli_error($conn));
  			}else
  			{
  				setcookie(username, $email, time() + (365 * 24 * 60 * 60), "/");
				header('Location: http://gokusama.com/picks18/');
				exit();
  			}
		}else header('Location: http://gokusama.com/picks18/');
	}	
?>

