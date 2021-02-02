<?php
/***********************
Get category template category info
************************/
require_once('session.php');
require_once ('../Common/database.php');

$db=new db();
if(isset($_GET['template_name']))
{
	$template_name = $_GET['template_name'];
	$categories = $db->query("select * from category order by Id")->fetchAll();
	$categorieAll = $db->query("select * from category");
	$categoryCount = $categorieAll->numRows();
	$template_name = str_replace("'", "''", $template_name);
	$temlate_category_data = $db->query("select * from phase_template where Template='" . $template_name . "' order by Id")->fetchAll();
	
	if(count($temlate_category_data) > 0)
	{
		$row=0;
		$all_selected_cat_ids = "";
		$html = "<table id='tblCatInfo' style='width:100%;'>";
	foreach($temlate_category_data as $tcat)
	{
		$html .= "<tr>";
		$html .= "<td style='padding:5px; width:200px;'>";
		$html .= "<input type='hidden' id='Row_" . $row . '_' . $tcat['Id'] . "' value='" . $tcat['Id'] . "'/>";
		$html .= "<select name='lstTemplateCategory_" . $row . "' id='CategoryList_" . $row . "' class='lstcats'>";
		$selected_cat_id = "0";
		$selected_cat_name = "";
		foreach($categories as $cat)
		{
			if($tcat['Category'] == $cat['Category'])
			{
				$selected_cat_id = $cat['Id'];
				$selected_cat_name = $cat['Category'];
				if($all_selected_cat_ids == "")
				{
					$all_selected_cat_ids .= $cat['Id'];
				}
				else
				{
					$all_selected_cat_ids .= ',' . $cat['Id'];
				}
				$html .= "<option value='" . $cat['Id'] . "' selected='selected'>" . $cat['Category'] . "</option>";
			}
			else{
				$html .= "<option value='" . $cat['Id'] . "'>" . $cat['Category'] . "</option>";
			}
		}
		$html .= "</select>";
		$html .= "<input type='hidden' class='TemplateCats' id='SelectedCat_" . $row . "' value='" . $cat['Id'] . "'/>";
		$html .= "<input type='hidden' class='TemplateCatNames' name='SelectedCatName_" . $row . "' id='SelectedCatName_" . $row . "' value='" . $selected_cat_name . "'/>";
		$html .= "</td>";
		$html .= "<td style='padding:5px;'>";
		$html .= "<textarea name='txtDescription_" . $row . "' id='txtDescription_" . $row . "' cols='60' rows='5'>" . get_category_description_by_name($tcat['Category']) . "</textarea>";
		$html .= "</td>";
		$html .= "</tr>";
		$row++;
	}
		$html .= "</table>";
		$html .= "<input type='hidden' name='AllSelectedCatIds' id='AllSelectedCatIds' value='" . $all_selected_cat_ids . "'/>";
		$html .= "<input type='hidden' name= 'RowCount' id='RowCount' value='" . $row . "'/>";
		$html .= "<input type='hidden' id='CategoryCount' value='" . $categoryCount . "'/>";
		
		echo $html;
	}
}

function get_category_description_by_name($catName)
{
	$db=new db();
	$catInfo = $db->query("select * from category where Category='" . $catName . "'")->fetchArray();
	return $catInfo['Description'];
}

?>