<?php 

	setcookie("username", "",  time()-3600, "/");
	header('Location: https://pickemupsets.com/');
?>