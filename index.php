<?php
session_start();
require_once('Common/database.php');
require_once('Common/functions.php');
require_once('Common/common.php');
require_once('Common/filevine_api.php');

//Get Info By Client Name
if (isset($_POST['ClientName'])) {
    if (trim($_POST['ClientName']) != "") {

        $last_name = "";
        $first_name = "";

        $name_array = explode(",", $_POST['ClientName']);

        if (count($name_array) > 1) {
            $last_name = trim($name_array[0]);
            $first_name = trim($name_array[1]);
        } else {
            $last_name = trim($_POST['ClientName']);
        }
        // $first_name = "Polly";
        // $last_name = "Plaintiff";
        $phone_no = trim($_POST['PhoneNo']);

        $filevine_api = new Filevine_API();

        $result = array('success' => False, 'message' => '', 'clientName' => '', 'projectName' => '', 'projectEmail' => '', 'caseType' => '', 'createdDate' => '', 'attorneyName' => '', 'attorneyEmail' => '', 'attorneyPhone' => '', 'paralegalName' => '', 'paralegalEmail' => '', 'paralegalPhone' => '', 'legalassistantName' => '', 'legalassistantEmail' => '', 'legalassistantPhone' => '', 'clientrelationsName' => '');

        $project = $filevine_api->getProjectsByLastName($first_name, $last_name, 0);

        $project = json_decode($project, TRUE);

        foreach ($project['items'] as $each_project) {
            $projectId = $each_project['projectId']['native'];
            $clientId = $each_project['clientId']['native'];

            // Get the client's phone number and compare
            // $filevine_api->getContactByContactId($clientId);


            $params['projectId'] = $projectId;
            $casesummary = $filevine_api->getCaseSummary_Team($params);
            $casesummary = json_decode($casesummary, TRUE);
            if ($casesummary['primaryattorney'] == null or $casesummary['primaryattorney'] == null or $casesummary['primaryattorney'] == null)
                continue;

            $intakeInfo = $filevine_api->getIntakeInfo($projectId);
            $intakeInfo = json_decode($intakeInfo, TRUE);
            
            $result['attorneyName']         = $casesummary['primaryattorney']['fullname'];
            $result['attorneyEmail']        = $casesummary['primaryattorney']['emails'][0]['address'];
            $result['attorneyPhone']        = $casesummary['primaryattorney']['phones'][0]['number'];
            $result['paralegalName']        = $casesummary['paralegal']['fullname'];
            $result['paralegalEmail']       = $casesummary['paralegal']['emails'][0]['address'];
            $result['paralegalPhone']       = $casesummary['paralegal']['phones'][0]['number'];
            $result['legalassistantName']   = $casesummary['legalassistant']['fullname'];
            $result['legalassistantEmail']  = $casesummary['legalassistant']['emails'][0]['address'];
            $result['legalassistantPhone']  = $casesummary['legalassistant']['phones'][0]['number'];
            $result['clientName']           = $each_project['clientName'];
            $result['projectName']          = $each_project['projectName'];
            $result['projectEmail']         = $each_project['projectEmailAddress'];
            $result['caseType']             = $each_project['projectTypeCode'];
            // $result['solDate']              = $each_project['projectName'];
            $result['createdDate']          = $intakeInfo['dateofintake'];

            break;
        }
        $_SESSION['result'] = $result;
        var_dump($result);
        header("location: lookup.php");
    }
}

// Get Info By Project Id
if (isset($_POST['ProjectId'])) {
    if (trim($_POST['ProjectId']) != "") {
        $projectId = trim($_POST['ProjectId']);
        $params['projectId'] = $projectId;

        $filevine_api = new Filevine_API();

        $result = array('success' => False, 'message' => '', 'clientName' => '', 'projectName' => '', 'projectEmail' => '', 'caseType' => '', 'createdDate' => '', 'attorneyName' => '', 'attorneyEmail' => '', 'attorneyPhone' => '', 'paralegalName' => '', 'paralegalEmail' => '', 'paralegalPhone' => '', 'legalassistantName' => '', 'legalassistantEmail' => '', 'legalassistantPhone' => '', 'clientrelationsName' => '');

        $project = $filevine_api->getProjectsDetailsById($projectId);
        $project = json_decode($project, TRUE);

        $intakeInfo = $filevine_api->getIntakeInfo($projectId);
        $intakeInfo = json_decode($intakeInfo, TRUE);

        $casesummary = $filevine_api->getCaseSummary_Team($params);
        $casesummary = json_decode($casesummary, TRUE);

        $result['attorneyName'] = $casesummary['primaryattorney']['fullname'];
        $result['attorneyEmail'] = $casesummary['primaryattorney']['emails'][0]['address'];
        $result['attorneyPhone'] = $casesummary['primaryattorney']['phones'][0]['number'];
        $result['paralegalName'] = $casesummary['paralegal']['fullname'];
        $result['paralegalEmail'] = $casesummary['paralegal']['emails'][0]['address'];
        $result['paralegalPhone'] = $casesummary['paralegal']['phones'][0]['number'];
        $result['legalassistantName'] = $casesummary['legalassistant']['fullname'];
        $result['legalassistantEmail'] = $casesummary['legalassistant']['emails'][0]['address'];
        $result['legalassistantPhone'] = $casesummary['legalassistant']['phones'][0]['number'];
        $result['clientName'] = $project['clientName'];
        $result['projectName'] = $project['projectName'];
        $result['projectEmail'] = $project['projectEmailAddress'];
        $result['caseType'] = $project['projectTypeCode'];
        //$result['solDate'] = $each_project['projectName'];
        $result['createdDate'] = $intakeInfo['dateofintake'];
    }

    $_SESSION['result'] = $result;
    header("location: lookup.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>FileVine Connect Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href=""/>
	<link rel="stylesheet" type="text/css" href="./assets/css/main.css">
</head>
<body>
    <div class="main-container">
        <div class="container-login">
            <div class="wrap-login">
                <div class="logo">
                <?php
                $logo_img = get_logo();
                if ($logo_img != "") {
                ?>
                    <img src="<?php echo $logo_img; ?>" alt="Logo">
                <?php } else { ?>
                    <img src="./assets/images/icons/Logo.png" alt="Logo">
                <?php } ?>
                </div>

                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login-form validate-form">
                    <span class="login-form-title">Client Case Portal</span>
                    <div class="wrap-input validate-input" data-validate="Last name is required">
                        <input class="input" type="text" name="ClientName" placeholder="Last Name, First Name"/>
                    </div>
                    <div class="wrap-input validate-input">
                        <input name="PhoneNo" class="input" type="text" placeholder="Phone Number [5615555555]"/>
                    </div>
                    <span class="login-form-title">OR</span>
                    <div class="wrap-input validate-input">
                        <input name="ProjectId" class="input" type="text" placeholder="Project ID"/>
                    </div>
                    <div class="container-login-form-btn">
                        <input type="submit" class="login-form-btn" value="Login"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="./assets/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!-- <script src="./assets/vendor/bootstrap/js/bootstrap.min.js"></script> -->
</body>
</html>
