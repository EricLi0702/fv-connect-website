<?php
require_once ('session.php');
require_once ('../Common/database.php');
require_once ('../Common/functions.php');

$message = "";
$Logo_Path = "";
$Product_License = "";
$API_Key = "";
$API_Secret = "";

if(isset($_POST['ProductLicense']) && isset($_POST['ApiKey'])) {

	$Product_License = $_POST['ProductLicense'];
	$API_Key = $_POST['ApiKey'];
	$API_Secret = $_POST['ApiSecret'];
	$Logo_name = basename($_FILES["LogoFile"]["name"]);

	$upload_path = "../assets/images/logo";

	if(!is_dir($upload_path))
		mkdir($upload_path, 0777);

	$Logo_Path = $upload_path . '/' . $Logo_name;

	$db = new db();

	$db->query("update config set Value='" . $Product_License . "', Updated_at = '" . date("Y-m-d H:i:s") . "' where type='Product License'");
	$db->query("update config set Value='" . $API_Key . "', Updated_at = '" . date("Y-m-d H:i:s") . "' where type='API Key'");
	$db->query("update config set Value='" . $API_Secret . "', Updated_at = '" . date("Y-m-d H:i:s") . "' where type='Key Secret'");

	if($Logo_name != "") {
		$db->query("update config set Value='" . $Logo_name . "', Updated_at = '" . date("Y-m-d H:i:s") . "' where type='Logo'");
		move_uploaded_file($_FILES["LogoFile"]["tmp_name"], $Logo_Path);

		$message = "Config data successfully updated!";
	} else {
		$LogoInfo = $db->query("select * from config where type='Logo'")->fetchArray();
		$Logo_name = $LogoInfo['Value'];
	}
	$Logo_Path = $Logo_name;
} else {
	
	$db = new db();

	$LicenseInfo = $db->query("select * from config where type='Product License'")->fetchArray();
	$ApiKeyInfo = $db->query("select * from config where type='API Key'")->fetchArray();
	$ApiSecretInfo = $db->query("select * from config where type='Key Secret'")->fetchArray();
	$LogoInfo = $db->query("select * from config where type='Logo'")->fetchArray();
	
	$Product_License = $LicenseInfo['Value'];
	$API_Key = $ApiKeyInfo['Value'];
	$API_Secret = $ApiSecretInfo['Value'];
	$Logo_Path = $LogoInfo['Value'];	
}
?>
<?php include_once('layout/header.php'); ?>
<?php include_once('layout/sidebar.php'); ?>

<!-- Page wrapper -->
<div class="page-wrapper">
	<!-- Bread crumb and right sidebar toggle -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-md-6 col-8 align-self-center">
				<h3 class="page-title mb-0 p-0">Config</h3>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Config</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Container fluid  -->
	<div class="container-fluid">
		<div class="col-lg-7 col-md-9">
			<div class="row card card-body">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-material col-md-10" enctype="multipart/form-data">
					<?php if($message != ''){ ?>
					<div style="width:100%; padding:5px; font-size:13px; font-weight:bold; color:#0f0; text-align:center;"><?php echo $message;?></div>
					<?php } ?>

					<div class="form-group">
						<label class="col-md-12 mb-0">Product License</label>
						<div class="col-md-12">
							<input name="ProductLicense" type="text" class="form-control pl-0 form-control-line" value="<?php if(isset($Product_License)){ echo $Product_License;} ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12 mb-0">Filevine API Key</label>
						<div class="col-md-12">
							<input name="ApiKey" type="text" class="form-control pl-0 form-control-line" value="<?php if(isset($API_Key)){ echo $API_Key;} ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12 mb-0">Filevine Key Secret</label>
						<div class="col-md-12">
							<input name="ApiSecret" type="text" class="form-control pl-0 form-control-line" value="<?php if(isset($API_Secret)){ echo $API_Secret;} ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12 mb-0">Logo</label>
						<div class="col-md-12">
							<input name="LogoFile" type="file">
							<span class="col-md-12 mb-0"><?php if(isset($Logo_Path)){ echo $Logo_Path;} ?></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12 d-flex">
							<button class="btn btn-success mx-auto mx-md-0 text-white">Update Config Data</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php include_once('layout/footer.php'); ?>
</div>

<!-- Footer asstes  -->
<?php include_once('layout/footer_assets.php'); ?>