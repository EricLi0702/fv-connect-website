<?php
session_start();
require_once('../Common/config.php');

if(!isset($_SESSION["AdminUserEmail"]))
{
	header('location: ' . ROOTURL . 'admin/login.php');
}
?>