<?php

$host 	  = 'localhost';
$username = 'ea8q7bm_fvapi1';
$password = 'GoApi123!';
$db 	  = 'ea8q7bm_filevineapi';

$con = mysqli_connect($host, $username, $password, $db);

// Check connection
if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>