<?php 
require_once('../Common/common.php');

// Get POST Request Params and Change as array 
$payload = file_get_contents("php://input");
$payload = json_decode($payload, TRUE);
$webhook_params = $payload;	

// Record payload data to txt file on each event
$filename = "callrail_filter.txt";
record_payload($filename, $payload);

// Filter for the source_name
switch ($payload['source_name']) {
        case 'PSL Hotline';
        case 'PBC Hotline';
        case 'Newsletter - Print';
        case 'Newsletter - Email';
        case 'Direct Mail';
        case 'Partner Referral Hotline';
            // Zapier Webhook #1    
            $webhook_url = 'https://hooks.zapier.com/hooks/catch/2568133/o4pqkd0/';
            break;
        case 'Google Ads - Transport';
        case 'Google Ads - Premises';
        case 'Google Ads - Brand';
        case 'LOCG GMB';
        case 'LOCG Website';
            // Zapier Webhook #2
            $webhook_url 	= 'https://hooks.zapier.com/hooks/catch/2568133/odqfrzt/';
            break;
}

// BEGIN CURL REQUEST
// For only the filtered event, Open the cURL request to POST the data to an external third-party webhook. Pull the webhook URL and webhook Params defined above in the filtering.
var_dump($webhook_params);
if ( isset($webhook_url) and isset($webhook_params) ) 
    curl_zapierurl($webhook_url, $webhook_params);

?>