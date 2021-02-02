<?php
session_start();

include '../Common/config.php';
include '../Common/database.php';
include '../Common/functions.php';

$error_message = "";

if(isset($_POST['useremail']) && isset($_POST['UserPassword'])) {
	$user_email = $_POST['useremail'];
	$user_password = $_POST['UserPassword'];

	if(isset($user_email) && isset($user_password)) {
		
		$db=new db();
		$userInfo = $db->query('select * from user where Email = ? AND Password = ?', array($user_email, md5($user_password)));
		$user_count = $userInfo->numRows();
		
		if($user_count > 0) {
			$user_data = $userInfo->fetchArray();
			$_SESSION["AdminUserId"] = $user_data['Id'];
			$_SESSION["Full_name"] = $user_data['Full_name'];
			$_SESSION["AdminUserEmail"] = $user_email;
			
			header('location: ' . ROOTURL . 'admin/dash_board.php');
		} else {
			$error_message = "Invalid login info!";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Law Attrorney</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href=""/>
	<link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
</head>
<body>
<?php 
$logo_img = get_logo();
?>
	<div class="main-container">
		<div class="container-login">
			<div class="wrap-login">
				<div class="logo">
					<?php
						$logo_img = get_logo();
						$logo_path = "../" . $logo_img;
						If(file_exists($logo_path)) {
					?>
					<img src="<?php echo $logo_path;?>" alt="Logo">
					<?php } else { ?>
					<img src="../assets/images/icons/Logo.png" alt="Logo">
					<?php } ?>
				</div>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login-form validate-form">
					<?php
					if($error_message != ''){
					?>
					<div style="width:100%; padding:5px; font-size:13px; font-weight:bold; color:#f00; text-align:center;"><?php echo $error_message;?></div>
					<?php
					}
					?>
					<span class="login-form-title">
						Admin Credential
					</span>

					<div class="wrap-input validate-input" data-validate = "User email is required">
						<input class="input" type="email" name="useremail" placeholder="Enter your email" required />
					</div>
					
					<div class="wrap-input validate-input" data-validate = "Password is required">
						<input name="UserPassword" class="input" type="password" placeholder="Enter Your Password" required /> 
					</div>

					<div class="container-login-form-btn">
						<input type="submit" class="login-form-btn" value="Login" />
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="../assets/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>