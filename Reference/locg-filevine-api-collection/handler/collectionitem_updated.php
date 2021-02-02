<?php 
require_once('../Common/common.php');
require_once('../Common/model.php');
require_once('../Common/filevine_api.php');

// $payload = '{"Timestamp":1571799624207,"Object":"Project","Event":"PhaseChanged","ObjectId":{"ProjectTypeId":19771,"SectionSelector":"insurance","ItemId":"c4d28bcf-5687-434c-8881-8f05ebf9f658"},"OrgId":5576,"ProjectId":5890587,"UserId":null,"Other":{"PhaseName":"Approved-Sign Up"}}';
// Get POST Request Params and Change as array 
$payload = file_get_contents("php://input");
$payload = json_decode($payload, TRUE);

// Record payload data to log.txt on each event
$filename = "collectionitem_updated.txt";
record_payload($filename, $payload);

// Get collection item information
$filevine_api = new Filevine_API();
$params = array('projectId' => $payload['ProjectId'], 'sectionSelector' => $payload['ObjectId']['SectionSelector'], 'uniqueId' => $payload['ObjectId']['ItemId']);
$collecton_item = $filevine_api->getCollectionItem($params);
$collecton_item = json_decode($collecton_item, TRUE);

// Filters for identifying settlement items that have notes written into them to trigger the Zapier webhook
if ( $collecton_item['dataObject']['offerdemandsettled'] == 'Settlement' && isset($collecton_item['dataObject']['notes'])) {
    $webhook_url    = 'https://hooks.zapier.com/hooks/catch/2568133/o4vejzj/';
    $webhook_params = $collecton_item;
    $webhook_params['ProjectId'] = $payload['ProjectId'];
}

// Add the event details to the DB
$insert_params = array('timestamp' => $payload['Timestamp'], 'project_id' => $payload['ProjectId'], 'section_selector' => $payload['ObjectId']['SectionSelector'], 'collectionitem_id' => $payload['ObjectId']['ItemId'], 'org_id' => $payload['OrgId'], 'webhook_url' => '');
if (isset($webhook_url)) 
    $insert_params['webhook_url'] = $webhook_url;
$model = new Model();
$model->addCollectionItemUpdatedEvent($insert_params);
$model->close();

// For only Filtered Event Open the cURL request to POST the data to an external third-party webhook. Pull the webhook URL and webhook Params defined above in the filtering.
if ( isset($webhook_url) and isset($webhook_params) ) 
    curl_zapierurl($webhook_url, $webhook_params);
?>