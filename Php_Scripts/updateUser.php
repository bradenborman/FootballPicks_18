<?php
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	
	if( isset($_COOKIE["username"]))
		$Username = $_COOKIE["username"];
	$sqlUser = "SELECT * FROM `User` WHERE Username = '$Username'";	
	$User = $conn->query($sqlUser);	
	while ($row = mysqli_fetch_array($User))
			$USERID = $row['User_ID'];
	
	
		
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
		
	if (isset($_POST['facebook']))
		$facebook = mysql_escape_string($_POST['facebook']);	
		
	if (isset($_POST['phone']))
		$phone = mysql_escape_string($_POST['phone']);	
	
	$secret = password_hash($pin, PASSWORD_BCRYPT);



	//NEED TO CHECK TO SEE IF EMAIL ALREADY EXSIST BEFORE ALLOWING TO CHANGE 
	$GetUsers = "SELECT * FROM `User`";	
	$USERSSQL = $conn->query($GetUsers);
	while ($row = mysqli_fetch_array($USERSSQL))
		if($row['Username'] == $email)
				$isThere = True;
	
	if($isThere) //Meaning this is already in the database --dont allow it to be duplicated. if its really them then it would just repalce anyway so dont add it
	{
		$updateUser = "UPDATE `football_picks`.`User` SET password = '$secret', password_hint = '$hint', First_Name = '$fname', Last_Name = '$lname', facebook_link = '$facebook', phone= '$phone' WHERE `User_ID` = $USERID";
		echo 'already there';
	}
	else { //Set the new email to cookie and then allow the change 
		setcookie(username, $email, time() + (365 * 24 * 60 * 60), "/");
		$updateUser = "UPDATE `football_picks`.`User` SET Username = '$email', password = '$secret', password_hint = '$hint', First_Name = '$fname', Last_Name = '$lname', facebook_link = '$facebook', phone= '$phone' WHERE `User_ID` = $USERID";
		
	}
	

	
	if (!mysqli_query($conn, $updateUser))
	{	
		echo("Error description: " . mysqli_error($conn));
		echo "sadf";
	}else {
		header('Location: https://pickemupsets.com/"');
		exit();
	}
			
	
  
  
  
  
?>
