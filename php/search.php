<?php 
// require_once('../Common/common.php');
// require_once('../Common/model.php');
require_once ('./Common/filevine_api.php');

$firstname = "Polly";
$lastname = "Plaintiff";

// $firstname = $_POST["firstname"];
// $lastname = $_POST["lastname"];
$filevine_api = new Filevine_API();


$result = array('success' => False, 'message' => '', 'attorneyName' => '', 'paralegalName' => '', 'paralegalEmail' => '', 'legalassistantName' => '', 'legalassistantEmail' => '');

$project = $filevine_api->getProjectsByLastName($firstname, $lastname);
$project = json_decode($project, TRUE);

// if ($project['count'] == 0) {
//     $result['message'] = "There is no contact with ".$firstname;
//     echo json_encode($result);
//     return;
// } else if ($project['count'] > 1) {
//     $result['message'] = "There are ".$project['count']." contacts with ".$firstname;
//     echo json_encode($result);
//     return;
// }
// var_dump($project);exit();

foreach ($project['items'] as $each_project) {
    $projectId = $each_project['projectId']['native'];
    $params['projectId'] = $projectId;
    echo $projectId;

    $casesummary = $filevine_api->getCaseSummary_Team($params);
    $casesummary = json_decode($casesummary, TRUE);
    var_dump($casesummary);
    if ($casesummary['primaryattorney'] == null or $casesummary['primaryattorney'] == null or $casesummary['primaryattorney'] == null)
        continue;
    
    // $result['attorneyName'] = $casesummary['primaryattorney']['fullname'];    
    // $result['paralegalName'] = $casesummary['paralegal']['fullname'];
    // $result['paralegalEmail'] = $casesummary['paralegal']['emails'][0]['address'];    
    // $result['legalassistantName'] = $casesummary['legalassistant']['fullname'];
    // $result['legalassistantEmail'] = $casesummary['legalassistant']['emails'][0]['address'];

    $result['paralegal'] = ['name'=> $casesummary['paralegal']['fullname']];
    break;
}

if ($result['attorneyName'] == "") {
    $result['success'] = False;
    $result['message'] = "There is no available data!!!";
} else {
    $result['success'] = True;
    $result['message'] = "Successfully the client looked up!!!";
}

// echo $result;
echo json_encode($result);
     
?>