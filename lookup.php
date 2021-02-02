<?php
session_start();
require_once('Common/database.php');
require_once('Common/functions.php');

$db = new db();

$info = $_SESSION['result'];
if ($info == "") {
    header("location: index.php");
}

// Get project data
$paralegal_status = 0;
$paralegal_name = $info['paralegalName'];
$paralegal_email = $info['paralegalEmail'];
$paralegal_phone = $info['paralegalPhone'];
if (trim($paralegal_name) != "") {
    $paralegal_status = 1;
}

$assistant_status = 0;
$assistant_name = $info['legalassistantName'];
$assistant_email = $info['legalassistantEmail'];
$assistant_phone = $info['legalassistantPhone'];
if (trim($assistant_name) != "") {
    $assistant_status = 1;
}

$attorney_status = 0;
$attorney_name = $info['attorneyName'];
$attorney_email = $info['attorneyEmail'];
$attorney_phone = $info['attorneyPhone'];
if (trim($attorney_name) != "") {
    $attorney_status = 1;
}

$client_relationslInfo = $db->query("select * from legalteam_config where Type='Client Relations Manager'")->fetchArray();
$client_relationsl_status = $client_relationslInfo['Status'];
$client_relationsl_name = $client_relationslInfo['Full_name'];
$client_relationsl_email = $client_relationslInfo['Email'];
$client_relationsl_phone = $client_relationslInfo['Phonenumber'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>FileVine Connect Lookup</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href=""/>
	<link rel="stylesheet" type="text/css" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/main.css">
</head>
<body>
	<?php $logo_img = get_logo(); ?>
	<div class="main-container">
		<div class="container-dash">
			<div class="wrap-dash">
				<div class="row">
					<!-- Client Case Portal -->
					<div class="col-md-3 col-sm-6">
						<div class="logo-left left-info">
							<div class="logo">
							<?php
								if($logo_img != "") {
							?>
								<img src="<?php echo $logo_img;?>" alt="Logo">
							<?php } else { ?>
								<img src="./assets/images/icons/Logo.png" alt="Logo">
							<?php } ?>
							</div>
                            <div class="dash-title">
                                <span>Client Case Portal</span>
                            </div>
                            <?php if ($paralegal_status > 0 || $assistant_status > 0 || $attorney_status > 0 || $client_relationsl_status > 0) { ?>
                            <div class="dash-sub">
                                <span>Assigned Team</span>
                            </div>
                            <?php } ?>

                            <!-- Paralegal -->
                            <?php if ($paralegal_status > 0) { ?>
                            <div class="dash-list">
                                <label>Paralegal</label>
                                <?php if ($paralegal_status == 1 || $paralegal_status == 2) { ?>
                                <ul>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-4">
                                                <span>Name:</span>
                                            </div>
                                            <div class="col-md-7 col-sm-8">
                                                <span><?php echo $paralegal_name; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-4">
                                                <span>Email Address:</span>
                                            </div>
                                            <div class="col-md-7 col-sm-8">
                                                <span class="active"><?php echo $paralegal_email; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-4">
                                                <span>Phone Number:</span>
                                            </div>
                                            <div class="col-md-7 col-sm-8">
                                                <span><?php echo $paralegal_phone; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <?php } ?>
                            </div>
                            <?php } ?>

                            <!-- Assistant -->
                            <?php if ($assistant_status > 0) { ?>
                            <div class="dash-list">
                                <label>Assistant</label>
                                <?php if ($assistant_status == 1 || $assistant_status == 2) { ?>
                                <ul>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-4">
                                                <span>Name:</span>
                                            </div>
                                            <div class="col-md-7 col-sm-8">
                                                <span><?php echo $assistant_name; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-4">
                                                <span>Email Address:</span>
                                            </div>
                                            <div class="col-md-7 col-sm-8">
                                                <span class="active"><?php echo $assistant_email; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-4">
                                                <span>Phone Number:</span>
                                            </div>
                                            <div class="col-md-7 col-sm-8">
                                                <span><?php echo $assistant_phone; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <?php } ?>
                            </div>
                            <?php } ?>

                            <!-- Attorney -->
                            <?php if ($attorney_status > 0) { ?>
                            <div class="dash-list">
                                <label>Attorney</label>
                                <?php if ($attorney_status == 1 || $attorney_status == 2) { ?>
                                <ul>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-4">
                                                <span>Name:</span>
                                            </div>
                                            <div class="col-md-7 col-sm-8">
                                                <span><?php echo $attorney_name; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-4">
                                                <span>Email Address:</span>
                                            </div>
                                            <div class="col-md-7 col-sm-8">
                                                <span class="active"><?php echo $attorney_email; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-4">
                                                <span>Phone Number:</span>
                                            </div>
                                            <div class="col-md-7 col-sm-8">
                                                <span><?php echo $attorney_phone; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <?php } ?>
                            </div>
                            <?php } ?>

                            <!-- Client Relations Manager -->
                            <?php if ($client_relationsl_status > 0) { ?>
                            <div class="dash-list">
                                <label>Client Relations Manager</label>
                                <ul>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-4">
                                                <span>Name:</span>
                                            </div>
                                            <div class="col-md-7 col-sm-8">
                                                <span><?php echo $client_relationsl_name; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-4">
                                                <span>Email Address:</span>
                                            </div>
                                            <div class="col-md-7 col-sm-8">
                                                <span class="active"><?php echo $client_relationsl_email; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-4">
                                                <span>Phone Number:</span>
                                            </div>
                                            <div class="col-md-7 col-sm-8">
                                                <span><?php echo $client_relationsl_phone; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <?php } ?>
                        </div>

						<!-- Logo Bottom -->
						<div class="logo-bottom">
							<div class="bottom-main">
								<img src="./assets/images/icons/bottom.png" alt="bottom">
								<div class="main-text">
									<h3>Chat With Us</h3>
									<p>Our Client Relations Manager is Available by chat M-F 8a-5p</p>
								</div>
							</div>
						</div>
					</div>

                    <!-- Project Lookup -->
                    <div class="col-md-9 col-sm-6">
                        <div class="main-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="dash-lists">
                                        <ul>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-5 col-sm-4">
                                                        <span>Client Name:</span>
                                                    </div>
                                                    <div class="col-md-7 col-sm-8">
                                                        <span><?php echo $info['clientName']; ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-5 col-sm-4">
                                                        <span>Project Name:</span>
                                                    </div>
                                                    <div class="col-md-7 col-sm-8">
                                                        <span><?php echo $info['projectName']; ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-5 col-sm-4">
                                                        <span>Case Email:</span>
                                                    </div>
                                                    <div class="col-md-7 col-sm-8">
                                                        <span class="active"><?php echo $info['projectEmail']; ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-5 col-sm-4">
                                                        <span>Case SMS Number:</span>
                                                    </div>
                                                    <div class="col-md-7 col-sm-8">
                                                        <span>(561)555-5555</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="dash-lists">
                                        <ul>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-5 col-sm-4">
                                                        <span>Case Type:</span>
                                                    </div>
                                                    <div class="col-md-7 col-sm-8">
                                                        <span><?php echo $info['caseType']; ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-5 col-sm-4">
                                                        <span>Signup Date:</span>
                                                    </div>
                                                    <div class="col-md-7 col-sm-8">
                                                        <span><?php echo $info['createdDate']; ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-5 col-sm-4">
                                                        <span>Upcoming SOL:</span>
                                                    </div>
                                                    <div class="col-md-7 col-sm-8">
                                                        <span>7/13/2024</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-right">
                            <div class="main-body">
                                <div class="main-body-list">
                                    <h3>Case Status:<span>Approved Sign-Up</span></h3>
                                    <p><b>Details:</b>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quam
                                        placeat sint voluptate esse sunt aliquam illo molestiae perspiciatis, dolore
                                        sit, cupiditate quae dolor! Vel aliquid possimus et aperiam harum ex?
                                        Details:</b>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quam
                                        placeat sint voluptate esse sunt aliquam illo molestiae perspiciatis, dolore
                                        sit, cupiditate quae dolor! Vel aliquid possimus et aperiam harum ex</p>
                                </div>
                                <div class="main-body-list">
                                    <h3>Case Status:<span>Initial Letters</span></h3>
                                    <p><b>Details:</b>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quam
                                        placeat sint voluptate esse sunt aliquam illo molestiae perspiciatis, dolore
                                        sit, cupiditate quae dolor! Vel aliquid possimus et aperiam harum ex?</p>
                                </div>
                            </div>
                            <div class="main-footer">
                                <div class="list-one">
                                    <div class="footer-list active">
                                        Initial<br />Phrase
                                    </div>
                                </div>
                                <div class="list-one">
                                    <div class="footer-list">
                                        Mediacal<br />Management
                                    </div>
                                </div>
                                <div class="list-one">
                                    <div class="footer-list singleword-tab">
                                        Demand
                                    </div>
                                </div>
                                <div class="list-one">
                                    <div class="footer-list singleword-tab">
                                        Nagotiation
                                    </div>
                                </div>
                                <div class="list-one">
                                    <div class="footer-list singleword-tab">
                                        Settlement
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<script src="./assets/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="./assets/vendor/bootstrap/js/popper.js"></script>
	<script src="./assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
