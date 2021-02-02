<?php
function get_logo() {
	$upload_path = "assets/images/logo/";
	$logo_path = "";
	$db = new db();

	$data = $db->query("select * from config where Type='Logo'")->fetchArray();

	if ($data['Value'] != "")
		$logo_path = $upload_path . $data['Value'];

	return $logo_path;
}
?>