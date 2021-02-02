<?php 
require_once('../Common/common.php');
require_once('../Common/model.php');
require_once('../Common/filevine_api.php');

// Get POST Request Params and Change as array 
$payload = file_get_contents("php://input");
$payload = json_decode($payload, TRUE);

// Record payload data to project_phasechanged.txt on each event
$filename = "project_phasechanged.txt";
record_payload($filename, $payload);

// ..BEGIN EVENT FILTERING USING SWITCH
// ....Filtering for identifying events and then maps them with cooresponding custom webhook URLs
// ......Phase Name = Settled Pre-Suit or Settled-Lit
switch( $payload['Other']['PhaseName']) {
	case 'Settled-Pre-Suit';
	case 'Settled-Lit';
		$projectId = $payload['ProjectId'];
		$filevine_api = new Filevine_API();
		$intake_info = $filevine_api->getIntakeInfo($projectId);
		$intake_info = json_decode($intake_info, TRUE);
		$webhook_url = 'https://hooks.zapier.com/hooks/catch/2568133/o4v049w/';
		$webhook_params['payload'] = $payload;
		$webhook_params['intake_info'] = $intake_info;
		break;
		
// ......Phase Name = Discharge & Lit: Withdrawn
	case 'LIT: Withdrawn';
	case 'Discharged';
		$webhook_url = 'https://hooks.zapier.com/hooks/catch/2568133/otgorxj/';
		$webhook_params = $payload;	
		break;
		
// ......Phase Name = Approved-Sign Up
	case 'PC: Approved Sign Up':
		$webhook_url = 'https://hooks.zapier.com/hooks/catch/2568133/obdw76d/';
		$webhook_params = $payload;
		break;
		
// ......Phase Name = Turndown
	case 'PC: Turndown':
		$webhook_url = 'https://hooks.zapier.com/hooks/catch/2568133/otgo2x8/';
		$webhook_params = $payload;
		break;
		
// ......Phase Name = PC: Pending Additional Info
	case 'PC: Pending Additional Info':
		$webhook_url = 'https://hooks.zapier.com/hooks/catch/2568133/o57xyzg/';
		$webhook_params = $payload;	
		break;
		
// ......Phase Name = PC: Referred Out
	case 'PC: Referred Out':
		$webhook_url = 'https://hooks.zapier.com/hooks/catch/2568133/okuuj44/';
		$webhook_params = $payload;	
		break;

// ......Phase Name = PS: Medical Management
    case 'PS: Medical Management':
		$webhook_url = 'https://hooks.zapier.com/hooks/catch/2568133/owxshop/';
		$webhook_params = $payload;	
		break;
}

// ..BEGIN DATABASE INCLUSION
// ....Add the event details to the DB to be viewed in the API Dashboard
$insert_params = array('timestamp' => $payload['Timestamp'], 'project_id' => $payload['ProjectId'], 'phase_name' => $payload['Other']['PhaseName'], 'org_id' => $payload['OrgId'], 'webhook_url' => '');
if (isset($webhook_url)) 
    $insert_params['webhook_url'] = $webhook_url;
if ($insert_params['user_id'] == '')
    $insert_params['user_id'] = NULL;
$model = new Model();
$model->addProjectPhaseChangedEvent($insert_params);
$model->close();
// ..END DATABASE INCLUSION

// ..BEGIN CURL REQUEST
// For only the filtered event, Open the cURL request to POST the data to an external third-party webhook. Pull the webhook URL and webhook Params defined above in the filtering.
var_dump($webhook_params);
if ( isset($webhook_url) and isset($webhook_params) ) 
    curl_zapierurl($webhook_url, $webhook_params);
//..END CURL REQUEST
?>