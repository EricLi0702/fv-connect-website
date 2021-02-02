<?php 
require_once('../Common/common.php');
require_once('../Common/model.php');
require_once('../Common/filevine_api.php');

if(isset($_POST["operation"])) {

    $operation = $_POST["operation"];
    if ($operation == "contact") {
        $filename = $_POST["filename"];
        $csv_content_array = convertCSVtoArray($filename);
        $contacts = convertCSVArraytoContactsArray($csv_content_array);

        $filevine_api = new Filevine_API();
        $results = array();

        foreach ($contacts as $csv_contact) {

            $added = -1;
            // At first check whether the contact with the Full Name exists or not
            $contact = $filevine_api->getContactByFullName($csv_contact['fullName']);
            $contact = json_decode($contact, TRUE);
            if ($contact['count'] != 0) {
                $results[] = "The ".$contact['count']." contacts with same full name '".$csv_contact['fullName']."' exist.";
                continue;
            } 
            
            // If there are no contacts with same fullname, then it creates the contact
            $contact = $filevine_api->createContact($csv_contact);
            $contact = json_decode($contact, TRUE);
            // Check create contact API succeeds or not
            if (array_key_exists("message", $contact)) {
                $added = 1;
            } else if (array_key_exists("personId", $contact) and array_key_exists("native", $contact['personId'])){
                $added = 2;
            }

            $result = $csv_contact['fullName'];
            if ($added == 1) {
                $result .= " is not added as ".$contact['message'];
            } else if ($added == 2) {
                $result .= " is added successfully.";
            }

            $results[] = $result;
        }

        echo json_encode(array('result' => $results));
        
    } else if ($operation == "personType") {
        $filename = $_POST["filename"];
        $csv_content_array = convertCSVtoArray($filename);
        $contacts = convertCSVArraytoPersonTypesArray($csv_content_array);
        
        $filevine_api = new Filevine_API();
        $results = array();
        
        foreach ($contacts as $csv_contact) {
            
            $csv_contact['personTypes'] = convertPersonTypes($csv_contact['personTypes']);
            
            // Check whether the contact with fullname exist or not and only one exists or not
            $contact = $filevine_api->getContactByFullName($csv_contact['fullName']);
            $contact = json_decode($contact, TRUE);
//            var_dump($contact);
            if ($contact['count'] == 0) {
                $results[] = "The contact with '".$csv_contact['fullName']."' does not exist.";
                continue;
            } else if ($contact['count'] > 1) { 
                $results[] = "The ".$contact['count']." contacts with same full name '".$csv_contact['fullName']."' exist.";
                continue;
            }
            
            // If there is only one contact with same fullname, then it adds the new person type
            $contactId = $contact['items'][0]['personId']['native'];
            $personTypes = $contact['items'][0]['personTypes'];
//            var_dump($contactId);
            $added = -1;
            if ($contactId == null) {
                $added = -1;
            } else {
                // Add PersonType
                $new_personType = $csv_contact['personTypes'];

                // Fix the Backend API Error of "Frim" instead of "Firm"
                if (in_array($new_personType, $personTypes) == False) {
                    $added = 1;
                    array_push($personTypes, $new_personType);    

                    // Prepare Post Fields
                    $params = array('personTypes' => $personTypes);
                    $contact = $filevine_api->updateContact($contactId, $params);
    //                 $contact = json_decode($contact, TRUE);
    //                 $personTypes = $contact['personTypes'];
                    $added = 2;
                } else {
                    $added = 0;
                }
            }
    //        var_dump($added);
            $result = $csv_contact['fullName']." 's '".$new_personType."' personType ";
            if ($added == -1) {
                $result = $csv_contact['fullName']." is not existing.";
            } else if ($added == 0) {
                $result .= "is already in there.";
            } else if ($added == 1) {
                $result .= "is not added due to API connection problem.";
            } else if ($added == 2) {
                $result .= "is added successfully.";
            }
            $results[] = $result;
        }
        
        echo json_encode(array('result' => $results));
    }
}

// $filename = 'mass_contacts-to-create.csv';


function convertCSVArraytoContactsArray($csv_content_array) {
    
    $result = [];
    
    if (count($csv_content_array) <= 1)
        return $result;
    
    $headere_row = $csv_content_array[0];
    for( $i = 1; $i < count($csv_content_array); $i++) {
        
        $contact = array('emails' => array(array()), 'phones' => array(array()), 'addresses' => array(array()));
        $contact = [];
        $row = $csv_content_array[$i];
    
        // Map the contacts with Header
        for ( $j = 0; $j < count($row); $j++) {
            $key = $headere_row[$j];
            $value = trim($row[$j]);
            switch ( $key ) {
                case "fullName":
                    $names = explode(" ", $value);
                    $contact["firstName"] = $names[0];
                    $contact["lastName"] = $names[1]; 
                    $contact["fullName"] = $value;  
                    break;
                case "emails[address]":         $contact['emails'][0]['address'] = $value;         break;
                case "emails[label]":           $contact['emails'][0]['label'] = $value;           break;
                case "phones[label]":           $contact['phones'][0]['label'] = $value;           break;
                case "phones[number]":          $contact['phones'][0]['number'] = $value;          break;
                case "addresses[line1]":        $contact['addresses'][0]['line1'] = $value;        break;
                case "addresses[city]":         $contact['addresses'][0]['city'] = $value;         break;
                case "addresses[state]":        $contact['addresses'][0]['state'] = $value;        break;
                case "addresses[postalCode]":   $contact['addresses'][0]['postalCode'] = $value;   break;
                case "addresses[label]":        $contact['addresses'][0]['label'] = $value;        break;
                case "personTypes":             $contact["personTypes"] = [convertPersonTypes($value)];             break;
                case "notes":                   $contact["notes"] = $value;                     break;
            }
        }
        
        $result[] = $contact;
    }
    
    return $result;
}

// Convert the CSV Content of Person Types into contactid-persontype to add array
function convertCSVArraytoPersonTypesArray($csv_content_array) {
    
    $result = [];
    
    if (count($csv_content_array) <= 1)
        return $result;
    
    $headere_row = $csv_content_array[0];
    for( $i = 1; $i < count($csv_content_array); $i++) {
        
        $contact = [];
        $row = $csv_content_array[$i];
    
        // Map the contacts with Header
        for ( $j = 0; $j < count($row); $j++) {
            $key = $headere_row[$j];
            $value = trim($row[$j]);
            switch ( $key ) {
                case "fullName":    $contact["fullName"] = $value;      break;
                case "personTypes":  $contact["personTypes"] = $value;   break;
            }
        }
        
        $result[] = $contact;
    }
    
    return $result;
}

function convertPersonTypes($personType) {
        
    $persontypes_array = array('Firm' => 'Firm', 'Insurance Company' => 'InsuranceCompany', 'Involved Party' => 'InvolvedParty', 'Medical Provider' => 'MedicalProvider');
    if (array_key_exists($personType, $persontypes_array)) {
        $personType =  $persontypes_array[$personType];
    }

    return $personType;
}
?>