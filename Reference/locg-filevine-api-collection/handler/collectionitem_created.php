<?php 
require_once('../Common/common.php');
require_once('../Common/model.php');
require_once('../Common/filevine_api.php');

// Get POST Request Params and Change as array 
$payload = file_get_contents("php://input");
$payload = json_decode($payload, TRUE);

// Record payload data to log.txt on each event
$filename = "collectionitem_created.txt";
record_payload($filename, $payload);

// Get collection item information
$filevine_api = new Filevine_API();
$params = array('projectId' => $payload['ProjectId'], 'sectionSelector' => $payload['ObjectId']['SectionSelector'], 'uniqueId' => $payload['ObjectId']['ItemId']);
$collecton_item = $filevine_api->getCollectionItem($params);
$collecton_item = json_decode($collecton_item, TRUE);

// Filters for identifying specific collection items that require a custom webhook URL and then define the request body.
if ( $collecton_item['dataObject']['offerdemandsettled'] == 'Settlement' ) {
    $webhook_url    = 'https://hooks.zapier.com/hooks/catch/2568133/ou73ikm/';
    $webhook_params = $collecton_item;
    $webhook_params['ProjectId'] = $payload['ProjectId'];
}

// Add the event details to the DB
$insert_params = array('timestamp' => $payload['Timestamp'], 'project_id' => $payload['ProjectId'], 'section_selector' => $payload['ObjectId']['SectionSelector'], 'demand_type' => $collecton_item['dataObject']['offerdemandsettled'], 'collectionitem_id' => $payload['ObjectId']['ItemId'], 'org_id' => $payload['OrgId'], 'webhook_url' => '');
if (isset($webhook_url)) 
    $insert_params['webhook_url'] = $webhook_url;
$model = new Model();
$model->addCollectionItemCreatedEvent($insert_params);
$model->close();

// For only Filtered Event Open the cURL request to POST the data to an external third-party webhook. Pull the webhook URL and webhook Params defined above in the filtering.
if ( isset($webhook_url) and isset($webhook_params) ) 
    curl_zapierurl($webhook_url, $webhook_params);
?>