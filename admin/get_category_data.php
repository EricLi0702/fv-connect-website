<?php
/***********************
Get category data
************************/
require_once('session.php');
require_once ('../Common/database.php');

$db=new db();

if(isset($_GET['cat_id']) && $_GET['type'] == 'description')
{
	$catId = $_GET['cat_id'];
	$catInfo = $db->query("select * from category where Id=" . $catId)->fetchArray();
	echo $catInfo['Description'];
}

if(isset($_GET['cat_id']) && $_GET['type'] == 'name')
{
	$catId = $_GET['cat_id'];
	$catInfo = $db->query("select * from category where Id=" . $catId)->fetchArray();
	echo $catInfo['Category'];
}

?>