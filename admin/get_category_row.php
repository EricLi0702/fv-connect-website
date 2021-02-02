<?php
/***********************
Get selected category data
************************/
require_once('session.php');
require_once ('../Common/database.php');
$db=new db();

$catlstId = "New_". rand(1001,9999);
$categories = $db->query("select * from category order by Id")->fetchAll();

if(isset($_GET['row']))
{
	$html = "<tr>";
	$html .= "<td>";
	$html .= "<select name='lstTemplateCategory_" . $_GET['row'] . "' id='CategoryList_" . $_GET['row'] . "' class='lstcats'>";
	$html .= "<option value='0'>--Select Category--</option>";
	foreach($categories as $cat)
	{
		$html .= "<option value='" . $cat['Id'] . "'>" . $cat['Category'] . "</option>";
	}
	$html .= "</select>";
	$html .= "<input type='hidden' class='TemplateCats' id='SelectedCat_[" .$_GET['row'] . "]' value='0'/>";
	$html .= "<input type='hidden' class='TemplateCatNames' name='SelectedCatName_" . $_GET['row'] . "' id='SelectedCatName_" . $_GET['row'] . "' value=''/>";
	$html .= "</td>";
	$html .= "<td>";
	$html .= "<textarea name='txtDescription_" . $_GET['row'] . "' id='txtDescription_" . $_GET['row'] . "' cols='60' rows='5'></textarea>";
	$html .= "</td>";
	$html .= "</tr>";

	echo $html;
}
