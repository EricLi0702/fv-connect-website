<?php 
require_once('../Common/common.php');
require_once('../Common/filevine_api.php');

// Get POST Request Params and Change as array 
$payload = file_get_contents("php://input");
$payload = json_decode($payload, TRUE);
$webhook_params = $payload;	

// Initiate new Filevine connection and call getContactInfo function
$filevine_api = new Filevine_API();
$contact = $filevine_api->getContactInfo($payload['ObjectId']['PersonId']);
$contact = json_decode($contact, TRUE);

// Test whether Date of Birth field exists; if it does, call the dedicated Zapier webhook. If it doesn't, do nothing.
if (isset($contact['birthDate'])) {
	$webhook_params = $contact;
	$webhook_url = 'https://hooks.zapier.com/hooks/catch/2568133/olrm7bo/';
	curl_zapierurl($webhook_url, $webhook_params);
}