<?php 
	$servername = "localhost";
	$username = "bradenborman1";
	$password = "BBorman";
	$dbname = "football_picks";
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if(isset($_POST["email"]))
		$email = $_POST["email"];
	
	if(isset($_POST["password"]))
		$password = $_POST["password"];
	
	

	
	
	
	$login = "SELECT * FROM User WHERE Username = '$email'";	
	$CheckSQL= $conn->query($login);

	while ($row = mysqli_fetch_array($CheckSQL))
		{
			if($row['Username'] == $email)
			{
				if(password_verify($password, $row['password']))
				
				{
				setcookie(username, $email, time() + (365 * 24 * 60 * 60), "/");
				header('Location: http://gokusama.com/picks18/');
				exit();
				}
			}
		} 
	
	setcookie("username", "",  time()-3600, "/");
	header('Location: http://gokusama.com/picks18/?loginmessage="Hey dumbass. Enter the correct info"');
	exit();

?>