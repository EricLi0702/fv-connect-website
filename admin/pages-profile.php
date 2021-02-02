<?php
require_once ('session.php');
require_once ('../Common/database.php');
require_once ('../Common/functions.php');

$message = "";

if(isset($_POST['UserFullName']) && isset($_POST['UserEmail']))
{
	$user_name = $_POST['UserFullName'];
	$user_email = $_POST['UserEmail'];
	$user_password = $_POST['UserPassword'];

	if(isset($user_name) && isset($user_email)  && isset($user_password))
	{
		$db=new db();
		
		$userInfo = $db->query('select * from user where Email = ?', array($user_email));
		$user_count = $userInfo->numRows();
		
		if($user_count > 0)
		{
			$current_userid = $_SESSION["AdminUserId"];
			$userInfo2 = $db->query('select * from user where Id !=? AND Email = ?', array($current_userid, $user_email));
			$user_count2 = $userInfo->numRows();
			if($user_count2 == 0)
			{
				if(trim($user_password) == "")
					$db->query("update user set Full_name = '" . $user_name . "', Email = '" . $user_email . "', Updated_at = '" . date("Y-m-d H:i:s") . "' where Id=" . $current_userid);
				else
					$db->query("update user set Full_name = '" . $user_name . "', Email = '" . $user_email . "', Password = '" . md5($user_password) . "', Updated_at = '" . date("Y-m-d H:i:s") . "' where Id=" . $current_userid);
				
				$_SESSION["Full_name"] = $user_name;
				$_SESSION["AdminUserEmail"] = $user_email;
				
				$message = "Profile info successfully updated!";
			}	
		}
		else
		{
			header('location: ' . ROOTURL . 'admin/dash_board.php');
		}
	}
}
?>
<?php include_once('layout/header.php'); ?>
<?php include_once('layout/sidebar.php'); ?>

<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb and right sidebar toggle -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">Profile</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Container fluid  -->
    <div class="container-fluid">
        <div class="col-lg-6 col-xlg-9 col-md-7">
            <div class="row card card-body">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-material">
                    <?php
                    if($message != ''){
                   ?>
                    <div style="width:100%; padding:5px; font-size:13px; font-weight:bold; color:#0f0; text-align:center;"><?php echo $message;?></div>
                    <?php
                    }
                   ?>
                    <div class="form-group">
                        <label class="col-md-12 mb-0">Full Name</label>
                        <div class="col-md-12">
                            <input name="UserFullName" type="text" placeholder="Johnathan Doe"
                                class="form-control pl-0 form-control-line" value="<?php if(isset($_SESSION["Full_name"])){ echo $_SESSION["Full_name"];} ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-email" class="col-md-12">Email</label>
                        <div class="col-md-12">
                            <input name="UserEmail" type="email" placeholder="johnathan@admin.com"
                                class="form-control pl-0 form-control-line" name="example-email"
                                id="example-email" value="<?php echo $_SESSION["AdminUserEmail"];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 mb-0">Password</label>
                        <div class="col-md-12">
                            <input name="UserPassword" id="UserPassword" type="password" value="password"
                                class="form-control pl-0 form-control-line">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 d-flex">
                            <button class="btn btn-success mx-auto mx-md-0 text-white">Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once('layout/footer.php'); ?>
</div>

<!-- End Page wrapper  -->
<?php include_once('layout/footer_assets.php'); ?>