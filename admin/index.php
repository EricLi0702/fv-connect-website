<?php
session_start();
if(isset($_SESSION["AdminUserEmail"])){
	header('location: setting.php');
}
else{
	header('location: login.php');
}
?>